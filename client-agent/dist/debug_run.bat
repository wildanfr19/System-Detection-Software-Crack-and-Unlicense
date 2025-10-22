@echo off
echo === AppDetector debug run ===
echo Running: "%LOCALAPPDATA%\AppDetector\apk.exe" --run-once
IF NOT EXIST "%LOCALAPPDATA%\AppDetector\apk.exe" (
  echo ERROR: apk.exe not found in %LOCALAPPDATA%\AppDetector
  echo Please ensure you've copied the dist folder and run Install-AppDetector first.
  pause
  exit /b 1
)

"%LOCALAPPDATA%\AppDetector\apk.exe" --run-once
echo ExitCode=%ERRORLEVEL%
echo ===== End of run =====
pause
