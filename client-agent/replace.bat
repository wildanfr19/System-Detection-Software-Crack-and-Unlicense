@echo off
REM replace.bat - wrapper to run replace_agent.ps1 with ExecutionPolicy Bypass
REM Usage: double-click this file, or run with an optional source folder:
REM   replace.bat C:\path\to\new\files

SETLOCAL ENABLEDELAYEDEXPANSION

n:: default source folder is 'dist' subfolder next to this batch file
nIF "%~1"=="" (
  SET "SRC=%~dp0dist"
) ELSE (
  SET "SRC=%~1"
)

nSET "SCRIPT=%~dp0replace_agent.ps1"

nIF NOT EXIST "%SCRIPT%" (
  ECHO ERROR: replace_agent.ps1 not found in %~dp0
  PAUSE
  EXIT /B 1
)

nECHO Running replace_agent.ps1 with SourceDir="%SRC%"
powershell -ExecutionPolicy Bypass -NoProfile -File "%SCRIPT%" -SourceDir "%SRC%"

ECHO.
ECHO Done. Check the output above and agent log in %LOCALAPPDATA%\apk\agent.log
PAUSE
