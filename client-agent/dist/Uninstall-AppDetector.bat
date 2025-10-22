@echo off
REM Wrapper to run Uninstall-AppDetector.ps1 by double-clicking
SETLOCAL
SET SCRIPT_DIR=%~dp0
powershell -NoProfile -ExecutionPolicy Bypass -File "%SCRIPT_DIR%Uninstall-AppDetector.ps1" %*
ENDLOCAL
