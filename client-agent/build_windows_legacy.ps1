<#
Build script for Windows legacy targets (Windows 7/8).

Prerequisites on build machine:
- Install Python 3.11 (x86 or x64 depending on target) and ensure 'py' launcher is available.
- Run this script from an elevated PowerShell if you will install system-wide packages.

This script creates a local venv, installs the legacy requirements, and runs PyInstaller
in --onedir mode (easier to debug on target systems).

Usage:
  .\build_windows_legacy.ps1 -PythonVersion 3.11 -Arch x64

#>

param(
    [string]$PythonVersion = '3.11',
    [ValidateSet('x86','x64')][string]$Arch = 'x64',
    [string]$ProjectFile = 'apk.py'
)

function Ensure-Exit($code){ if($code -ne 0){ Write-Error "Command failed with exit $code"; exit $code } }

Write-Host "Building AppDetector agent for Windows legacy (Python $PythonVersion, Arch=$Arch)"

# locate python launcher for requested version
$pyCmd = "py -$PythonVersion"
try{
    $ver = & $pyCmd --version 2>&1
    Write-Host "Found python: $ver"
} catch {
    Write-Error "Python $PythonVersion not found via 'py -$PythonVersion'. Install it first or adjust the script."
    exit 1
}

$venv = Join-Path $PSScriptRoot ".venv_winlegacy_$($PythonVersion)_$($Arch)"
if(Test-Path $venv){ Remove-Item $venv -Recurse -Force }

& $pyCmd -m venv $venv
Ensure-Exit $LASTEXITCODE


$activate = Join-Path $venv 'Scripts\Activate.ps1'
Write-Host "Activating venv: $venv"
. $activate

Write-Host "Using python: "
& $venv\Scripts\python.exe --version
Write-Host "pip location:"
& $venv\Scripts\pip.exe --version

Write-Host "Upgrading pip and installing requirements into venv"
& $venv\Scripts\pip.exe install --upgrade pip setuptools wheel
Ensure-Exit $LASTEXITCODE
& $venv\Scripts\pip.exe install -r requirements-winlegacy.txt
Ensure-Exit $LASTEXITCODE

Write-Host "Invoking PyInstaller from venv python to avoid external Python versions"
& $venv\Scripts\python.exe -m PyInstaller --clean --onedir --noconsole --name apk --noupx $ProjectFile
Ensure-Exit $LASTEXITCODE

Write-Host "Build complete. Output folder: dist\apk"
Write-Host "NOTE: Test the generated 'dist\apk\apk.exe' on a clean Windows 7 VM."

Write-Host "If target is 32-bit Windows, rebuild with -Arch x86 and ensure Python x86 is installed."

Write-Host "Also ensure target machines have the Visual C++ Redistributable installed (2015-2022)."
