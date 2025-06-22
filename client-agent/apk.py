import socket
import requests
import psutil
import platform
from getmac import get_mac_address
from datetime import datetime
import os
import string

# ============================
API_URL = "http://192.168.1.5:8000/api/report-crack"
SUSPICIOUS_KEYWORDS = ["crack","portable"]
#  "patch", "keygen", "activator", "kuyhaa", "serial"
# ============================

def get_installed_apps():
    apps = []
    if platform.system() == "Windows":
        try:
            installed_apps = os.popen('wmic product get name').read()
            apps = installed_apps.lower().split('\n')
        except Exception as e:
            print("Failed to fetch application list:", e)
    return apps

def get_all_drives():
    return [f"{d}:\\" for d in string.ascii_uppercase if os.path.exists(f"{d}:\\")]

def scan_drives_for_suspicious_files():
    results = []
    for drive in get_all_drives():
        for root, dirs, files in os.walk(drive, topdown=True):
            for name in files + dirs:
                if any(keyword in name.lower() for keyword in SUSPICIOUS_KEYWORDS):
                    results.append(os.path.join(root, name))
    return results

def send_log(source, app_name, path="N/A"):
    try:
        pc_name = socket.gethostname()
        user_name = os.getlogin()
        ip_address = socket.gethostbyname(pc_name)
        mac_address = get_mac_address()
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    except Exception as e:
        print(f"Failed to retrieve system info: {e}")
        return

    data = {
        "pc_name": pc_name,
        "user_name": user_name,
        "app_name": app_name,
        "source": source,  # Installed App / FileScan
        "path": path,
        "detected_at": now,
        "ip_address": ip_address,
        "mac_address": mac_address
    }

    try:
        res = requests.post(API_URL, json=data)
        if res.status_code == 200:
            print("[✓] Log sent:", app_name)
        else:
            print("[X] Failed to send log:", res.status_code, res.text)
    except Exception as e:
        print("[ERR] Exception when sending:", str(e))


# ========== MAIN ==========
if __name__ == "__main__":
    print("🚨 Check installed crack applications...")
    installed_apps = get_installed_apps()
    for app in installed_apps:
        for keyword in SUSPICIOUS_KEYWORDS:
            if keyword in app:
                send_log("Installed App", app.strip())

    print("🔍 Scanning all drives for crack files...")
    suspicious_files = scan_drives_for_suspicious_files()
    for file_path in suspicious_files:
        file_name = os.path.basename(file_path)
        send_log("File Scan", file_name, path=file_path)

    if not installed_apps and not suspicious_files:
        print("✅ No crack application/file found.")
