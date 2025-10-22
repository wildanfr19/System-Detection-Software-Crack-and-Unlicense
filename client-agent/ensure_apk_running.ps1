<#
ensure_apk_running.ps1
- Hentikan apk jika berjalan
- Mulai apk.exe --run-daemon
- Pasang autostart per-user (HKCU Run) dan optional startup shortcut
- Verifikasi proses dan log

Usage (run in PowerShell as the user):
  .\ensure_apk_running.ps1 [-InstallDir "$env:LOCALAPPDATA\apk"] [-CreateShortcut]
#>
param(
    [string]$InstallDir = "$env:LOCALAPPDATA\apk",
    [switch]$CreateShortcut = $true,
    [switch]$CreateRunRegistry = $true,
    [switch]$CreateScheduledTask = $false
)

function Write-Ok($msg){ Write-Host "[OK] $msg" -ForegroundColor Green }
function Write-Warn($msg){ Write-Host "[WARN] $msg" -ForegroundColor Yellow }
function Write-Err($msg){ Write-Host "[ERR] $msg" -ForegroundColor Red }

# 1) stop apk if running
$procs = Get-Process -Name apk -ErrorAction SilentlyContinue
if ($procs) {
    Write-Host "Stopping apk processes..."
    $procs | Stop-Process -Force -ErrorAction SilentlyContinue
    Start-Sleep -Milliseconds 500
    Write-Ok "Stopped apk (if present)"
} else {
    Write-Warn "No apk process running"
}

# 2) ensure exe present
$exe = Join-Path $InstallDir 'apk.exe'
if (-not (Test-Path $exe)) {
    Write-Err "apk.exe not found at $exe"
    Write-Host "Please copy apk.exe (and related files) to $InstallDir then re-run this script."
    exit 1
}

# 3) start daemon
Write-Host "Starting apk daemon..."
try {
    Start-Process -FilePath $exe -ArgumentList '--run-daemon' -WindowStyle Hidden -ErrorAction Stop
    Start-Sleep -Seconds 2
    $p = Get-Process -Name apk -ErrorAction SilentlyContinue
    if ($p) { Write-Ok "apk started (PID: $($p.Id))" } else { Write-Err "apk did not appear in process list after start" }
} catch {
    Write-Err "Failed to start apk: $_"
    exit 1
}

# 4) create HKCU Run entry
if ($CreateRunRegistry) {
    try {
        $runName = 'apk'
        $exePath = '"' + $exe + '" --run-daemon'
        Set-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Run' -Name $runName -Value $exePath -Force
        Write-Ok "HKCU Run entry set: $runName -> $exePath"
    } catch {
        Write-Warn "Failed to set Run registry: $_"
    }
}

# 5) optional: create startup shortcut
if ($CreateShortcut) {
    try {
        $startup = Join-Path $env:APPDATA 'Microsoft\Windows\Start Menu\Programs\Startup'
        $ws = New-Object -ComObject WScript.Shell
        $lnkPath = Join-Path $startup 'apk.lnk'
        $shortcut = $ws.CreateShortcut($lnkPath)
        $shortcut.TargetPath = $exe
        $shortcut.Arguments = '--run-daemon'
        $shortcut.WorkingDirectory = $InstallDir
        $shortcut.WindowStyle = 7
        $shortcut.Save()
        Write-Ok "Startup shortcut created: $lnkPath"
    } catch {
        Write-Warn "Failed to create startup shortcut: $_"
    }
}

# 6) optional: create scheduled task (per-user)
if ($CreateScheduledTask) {
    try {
        $taskName = 'AppDetector'
        $exeFull = '"' + $exe + '" --run-once'
        schtasks /Create /SC ONLOGON /TN $taskName /TR $exeFull /RL LIMITED /F | Out-Null
        Write-Ok "Scheduled Task created: $taskName"
    } catch {
        Write-Warn "Failed to create scheduled task: $_"
    }
}

# 7) verify log presence and show last lines
$log = Join-Path $env:LOCALAPPDATA 'apk\agent.log'
if (Test-Path $log) {
    Write-Host "Last 50 lines of agent.log:" -ForegroundColor Cyan
    Get-Content $log -Tail 50 | ForEach-Object { Write-Host $_ }
} else {
    Write-Warn "agent.log not found at $log"
}

Write-Ok "ensure_apk_running completed"
