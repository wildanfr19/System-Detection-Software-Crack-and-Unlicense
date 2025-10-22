<#
build_apk.ps1
Helper script to build client-agent\apk.py into apk.exe using PyInstaller.
Run this on a Windows development machine with Python installed.

Usage: Run in PowerShell as Administrator (if you want schtasks creation later)
    powershell -ExecutionPolicy Bypass -File .\client-agent\build_apk.ps1
#>

param(
    [string]$venvDir = '.venv',
    [switch]$skipDeps
)

Set-StrictMode -Version Latest
Write-Host "Building apk.exe (client-agent)"

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
# repoRoot should be the repository root (parent of the folder containing this script)
$repoRoot = Split-Path -Parent $scriptDir
Set-Location -Path $repoRoot

if (-not $skipDeps) {
    if (-not (Test-Path $venvDir)) {
        Write-Host "Creating virtualenv at $venvDir"
        python -m venv $venvDir
    }
    Write-Host "Activating virtualenv"
    $activatePath = Join-Path $venvDir 'Scripts\Activate.ps1'
    if (Test-Path $activatePath) {
        # Use the call operator to run the activation script so variable expansion and spacing are safe
        & $activatePath
    } else {
        Write-Host "Activation script not found at $activatePath - continuing without virtualenv activation"
    }
    Write-Host "Upgrading pip and installing build deps"
    pip install --upgrade pip setuptools wheel
    pip install pyinstaller requests psutil getmac win10toast pywin32
}

# Ensure we are in client-agent folder
Set-Location -Path (Join-Path $repoRoot 'client-agent')

$specName = 'apk'
$src = 'apk.py'

Write-Host "Running PyInstaller..."
pyinstaller --onefile --noconsole --name $specName $src

$outExe = Join-Path -Path (Join-Path -Path $PWD -ChildPath 'dist') -ChildPath ($specName + '.exe')
if (Test-Path $outExe) {
    Write-Host "Build succeeded: $outExe"
    try {
        Unblock-File $outExe -ErrorAction SilentlyContinue
        Write-Host "Unblocked $outExe"
    } catch {
        Write-Host "Warning: failed to unblock (not critical)"
    }
} else {
    Write-Host "Build failed: dist\$specName.exe not found"
    Exit 1
}

Write-Host "Done. File located at: $outExe"
