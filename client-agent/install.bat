@echo off
REM install.bat - Double-click installer wrapper for Install-AppDetector.ps1
REM Backup of previous install.bat

nSET SCRIPT_DIR=%~dp0
powershell -ExecutionPolicy Bypass -NoProfile -File "%SCRIPT_DIR%Install-AppDetector.ps1" -SourceExe "%SCRIPT_DIR%apk.exe" -ApiUrl "http://10.171.74.214:8000/api/report-crack" -ApiKey ""
pause
