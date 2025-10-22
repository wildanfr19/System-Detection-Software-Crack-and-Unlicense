@echo off
REM Wrapper to run Install-AppDetector.ps1 by double-clicking
REM Usage: double-click this file or run from cmd
SETLOCAL
SET SCRIPT_DIR=%~dp0
powershell -NoProfile -ExecutionPolicy Bypass -File "%SCRIPT_DIR%Install-AppDetector.ps1" %*
ENDLOCAL
