# Building AppDetector agent for legacy Windows (Win7/Win8)

This document describes how to produce a Windows bundle suitable for older Windows versions
where modern Python (3.12/3.13) may not work.

Key points

-   Use Python 3.11 (recommended) or 3.9/3.8 for maximum Windows 7 compatibility.
-   Build with PyInstaller in `--onedir` mode first (easier to debug). Avoid `--onefile` while testing.
-   Match architecture (x86 or x64) between build Python and target OS.
-   Ensure Visual C++ Redistributable (2015-2022) is installed on target machines.

Quick steps

1. Install Python 3.11 on your build machine (choose x86 for 32-bit targets or x64 for 64-bit).
2. Open PowerShell in the `client-agent` folder and run:

```powershell
.\build_windows_legacy.ps1 -PythonVersion 3.11 -Arch x64
```

3. After the build completes, copy `dist\apk` to a Windows 7 machine and run `apk.exe`.

Troubleshooting: "Failed to load Python DLL python313.dll"

-   This error means the bundled app is looking for python313.dll (Python 3.13). To fix:
    -   Rebuild using Python 3.11 as shown above.
    -   Use `--onedir` to inspect `dist\apk` and confirm a file like `python311.dll` exists (or equivalent). If still references python313.dll, your build environment is using Python 3.13—switch to Python 3.11.
    -   Check architecture: building 64-bit binary and running on 32-bit Windows will fail.
    -   If DLL exists but fails to load, ensure Visual C++ Redistributable is installed on target.

Optional: packaging for distribution

-   After verification, you can create a single-file executable (`--onefile`) or create an installer. Note that `--onefile` may hide extraction issues; keep `--onedir` for initial distribution to legacy environments.

If you want, I can create an automated CI job or further tweak the PyInstaller spec to force-include specific python DLLs.
