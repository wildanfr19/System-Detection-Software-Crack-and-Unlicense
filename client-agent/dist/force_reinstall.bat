@echo off
REM Wrapper to run force_reinstall.ps1 via double-click
SETLOCAL
SET SCRIPT_DIR=%~dp0
powershell -NoProfile -ExecutionPolicy Bypass -File "%SCRIPT_DIR%force_reinstall.ps1" %*
ENDLOCAL
