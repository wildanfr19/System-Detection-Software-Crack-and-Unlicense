<#
replace_agent.ps1
Simple helper to replace apk agent files on a user machine.
Usage:
  .\replace_agent.ps1 -SourceDir 'C:\path\to\new\files' [-InstallDir "$env:LOCALAPPDATA\apk"]
This script will:
  - create a timestamped backup of the current install folder (if exists)
  - stop any running apk process
  - copy files from SourceDir into the InstallDir
  - (re)start the agent with --run-daemon
#>
param(
    [Parameter(Mandatory=$true)]
    [string]$SourceDir,
    [string]$InstallDir = "$env:LOCALAPPDATA\apk"
)

nif (-not (Test-Path $SourceDir)) {
    Write-Error "Source dir not found: $SourceDir"
    exit 1
}

n# Backup
$timestamp = Get-Date -Format 'yyyyMMdd_HHmmss'
$backupDir = "$env:LOCALAPPDATA\apk_backup_$timestamp"
if (Test-Path $InstallDir) {
    Write-Output "Creating backup: $backupDir"
    Copy-Item -Path $InstallDir -Destination $backupDir -Recurse -Force
} else {
    Write-Output "Install dir does not exist, will create: $InstallDir"
    New-Item -Path $InstallDir -ItemType Directory -Force | Out-Null
}

n# Stop running process if any
$procs = Get-Process -Name apk -ErrorAction SilentlyContinue
if ($procs) {
    Write-Output "Stopping apk processes..."
    $procs | Stop-Process -Force -ErrorAction SilentlyContinue
} else {
    Write-Output "No running apk process found."
}

n# Copy files from source
Write-Output "Copying files from $SourceDir to $InstallDir"
Copy-Item -Path (Join-Path $SourceDir '*') -Destination $InstallDir -Recurse -Force

n# Start agent daemon
$exe = Join-Path $InstallDir 'apk.exe'
if (Test-Path $exe) {
    Write-Output "Starting apk daemon..."
    Start-Process -FilePath $exe -ArgumentList '--run-daemon' -WindowStyle Hidden
    Start-Sleep -Seconds 2
    Get-Process -Name apk -ErrorAction SilentlyContinue | Select-Object Id, ProcessName, Path
    Write-Output "Replace complete. Check $InstallDir\agent.log for details."
} else {
    Write-Error "apk.exe not found in $InstallDir after copy."
    exit 1
}
