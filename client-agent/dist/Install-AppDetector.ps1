<#
Install-AppDetector.ps1

Usage: Run as the target user (not SYSTEM) to install AppDetector for the current user.
It copies the built apk.exe into %LOCALAPPDATA%\AppDetector, creates a simple config file,
and registers a scheduled task to run at user logon with interactive logon type so toasts work.

Run in elevated PowerShell only if you need to install for another user. Prefer running as the
user that should receive notifications (so the scheduled task is created per-user and interactive).
#>

param(
    [string]$SourceExe = "./apk.exe",
    [string]$InstallFolder = "$env:LOCALAPPDATA\AppDetector",
    [string]$TaskName = "AppDetector",
    [string]$TaskArgs = "--watch",
    [switch]$Force
)

function Ensure-Dir($path){ if(-not (Test-Path $path)){ New-Item -Path $path -ItemType Directory -Force | Out-Null } }

# Resolve source exe absolute path
$src = Resolve-Path -Path $SourceExe -ErrorAction SilentlyContinue
if(-not $src){ Write-Error "Source exe not found: $SourceExe"; exit 1 }
$src = $src.Path

Ensure-Dir $InstallFolder
$dest = Join-Path $InstallFolder (Split-Path $src -Leaf)

Write-Host "Copying $src -> $dest"
Copy-Item -Path $src -Destination $dest -Force:$Force

# Create minimal config
$config = @{ api_url = $env:APPDETECTOR_API_URL; api_key = $env:APPDETECTOR_API_KEY }
$configPath = Join-Path $InstallFolder 'config.json'
$config | ConvertTo-Json -Depth 3 | Out-File -FilePath $configPath -Encoding UTF8
Write-Host "Wrote config to $configPath"

# Register scheduled task: prefer register-scheduledtask with New-ScheduledTaskPrincipal (interactive)
$action = New-ScheduledTaskAction -Execute $dest -Argument $TaskArgs
$trigger = New-ScheduledTaskTrigger -AtLogOn

$principal = New-ScheduledTaskPrincipal -UserId $env:USERNAME -LogonType Interactive -RunLevel Limited
$task = New-ScheduledTask -Action $action -Trigger $trigger -Principal $principal

try{
    Register-ScheduledTask -TaskName $TaskName -InputObject $task -Force
    Write-Host "Scheduled Task '$TaskName' registered for user $env:USERNAME (Interactive)."
}catch{
    Write-Warning "Register-ScheduledTask failed, falling back to schtasks.exe. Error: $_"
    # Fallback: attempt schtasks create (creates a per-user task when run as that user)
    $quoted = '"' + $dest + '" ' + $TaskArgs
    $cmd = "schtasks /Create /SC ONLOGON /RL LIMITED /TN `"$TaskName`" /TR $quoted /F"
    Write-Host "Running: $cmd"
    cmd.exe /C $cmd
    if($LASTEXITCODE -eq 0){ Write-Host "Scheduled Task created via schtasks." } else { Write-Error "Failed to create scheduled task via schtasks (exit $LASTEXITCODE)." }
}

Write-Host "Install complete. Installed files:"; Get-ChildItem -Path $InstallFolder | Select-Object Name, Length, LastWriteTime | Format-Table -AutoSize
<#
Install-AppDetector.ps1
Per-user installer for AppDetector
Usage (run in PowerShell as the user to install for that user):
  .\Install-AppDetector.ps1 -SourceExe .\dist\AppDetector.exe -ApiUrl 'http://192.168.1.90:8000/api/report-crack' -ApiKey 'optional-key'
#>
param(
    [string]$SourceExe = ".\apk.exe",
    [string]$InstallDir = "$env:LOCALAPPDATA\apk",
    [string]$ApiUrl = "http://192.168.1.226:8000/api/report-crack",
    [string]$ApiKey = "",
    [switch]$CreateStartupShortcut = $true,
    [switch]$CreateRunRegistry = $true,
    [switch]$CreateScheduledTask = $false
)

Write-Output "Installing AppDetector..."

# Validate source
if (-not (Test-Path $SourceExe)) {
    Write-Error "Source EXE not found: $SourceExe"
    exit 1
}

# Create folder and copy EXE
if (-not (Test-Path $InstallDir)) { New-Item -Path $InstallDir -ItemType Directory -Force | Out-Null }
Copy-Item -Path $SourceExe -Destination (Join-Path $InstallDir (Split-Path $SourceExe -Leaf)) -Force

# Write config.json
$config = @{ api_url = $ApiUrl }
if ($ApiKey -ne "") { $config.api_key = $ApiKey }
$configJson = $config | ConvertTo-Json -Depth 5
$configPath = Join-Path $InstallDir 'config.json'
$configJson | Set-Content -Path $configPath -Encoding UTF8
Write-Output "Wrote config to $configPath"

# Create Startup shortcut (per-user)
if ($CreateStartupShortcut) {
    $startup = Join-Path $env:APPDATA 'Microsoft\Windows\Start Menu\Programs\Startup'
    try {
        $ws = New-Object -ComObject WScript.Shell
        $lnkPath = Join-Path $startup 'apk.lnk'
        $shortcut = $ws.CreateShortcut($lnkPath)
        $shortcut.TargetPath = Join-Path $InstallDir (Split-Path $SourceExe -Leaf)
        $shortcut.Arguments = '--run-daemon'
        $shortcut.WorkingDirectory = $InstallDir
        $shortcut.WindowStyle = 7
        $shortcut.Save()
        Write-Output "Startup shortcut created: $lnkPath"
    } catch {
        Write-Warning "Failed to create startup shortcut: $_"
    }
}

# Add HKCU Run registry entry
if ($CreateRunRegistry) {
    try {
        $runName = 'apk'
        $exePath = '"' + (Join-Path $InstallDir (Split-Path $SourceExe -Leaf)) + '" --run-daemon'
        Set-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Run' -Name $runName -Value $exePath -Force
        Write-Output "HKCU Run entry set: $runName -> $exePath"
    } catch {
        Write-Warning "Failed to set Run registry: $_"
    }
}

# Optional: create scheduled task (per-user)
if ($CreateScheduledTask) {
    try {
        $exeFull = Join-Path $InstallDir (Split-Path $SourceExe -Leaf)
        $taskName = 'AppDetector'
        $tr = '"' + $exeFull + '" --run-once'
        schtasks /Create /SC ONLOGON /TN $taskName /TR $tr /RL LIMITED /F | Out-Null
        Write-Output "Scheduled Task created: $taskName"
    } catch {
        Write-Warning "Failed to create scheduled task: $_"
    }
}

Write-Output "Install complete. Start menu shortcut and registry entries are per-user."
Write-Output "Check log at: $env:LOCALAPPDATA\AppDetector\agent.log after first run."

# Optionally run once now
try {
    Start-Process -FilePath (Join-Path $InstallDir (Split-Path $SourceExe -Leaf)) -ArgumentList '--run-once' -WorkingDirectory $InstallDir -WindowStyle Hidden
    Write-Output "Launched apk (run-once)"
} catch {
    Write-Warning "Failed to launch apk: $_"
}
