import socket
import requests
import psutil
import platform
from getmac import get_mac_address
from datetime import datetime, timezone
import os
import string
import ctypes
import re
import subprocess
import time
import argparse
import threading
import sys
import base64
import importlib

# Optional watchdog import: if not available, we'll fall back to polling.
try:
    from watchdog.observers import Observer  # type: ignore
    from watchdog.events import FileSystemEventHandler  # type: ignore
    _HAS_WATCHDOG = True

except Exception:
    _HAS_WATCHDOG = False

# Ensure stdout/stderr can handle Unicode (emoji) without raising UnicodeEncodeError on Windows
try:
    # Python 3.7+: reconfigure the text I/O to use UTF-8 and replace errors
    if hasattr(sys.stdout, 'reconfigure'):
        sys.stdout.reconfigure(encoding='utf-8', errors='replace')
    if hasattr(sys.stderr, 'reconfigure'):
        sys.stderr.reconfigure(encoding='utf-8', errors='replace')
except Exception:
    # best-effort; if it fails we will handle errors elsewhere
    pass

# note:: nyampe error WPARAM win10toast ( Sudah done ) tinggal lanjut build exe tanpa console, nanti di runing dan di test di pc client user

# ============================
# Prefer plyer and PowerShell balloon for notifications.
# We intentionally do NOT initialise win10toast here because its pywin32
# integration can cause WNDPROC-related TypeErrors on some systems.
# If you want to enable win10toast, install it and set _TOASTER manually.
_TOASTER = None

# plyer is imported lazily inside notify_user to avoid frozen-binary import issues

# ============================
# Notifications and config (restored)
_LAST_NOTIFY = 0.0
_MIN_NOTIFY_INTERVAL = 5.0
_NOTIFIED_KEYS = set()
_NOTIFY_FALLBACK_TRIED = False
_LAST_SEND_TS = 0.0
_MIN_SEND_INTERVAL = float(os.environ.get('APPDETECTOR_SEND_DELAY_MS', '150')) / 1000.0
_SENT_RECORDS = set()
_NOTIFY_COUNTS = {}


def _ps_show_balloon(title: str, message: str, timeout: int = 6):
    try:
        # Build a small PowerShell snippet that loads WinForms and shows a NotifyIcon balloon.
        # We encode the command as UTF-16LE base64 to avoid any quoting/escaping problems
        # across PowerShell versions (especially older PowerShell on Win7/10).
        ps_script = (
            "[Reflection.Assembly]::LoadWithPartialName('System.Windows.Forms') | Out-Null;"
            "[Reflection.Assembly]::LoadWithPartialName('System.Drawing') | Out-Null;"
            "$n = New-Object System.Windows.Forms.NotifyIcon;"
            "$n.Icon = [System.Drawing.SystemIcons]::Information;"
            "$n.Visible = $true;"
            f"$n.ShowBalloonTip({int(timeout*1000)}, \"{title}\", \"{message}\", [System.Windows.Forms.ToolTipIcon]::None);"
            f"Start-Sleep -Milliseconds {int(timeout*1000)}; $n.Dispose();"
        )

        # Encode to UTF-16LE base64 for use with -EncodedCommand to avoid quoting issues.
        encoded = base64.b64encode(ps_script.encode('utf-16-le')).decode('ascii')

        if os.name == 'nt':
            try:
                CREATE_NO_WINDOW = 0x08000000
                si = subprocess.STARTUPINFO()
                si.dwFlags |= subprocess.STARTF_USESHOWWINDOW
                si.wShowWindow = subprocess.SW_HIDE
                # Use -EncodedCommand which is more robust across PowerShell versions
                subprocess.Popen(['powershell', '-NoProfile', '-EncodedCommand', encoded], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, startupinfo=si, creationflags=CREATE_NO_WINDOW)
                return True
            except Exception:
                try:
                    subprocess.Popen(['powershell', '-NoProfile', '-EncodedCommand', encoded], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
                    return True
                except Exception:
                    return False
        else:
            try:
                subprocess.Popen(['powershell', '-NoProfile', '-EncodedCommand', encoded], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
                return True
            except Exception:
                return False
    except Exception:
        return False


def _wshell_popup(title: str, message: str, timeout: int = 6):
    try:
        ps_cmd = (
            "$ws = New-Object -ComObject WScript.Shell; "
            f"$null = $ws.Popup(\"{message}\", {int(timeout)}, \"{title}\", 64)"
        )
        if os.name == 'nt':
            try:
                CREATE_NO_WINDOW = 0x08000000
                si = subprocess.STARTUPINFO()
                si.dwFlags |= subprocess.STARTF_USESHOWWINDOW
                si.wShowWindow = subprocess.SW_HIDE
                subprocess.Popen(['powershell', '-NoProfile', '-Command', ps_cmd], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, startupinfo=si, creationflags=CREATE_NO_WINDOW)
                return True
            except Exception:
                try:
                    subprocess.Popen(['powershell', '-NoProfile', '-WindowStyle', 'Hidden', '-Command', ps_cmd], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
                    return True
                except Exception:
                    return False
        return False
    except Exception:
        return False


def notify_user(title: str, message: str, duration: int = 6):
    try:
        now = time.time()
        global _LAST_NOTIFY
        if now - _LAST_NOTIFY < _MIN_NOTIFY_INTERVAL:
            return
        _LAST_NOTIFY = now
    except Exception:
        pass
    mode = os.environ.get('APPDETECTOR_NOTIFY_MODE', 'auto').strip().lower()

    # Try higher-level libraries first (plyer, win10toast) which provide a consistent
    # experience across Windows versions. Fall back to PowerShell balloons and finally
    # WSH popup and console print.
    # 1) plyer
    try:
        if mode in ('auto', 'plyer'):
            plyer = importlib.import_module('plyer.notification')
            try:
                plyer.notify(title=title, message=message, timeout=duration)
                return
            except Exception:
                pass
    except Exception:
        pass

    # 2) win10toast (toasts on Win10/11) - works better on modern Windows
    try:
        if mode in ('auto', 'toast', 'win10toast'):
            w10 = importlib.import_module('win10toast')
            try:
                toaster = w10.ToastNotifier()
                # threaded=True so it doesn't block; fall back if not supported
                toaster.show_toast(title, message, duration=duration, threaded=True)
                return
            except Exception:
                pass
    except Exception:
        pass

    # 3) PowerShell balloon (best-effort, encoded to avoid quoting problems)
    try:
        if mode in ('auto', 'balloon'):
            ok = _ps_show_balloon(title, message, timeout=duration)
            if ok and mode != 'popup':
                return
    except Exception:
        pass

    # 4) WSH popup as a final interactive fallback
    global _NOTIFY_FALLBACK_TRIED
    try:
        if not _NOTIFY_FALLBACK_TRIED or mode == 'popup':
            _NOTIFY_FALLBACK_TRIED = True
            if _wshell_popup(title, message, timeout=duration):
                return
    except Exception:
        pass

    # 5) Last resort: print to stdout/stderr so operator can still see the message in logs
    try:
        print(f"NOTIFY: {title} - {message}")
    except Exception:
        pass

# API and keywords
API_URL = os.environ.get('APPDETECTOR_API_URL', "http://192.168.1.226:8000/api/report-crack")
# Suspicious keywords used for filename/token matching.
# Keep this list lowercase and avoid duplicates. Add product family tokens rather than many variants.
SUSPICIOUS_KEYWORDS = [
    "crack",
    "portable",
    # Adobe family
    "photoshop",
    "illustrator",
    "adobe photoshop",
    "adobe illustrator",
    # Corel
    "coreldraw",
    # CAD / CAE
    "catia",
    "nx siemens",
    "cad",
    "dassault",
    # Other common creative/utility apps often targeted
    "wondershare",
    "sketchup",
    # generic tokens
    "keygen",
    "patch",
    "activator"
]
ILLEGAL_KEYWORDS = {"crack", "keygen", "cracked",
                    "photoshop", "illustrator", "coreldraw", "catia", "nx siemens", "cad", "dassault", "wondershare", "sketchup"}
PORTABLE_TOKENS = {"portable"}
FRAMEWORK_TOKENS = {"net45", "net40", "win8", "win81", "wpa81", "wp8", "sl5", "uap", "mono", "xamarin"}
API_DEDUPE_CHECK = os.environ.get('APPDETECTOR_DEDUPE_URL')
if not API_DEDUPE_CHECK:
    if '/report-crack' in API_URL:
        API_DEDUPE_CHECK = API_URL.replace('/report-crack', '/dedupe-check')
    else:
        API_DEDUPE_CHECK = API_URL.rsplit('/', 1)[0] + '/dedupe-check'


def get_installed_apps():
    apps = []
    if platform.system() == "Windows":
        try:
            installed_apps = os.popen('wmic product get name').read()
            apps = installed_apps.lower().split('\n')
        except Exception as e:
            print("Failed to fetch application list:", e)
    return apps


def get_all_local_drives(include_types=(2, 3)):
    drives = []
    for letter in string.ascii_uppercase:
        drive = f"{letter}:\\"
        try:
            drive_type = ctypes.windll.kernel32.GetDriveTypeW(drive)
        except Exception:
            drive_type = 0
        if drive_type in include_types:
            drives.append(drive)
    return drives

def scan_drives_for_suspicious_files():
    """Scan all local drives and return suspicious paths with per-drive fairness.

    High priority: ILLEGAL_KEYWORDS in name/dir; Low priority: SUSPICIOUS_KEYWORDS with suspicious extensions.
    Merge round-robin across drives so even with a small send budget, each drive is represented.
    """
    suspicious_extensions = {
        '.exe', '.msi', '.msp', '.bat', '.cmd', '.vbs', '.js', '.jse', '.ps1', '.reg',
        '.zip', '.rar', '.7z', '.iso'
    }
    safe_extensions = ['.pdf', '.docx', '.xlsx', '.txt', '.php', '.conf', '.py', '.pyc', '.php',
                       '.nupkg', '.nuspec', '.sha512', '.json', '.xml', '.svg', '.gz']
    skip_keywords = [
        'windows', 'windows portable', 'windowsapps', 'windows defender',
        'windowsportabledevices', 'laragon','xampp', 'microsoft visual','git',
        'node_modules', 'bower_components', 'appdata\\local\\bower', 'bower\\cache\\packages',
        '\\._gradle_\\wrapper\\dists'.replace('_',''), '\\._gradle_\\'.replace('_',''),
        '\\cache\\packages\\', '\\gradle\\', '\\npm\\', '\\yarn\\',
        '\\._nuget_\\'.replace('_',''), '\\packages\\'
    ]
    recycle_keywords = ['$recycle.bin', 'recycler', 'recycled', 'recycle bin', 'system volume information', 'desktop.ini', 'thumbs.db']
    skip_keywords.extend(recycle_keywords)
    extra_ex = os.environ.get('APPDETECTOR_EXCLUDE_PATTERNS', '')
    if extra_ex:
        for p in re.split(r'[;,]', extra_ex):
            p = p.strip().lower()
            if p:
                skip_keywords.append(p)

    drives = get_all_local_drives()
    try:
        print('[i] Drives to scan:', ', '.join(drives) if drives else '<none>')
    except Exception:
        pass

    detections = []
    seen = set()

    for drive in drives:
        try:
            print(f'[i] Scanning drive: {drive}')
        except Exception:
            pass
        for root, dirs, files in os.walk(drive, topdown=True):
            root_lower = os.path.abspath(root).lower()
            if any(skip_kw in root_lower for skip_kw in skip_keywords) or root_lower.startswith('\\'):
                continue
            try:
                dirs[:] = [d for d in dirs if not any(skip_kw in os.path.join(root_lower, d).lower() for skip_kw in skip_keywords)]
            except Exception:
                pass

            # Directory name detection (illegal keywords)
            try:
                for dname in list(dirs):
                    d_tokens = _normalize_tokens(dname)
                    if d_tokens & ILLEGAL_KEYWORDS:
                        pth = os.path.join(root, dname)
                        norm = os.path.normcase(os.path.abspath(pth))
                        if norm not in seen:
                            seen.add(norm)
                            detections.append(pth)
            except Exception:
                pass

            for name in files:
                ext = os.path.splitext(name)[1].lower()
                if ext in safe_extensions:
                    continue
                name_tokens = _normalize_tokens(name)
                # Illegal keywords override
                if name_tokens & ILLEGAL_KEYWORDS:
                    pth = os.path.join(root, name)
                    norm = os.path.normcase(os.path.abspath(pth))
                    if norm not in seen:
                        seen.add(norm)
                        detections.append(pth)
                    continue

                if ext not in suspicious_extensions:
                    continue
                # Avoid framework-targeted "portable" libraries
                if 'portable' in name_tokens and (name_tokens & FRAMEWORK_TOKENS):
                    continue
                if name_tokens & set(SUSPICIOUS_KEYWORDS):
                    pth = os.path.join(root, name)
                    norm = os.path.normcase(os.path.abspath(pth))
                    if norm not in seen:
                        seen.add(norm)
                        detections.append(pth)

    return detections

def send_log(source, app_name, path=None, detected_at=None):
    """Send a detection log to the server with local notify, dedupe and throttling."""
    try:
        pc_name = socket.gethostname()
        user_name = os.getlogin()
        ip_address = socket.gethostbyname(pc_name)
        mac_address = get_mac_address()
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S') if detected_at is None else detected_at
    except Exception as e:
        print(f"Failed to retrieve system info: {e}")
        return

    data = {
        'pc_name': pc_name,
        'user_name': user_name,
        'app_name': app_name,
        'source': source,
        'path': path if path else None,
        'detected_at': None if app_name is None else now,
        'ip_address': ip_address,
        'mac_address': mac_address,
    }

    # Aggregate notification counts per-run instead of notifying per-detection.
    try:
        name_for_class = app_name if app_name else (os.path.basename(path) if path else '')
        cls = _classify_detection(name_for_class, path)
        if cls:
            _NOTIFY_COUNTS[cls] = _NOTIFY_COUNTS.get(cls, 0) + 1
    except Exception:
        pass

    # Client-side dedupe (per process run) to avoid sending the same record multiple times
    dedupe_key = None
    try:
        if source and source.lower().startswith('installed'):
            dedupe_key = f"installed:{(app_name or '').strip().lower()}"
        elif path:
            try:
                real = os.path.realpath(path)
                dedupe_key = f"file:{os.path.normcase(os.path.abspath(real))}"
            except Exception:
                try:
                    dedupe_key = f"file:{os.path.normcase(os.path.abspath(path))}"
                except Exception:
                    dedupe_key = f"file:{(path or '').strip().lower()}"
    except Exception:
        dedupe_key = None

    if dedupe_key and dedupe_key in _SENT_RECORDS:
        print(f"[i] Already sent (client-side), skipping: {dedupe_key}")
        return True

    # Optional server-side dedupe
    try:
        server_has = None
        if API_DEDUPE_CHECK:
            try:
                if source and source.lower().startswith('installed'):
                    server_has = check_server_has_record('installed_app', pc_name=pc_name, app_name=app_name)
                elif path:
                    server_has = check_server_has_record('suspicious_file', pc_name=pc_name, path=path)
            except Exception:
                server_has = None

        if server_has is True:
            print(f"[i] Server already has this record: {app_name or path} (skipping)")
            # mark as sent locally to avoid future duplicates in this process
            try:
                if dedupe_key:
                    _SENT_RECORDS.add(dedupe_key)
            except Exception:
                pass
            return True

        # Client-side pacing
        try:
            global _LAST_SEND_TS
            now_ts = time.time()
            dt = now_ts - _LAST_SEND_TS
            if dt < _MIN_SEND_INTERVAL:
                time.sleep(_MIN_SEND_INTERVAL - dt)
            _LAST_SEND_TS = time.time()
        except Exception:
            pass

        # Exponential backoff parameters
        BACKOFF_MAX_RETRIES = int(os.environ.get('APPDETECTOR_BACKOFF_MAX_RETRIES', '5'))
        BACKOFF_BASE_SECONDS = float(os.environ.get('APPDETECTOR_BACKOFF_BASE_SECONDS', '1.0'))
        succeeded = False
        last_exception = None
        for attempt in range(1, BACKOFF_MAX_RETRIES + 1):
            try:
                headers = {'Accept': 'application/json'}
                res = requests.post(API_URL, json=data, headers=headers, timeout=10)
                if res.status_code in (200, 201):
                    print("[✓] Log sent:", source if app_name is None else app_name)
                    try:
                        if dedupe_key:
                            _SENT_RECORDS.add(dedupe_key)
                    except Exception:
                        pass
                    succeeded = True
                    break

                # If server signals rate-limit, respect Retry-After header when present
                if res.status_code == 429:
                    ra = res.headers.get('Retry-After')
                    try:
                        sec = int(str(ra).strip()) if ra else None
                    except Exception:
                        sec = None
                    if sec and sec > 0:
                        sleep_for = min(sec, 60)
                        print(f"[i] Received 429, honoring Retry-After: sleeping {sleep_for}s (attempt {attempt})")
                        time.sleep(sleep_for)
                        continue

                body = res.text
                snippet = (body[:1000] + '...') if body and len(body) > 1000 else body
                print("[X] Failed to send log:", res.status_code, snippet)
                try:
                    print("Response headers:", dict(res.headers))
                except Exception:
                    pass

                # For other 4xx/5xx, perform backoff and retry
                backoff = BACKOFF_BASE_SECONDS * (2 ** (attempt - 1))
                # add jitter up to 30%
                jitter = backoff * 0.3 * (0.5 - (time.time() % 1))
                sleep_for = max(0.1, backoff + jitter)
                print(f"[i] Backing off for {sleep_for:.1f}s before retry (attempt {attempt})")
                time.sleep(min(sleep_for, 60))
            except Exception as e:
                last_exception = e
                # network or serialization error: backoff and retry
                backoff = BACKOFF_BASE_SECONDS * (2 ** (attempt - 1))
                jitter = backoff * 0.3 * (0.5 - (time.time() % 1))
                sleep_for = max(0.1, backoff + jitter)
                print(f"[ERR] Exception when sending (attempt {attempt}): {e}; backing off {sleep_for:.1f}s")
                time.sleep(min(sleep_for, 60))

        if not succeeded:
            print('[ERR] Failed to send after retries.')
            # Persist failed payloads to local file for later inspection/retry
            try:
                failed_path = os.path.join(os.path.dirname(__file__), 'failed_sends.jsonl')
                with open(failed_path, 'a', encoding='utf-8') as fh:
                    # store minimal context per-line
                    entry = {'ts': datetime.now(timezone.utc).isoformat(), 'source': source, 'app_name': app_name, 'path': path, 'data': data}
                    fh.write((requests.utils.json.dumps(entry, ensure_ascii=False) + '\n'))
                print(f"[i] Persisted failed send to: {failed_path}")
            except Exception as e:
                print('[ERR] Could not persist failed send:', e)
    except Exception as e:
        print('[ERR] Exception when sending:', str(e))
    return True




def check_server_has_record(record_type: str, pc_name: str = None, app_name: str = None, path: str = None):
    """Query server dedupe endpoint. Returns True/False or None on error."""
    if not API_DEDUPE_CHECK:
        return None
    payload = {'type': record_type}
    if pc_name:
        payload['pc_name'] = pc_name
    if app_name:
        payload['app_name'] = app_name
    if path:
        payload['path'] = path

    try:
        headers = {'Accept': 'application/json'}
        # optional API key header if present in env
        api_key = os.environ.get('APPDETECTOR_API_KEY')
        if api_key:
            headers['X-API-KEY'] = api_key
        res = requests.post(API_DEDUPE_CHECK, json=payload, headers=headers, timeout=8)
        if res.status_code == 200:
            try:
                j = res.json()
                if isinstance(j, dict) and 'exists' in j:
                    return bool(j.get('exists'))
            except Exception:
                return None
        return None
    except Exception:
        return None


def _normalize_tokens(s: str):
    """Return a set of lowercased alphanumeric tokens from a string."""
    if not s:
        return set()
    # remove extension and split on non-alphanumerics
    s_no_ext = os.path.splitext(s)[0]
    parts = re.split(r'[^a-zA-Z0-9]+', s_no_ext.lower())
    return set([p for p in parts if p])


def _classify_detection(name: str, path: str = None):
    """Heuristic classification: 'illegal', 'portable', 'installed', or 'unknown'."""
    tokens = _normalize_tokens(name)
    if tokens & ILLEGAL_KEYWORDS:
        return 'illegal'
    if tokens & PORTABLE_TOKENS:
        return 'portable'
    if path:
        p = path.lower()
        if 'program files' in p or '\\program files' in p or '\\windows\\' in p:
            return 'installed'
    return 'unknown'


def flush_notifications():
    """Send a single summary notification representing accumulated detections and reset counters."""
    try:
        if not _NOTIFY_COUNTS:
            return
        parts = []
        for k, v in list(_NOTIFY_COUNTS.items()):
            if v and v > 0:
                parts.append(f"{v} {k}")
        if not parts:
            _NOTIFY_COUNTS.clear()
            return
        # prefer Warning if any illegal found; use user-requested wording
        title = 'AppDetector - Notice'
        if _NOTIFY_COUNTS.get('illegal', 0) > 0:
            title = 'AppDetector - Warning'
            count = _NOTIFY_COUNTS.get('illegal', 0)
            # Use the exact phrasing requested by the user. Keep grammar as-is per request.
            message = f'Indication of ({count}) illegal were found'
        else:
            # count = _NOTIFY_COUNTS.get('illegal', 0)
            message = 'Detected: ' + ', '.join(parts)
            # message = f'Indication of ({count}) illegal were found'
        notify_user(title, message, duration=8)
    except Exception:
        pass
    finally:
        try:
            _NOTIFY_COUNTS.clear()
        except Exception:
            pass


def run_one_shot():
    """Run the original one-shot scan (installed apps + full drive scan)."""
    print("[*] Check installed crack applications...")
    installed_apps = get_installed_apps()
    detected_apps = False

    suspicious_set = set(SUSPICIOUS_KEYWORDS)
    for app in installed_apps:
        try:
            app_text = (app or '').strip()
            if not app_text:
                continue
            # Tokenize installed app name and check for exact token matches
            app_tokens = _normalize_tokens(app_text)
            if app_tokens & suspicious_set:
                send_log("Installed App", app_text)
                detected_apps = True
        except Exception:
            # fallback to previous substring behavior if tokenization fails
            try:
                for keyword in SUSPICIOUS_KEYWORDS:
                    if keyword in (app or '').lower():
                        send_log("Installed App", app.strip())
                        detected_apps = True
                        break
            except Exception:
                pass

    print("[*] Scanning all drives for crack files...")
    suspicious_files = scan_drives_for_suspicious_files()
    detected_files = False

    # Limit total sends per run to avoid server 429 (rate limit).
    # Default to 0 (unlimited) unless explicitly configured to a positive integer.
    _raw_budget = os.environ.get('APPDETECTOR_MAX_SENDS_PER_RUN', '0')
    try:
        max_sends = int(str(_raw_budget).strip())
    except Exception:
        max_sends = 0
    unlimited = (max_sends <= 0)
    sent = 0
    for file_path in suspicious_files:
        if (not unlimited) and sent >= max_sends:
            print(f"[i] Send budget reached (APPDETECTOR_MAX_SENDS_PER_RUN={max_sends}), remaining detections suppressed this run.")
            break
        file_name = os.path.basename(file_path)
        send_log("File Scan", file_name, path=file_path)
        sent += 1
        detected_files = True

    # Kirim log clean jika tidak ada deteksi sama sekali
    if not detected_apps and not detected_files:
        print("✅ No crack application/file found.")
        send_log("Clean PC", app_name=None, detected_at=None)
    # flush aggregated notifications at end of run
    try:
        flush_notifications()
    except Exception:
        pass


# kode terbaru watch

class CrackEventHandler:
    """Minimal adapter that inspects created/modified files and reports suspicious ones."""
    def __init__(self, exclude_patterns=None):
        self.exclude = [p.lower() for p in (exclude_patterns or [])]

    def _should_ignore(self, path: str):
        p = path.lower()
        return any(skip in p for skip in self.exclude)

    def handle_path(self, path: str):
        try:
            if not path or self._should_ignore(path):
                return
            if os.path.isdir(path):
                # optionally scan directory contents
                return
            name = os.path.basename(path)
            tokens = _normalize_tokens(name)
            if tokens & set(SUSPICIOUS_KEYWORDS):
                send_log("File Watcher", name, path=path)
        except Exception:
            pass


def start_watch(paths_to_watch, exclude_patterns=None):
    """Start a filesystem watcher. If watchdog isn't installed, fall back to simple polling for those paths."""
    # If watchdog is available, use event-driven observer. Otherwise, fallback to polling.
    if _HAS_WATCHDOG:
        class _Handler(FileSystemEventHandler):
            def __init__(self, real_handler: CrackEventHandler):
                super().__init__()
                self.real = real_handler

            def on_created(self, event):
                if not event.is_directory:
                    self.real.handle_path(event.src_path)

            def on_moved(self, event):
                if not event.is_directory:
                    self.real.handle_path(event.dest_path)

            def on_modified(self, event):
                if not event.is_directory:
                    self.real.handle_path(event.src_path)

        observer = Observer()
        handler = CrackEventHandler(exclude_patterns=exclude_patterns)
        h = _Handler(handler)
        for p in paths_to_watch:
            try:
                observer.schedule(h, p, recursive=True)
            except Exception:
                # skip paths we can't observe
                pass
        observer.start()
        # start a background notifier flusher thread
        def _notifier_flusher():
            flush_interval = int(os.environ.get('APPDETECTOR_NOTIFY_FLUSH_SECS', '10'))
            try:
                while True:
                    time.sleep(flush_interval)
                    try:
                        flush_notifications()
                    except Exception:
                        pass
            except Exception:
                return

        t_notify = threading.Thread(target=_notifier_flusher, daemon=True)
        t_notify.start()
        try:
            while True:
                time.sleep(1)
        except KeyboardInterrupt:
            observer.stop()
        observer.join()
    else:
        # fallback: simple polling on paths_to_watch
        handler = CrackEventHandler(exclude_patterns=exclude_patterns)
        seen = set()
        try:
            while True:
                for root in paths_to_watch:
                    for dirpath, dirnames, filenames in os.walk(root):
                        for fname in filenames:
                            fpath = os.path.join(dirpath, fname)
                            if fpath not in seen:
                                seen.add(fpath)
                                handler.handle_path(fpath)
                time.sleep(int(os.environ.get('APPDETECTOR_WATCH_POLL_SECS', 10)))
        except KeyboardInterrupt:
            return


def start_periodic_fullscan(interval_seconds: int):
    """Run full drive scan periodically in background."""
    def _runner():
        while True:
            try:
                suspicious_files = scan_drives_for_suspicious_files()
                for file_path in suspicious_files:
                    file_name = os.path.basename(file_path)
                    send_log("Periodic Scan", file_name, path=file_path)
            except Exception:
                pass
            time.sleep(interval_seconds)

    t = threading.Thread(target=_runner, daemon=True)
    t.start()


def main():
    parser = argparse.ArgumentParser(description='AppDetector agent')
    parser.add_argument('--run-once', action='store_true', help='Run a single scan and exit')
    parser.add_argument('--watch', action='store_true', help='Run in realtime watch mode (watch Downloads/Desktop by default)')
    parser.add_argument('--fullscan-hours', type=int, default=int(os.environ.get('APPDETECTOR_FULLSCAN_HOURS', 6)),
                        help='Hours between full-drive periodic scans when running watcher')
    parser.add_argument('--watch-paths', type=str, default=os.environ.get('APPDETECTOR_WATCH_PATHS', ''),
                        help='Semicolon-separated paths to watch')
    args = parser.parse_args()

    if args.run_once:
        run_one_shot()
        return

    if not args.watch:
        # default behavior: keep backward-compatible one-shot
        run_one_shot()
        return

    # watch mode: determine paths to watch
    paths = []
    if args.watch_paths:
        for p in args.watch_paths.split(';'):
            p = p.strip()
            if p:
                paths.append(os.path.expanduser(p))
    else:
        # sensible defaults
        u = os.path.expanduser('~')
        paths = [os.path.join(u, 'Downloads'), os.path.join(u, 'Desktop'), u]

    # exclude patterns (reuse existing skip list)
    exclude = [
        "node_modules",
        "bower_components",
        ".gradle",
        "\\cache\\packages\\",
        "\\npm\\",
        "\\yarn\\"
    ]
    extra_ex = os.environ.get('APPDETECTOR_EXCLUDE_PATTERNS', '')
    if extra_ex:
        for p in re.split(r'[;,]', extra_ex):
            p = p.strip().lower()
            if p:
                exclude.append(p)

    # start periodic fullscan thread
    start_periodic_fullscan(int(args.fullscan_hours) * 3600)

    # start watcher (blocking)
    start_watch(paths, exclude_patterns=exclude)


if __name__ == "__main__":
    main()
#end code terbaru

    # print("🚨 Check installed crack applications...")
    # installed_apps = get_installed_apps()
    # for app in installed_apps:
    #     for keyword in SUSPICIOUS_KEYWORDS:
    #         if keyword in app:
    #             send_log("Installed App", app.strip())

    # print("🔍 Scanning all drives for crack files...")
    # suspicious_files = scan_drives_for_suspicious_files()
    # for file_path in suspicious_files:
    #     file_name = os.path.basename(file_path)
    #     send_log("File Scan", file_name, path=file_path)

    # if not installed_apps and not suspicious_files:
    #     print("✅ No crack application/file found.")


