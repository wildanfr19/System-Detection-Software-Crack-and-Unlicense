import socket
import requests
import psutil
import platform
from getmac import get_mac_address
from datetime import datetime
import os
import string
import ctypes


# ============================
API_URL = "http://192.168.1.90:8000/api/report-crack"
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

def get_all_local_fixed_drives():
    drives = []
    for letter in string.ascii_uppercase:
        drive = f"{letter}:\\"
        drive_type = ctypes.windll.kernel32.GetDriveTypeW(drive)
        if drive_type == 3:  # 3 = Fixed drive (HDD/SSD internal)
            drives.append(drive)
    return drives

# def scan_drives_for_suspicious_files():
#     results = []
#     for drive in get_all_local_fixed_drives():
#         for root, dirs, files in os.walk(drive, topdown=True):
#             for name in files + dirs:
#                 if any(keyword in name.lower() for keyword in SUSPICIOUS_KEYWORDS):
#                     results.append(os.path.join(root, name))
#     return results

def scan_drives_for_suspicious_files():
    results = []
    safe_extensions = ['.pdf','.docx', '.xlsx', '.txt','.php','.conf','.py','.pyc','.php'] 
    skip_keywords = ["windows","windows portable","windowsapps","windows defender",
    "windowsportabledevices","laragon","microsoft visual"]

    for drive in get_all_local_fixed_drives():
        for root, dirs, files in os.walk(drive, topdown=True):
            root_lower = os.path.abspath(root).lower()
            # Skip folder Windows
            if any(skip_kw in root_lower for skip_kw in skip_keywords):
               continue

            for name in files + dirs:
                ext = os.path.splitext(name)[1].lower()
                if ext in safe_extensions:
                   continue

                if any(keyword in name.lower() for keyword in SUSPICIOUS_KEYWORDS):
                    results.append(os.path.join(root, name))

            
    return results
    

def send_log(source, app_name, path="N/A", detected_at=None):
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
        "pc_name": pc_name,
        "user_name": user_name,
        "app_name": app_name,
        "source": source,  # Installed App / FileScan
        "path": path,
        "detected_at": None if app_name is None else now,
        "ip_address": ip_address,
        "mac_address": mac_address
    }

    try:
        res = requests.post(API_URL, json=data)
        if res.status_code == 200:
            print("[✓] Log sent:", source if app_name is None else app_name)
        else:
            print("[X] Failed to send log:", res.status_code, res.text)
    except Exception as e:
        print("[ERR] Exception when sending:", str(e))


# ========== MAIN ==========
if __name__ == "__main__":
    print("🚨 Check installed crack applications...")
    installed_apps = get_installed_apps()
    detected_apps = False

    for app in installed_apps:
        for keyword in SUSPICIOUS_KEYWORDS:
            if keyword in app:
                send_log("Installed App", app.strip())
                detected_apps = True

    print("🔍 Scanning all drives for crack files...")
    suspicious_files = scan_drives_for_suspicious_files()
    detected_files = False

    for file_path in suspicious_files:
        file_name = os.path.basename(file_path)
        send_log("File Scan", file_name, path=file_path)
        detected_files = True

    # Kirim log clean jika tidak ada deteksi sama sekali
    if not detected_apps and not detected_files:
        print("✅ No crack application/file found.")
        send_log("Clean PC", app_name=None, detected_at=None)


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


