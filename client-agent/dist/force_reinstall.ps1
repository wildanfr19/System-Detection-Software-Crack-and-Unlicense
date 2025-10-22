<#
force_reinstall.ps1

Opsi cepat untuk menghapus instalasi lama AppDetector, menyalin ulang file dari folder dist,
dan mendaftarkan Scheduled Task interactive untuk user saat ini.

Cara pakai (double-click via force_reinstall.bat atau jalankan dari PowerShell):
  powershell -NoProfile -ExecutionPolicy Bypass -File .\force_reinstall.ps1

Script ini akan:
 - Unregister semua scheduled task yang mengandung 'AppDetector' atau 'apk'
 - Hentikan proses apk.exe jika berjalan
 - Hapus folder %LOCALAPPDATA%\AppDetector
 - Copy semua file dari folder script (dist) ke %LOCALAPPDATA%\AppDetector
 - Tulis config.json dari env var APPDETECTOR_API_URL / APPDETECTOR_API_KEY jika ada
 - Register scheduled task bernama 'AppDetector' dengan LogonType Interactive
 - Menyimpan log di file force_reinstall.log di folder dist
#>

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

function Log($msg){
    $t = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $line = "[$t] $msg"
    Write-Host $line
    Add-Content -Path $LogFile -Value $line
}

try{
    $ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition
} catch {
    $ScriptDir = (Get-Location).Path
}

$LogFile = Join-Path $ScriptDir 'force_reinstall.log'
Remove-Item -Path $LogFile -ErrorAction SilentlyContinue
Log "Starting force_reinstall script"

# 1) Unregister scheduled tasks matching names
Log "Looking for scheduled tasks matching 'AppDetector' or 'apk'"
try{
    $tasks = Get-ScheduledTask | Where-Object { $_.TaskName -match 'AppDetector|apk' }
    foreach($t in $tasks){
        try{
            Log "Unregistering task: $($t.TaskName)"
            Unregister-ScheduledTask -TaskName $t.TaskName -Confirm:$false -ErrorAction Stop
            Log "Unregistered $($t.TaskName)"
        } catch {
            Log "Failed to Unregister $($t.TaskName) via Register cmdlet: $_. Trying schtasks delete"
            try{ cmd.exe /c "schtasks /Delete /TN `"$($t.TaskName)`" /F" | Out-Null; Log "schtasks delete attempted for $($t.TaskName)" }catch{ Log "schtasks delete also failed: $_" }
        }
    }
} catch {
    Log "Error enumerating scheduled tasks: $_"
}

# 2) Stop running apk.exe processes
try{
    $procs = Get-Process -Name apk -ErrorAction SilentlyContinue
    if($procs){
        foreach($p in $procs){
            try{ Stop-Process -Id $p.Id -Force -ErrorAction Stop; Log "Stopped process apk (Id $($p.Id))" } catch { Log "Failed to stop process $($p.Id): $_" }
        }
    } else { Log "No apk.exe processes found" }
} catch { Log "Error checking processes: $_" }

# 3) Remove old install folder
$InstallFolder = Join-Path $env:LOCALAPPDATA 'AppDetector'
try{
    if(Test-Path $InstallFolder){
        Log "Removing existing install folder: $InstallFolder"
        Remove-Item -Path $InstallFolder -Recurse -Force -ErrorAction Stop
        Log "Removed $InstallFolder"
    } else {
        Log "Install folder not present: $InstallFolder"
    }
} catch { Log "Failed to remove install folder: $_" }

# 4) Copy files from dist (script dir) to install folder
try{
    New-Item -Path $InstallFolder -ItemType Directory -Force | Out-Null
    Log "Copying files from $ScriptDir to $InstallFolder"
    Get-ChildItem -Path $ScriptDir -File | ForEach-Object {
        $dest = Join-Path $InstallFolder $_.Name
        try{ Copy-Item -Path $_.FullName -Destination $dest -Force; Log "Copied $_.Name" } catch { Log "Failed to copy $_.Name: $_" }
    }
} catch { Log "Failed copying files: $_" }

# 5) Create config.json if env present
try{
    $cfg = @{ }
    if($env:APPDETECTOR_API_URL){ $cfg.api_url = $env:APPDETECTOR_API_URL }
    if($env:APPDETECTOR_API_KEY){ $cfg.api_key = $env:APPDETECTOR_API_KEY }
    if($cfg.Keys.Count -gt 0){
        $cfgPath = Join-Path $InstallFolder 'config.json'
        $cfg | ConvertTo-Json -Depth 3 | Out-File -FilePath $cfgPath -Encoding UTF8
        Log "Wrote config to $cfgPath"
    } else { Log "No APPDETECTOR env variables present; skipping config.json creation" }
} catch { Log "Failed to write config.json: $_" }

# 6) Register scheduled task (interactive)
try{
    $exePath = Join-Path $InstallFolder 'apk.exe'
    if(-not (Test-Path $exePath)){
        Log "ERROR: apk.exe not found at $exePath. Aborting task registration."; throw "apk.exe missing"
    }

    $action = New-ScheduledTaskAction -Execute $exePath -Argument '--watch'
    $trigger = New-ScheduledTaskTrigger -AtLogOn
    $principal = New-ScheduledTaskPrincipal -UserId $env:USERNAME -LogonType Interactive -RunLevel Limited
    $task = New-ScheduledTask -Action $action -Trigger $trigger -Principal $principal
    Register-ScheduledTask -TaskName 'AppDetector' -InputObject $task -Force
    Log "Registered Scheduled Task 'AppDetector' for user $env:USERNAME"
} catch {
    Log "Register-ScheduledTask failed: $_. Trying schtasks fallback"
    try{
        $quoted = '"' + $exePath + '" --watch'
        $cmd = "schtasks /Create /SC ONLOGON /RL LIMITED /TN \"AppDetector\" /TR $quoted /F"
        Log "Running: $cmd"
        cmd.exe /C $cmd | Out-Null
        if($LASTEXITCODE -eq 0){ Log "Scheduled Task created via schtasks." } else { Log "schtasks exit code: $LASTEXITCODE" }
    } catch { Log "schtasks fallback failed: $_" }
}

Log "force_reinstall completed"
