@echo off
REM reinstall_agent.bat
REM Simple double-clickable batch to remove old agent, copy new files and start the daemon.
REM Usage:
REM   Double-click this file (default will copy files from .\dist)
REM   Or run: reinstall_agent.bat C:\path\to\new\files

SETLOCAL ENABLEDELAYEDEXPANSION

:: Determine source folder (default: dist next to this batch)
IF "%~1"=="" (
  SET "SRC=%~dp0dist"
) ELSE (
  SET "SRC=%~1"
)

ECHO Source folder: "%SRC%"
ECHO Install folder: "%LOCALAPPDATA%\apk"

:: Stop apk if running
ECHO Stopping apk (if running)...
taskkill /IM apk.exe /F >nul 2>&1 || echo No running apk.exe processes found.

:: Backup existing install (PowerShell for timestamped name)
ECHO Backing up existing install (if exists)...
powershell -NoProfile -ExecutionPolicy Bypass -Command "`n$src = Join-Path $env:LOCALAPPDATA 'apk'; `nif (Test-Path $src) { $t = Get-Date -Format 'yyyyMMdd_HHmmss'; $dst = Join-Path $env:LOCALAPPDATA ('apk_backup_' + $t); Copy-Item -Path $src -Destination $dst -Recurse -Force; Write-Output ('BACKUP:' + $dst) } else { Write-Output 'No existing install to backup.' }"

:: Remove old install folder
ECHO Removing old install folder...
if exist "%LOCALAPPDATA%\apk" (
  rmdir /S /Q "%LOCALAPPDATA%\apk"
) else (
  ECHO No existing install directory.
)

:: Create install folder
ECHO Creating install folder...
mkdir "%LOCALAPPDATA%\apk" >nul 2>&1

:: Copy files from source
ECHO Copying files from "%SRC%" to "%LOCALAPPDATA%\apk"...
xcopy "%SRC%\*" "%LOCALAPPDATA%\apk\" /E /I /Y >nul
IF %ERRORLEVEL% NEQ 0 (
  ECHO Warning: some files may not have been copied correctly. Check the source path.
)

:: Start agent
IF EXIST "%LOCALAPPDATA%\apk\apk.exe" (
  ECHO Starting apk daemon...
  start "" "%LOCALAPPDATA%\apk\apk.exe" --run-daemon
  TIMEOUT /T 2 >nul
  ECHO Process list (apk.exe):
  tasklist /FI "IMAGENAME eq apk.exe"
  ECHO.
  ECHO Last 50 lines of agent.log (if present):
  powershell -NoProfile -ExecutionPolicy Bypass -Command "`n$log = Join-Path $env:LOCALAPPDATA 'apk\\agent.log'; if (Test-Path $log) { Get-Content -Path $log -Tail 50 | ForEach-Object { Write-Output $_ } } else { Write-Output 'agent.log not found.' }"
) ELSE (
  ECHO ERROR: apk.exe not found in %LOCALAPPDATA%\apk. Aborting.
)

echo.
echo Done. Press any key to exit.
pause >nul
