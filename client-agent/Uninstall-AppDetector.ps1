param(
    [string]$InstallDir = "$env:LOCALAPPDATA\apk",
    [switch]$RemoveScheduledTask = $false
)

Write-Output "Uninstalling apk from $InstallDir"

# remove startup link
$startup = Join-Path $env:APPDATA 'Microsoft\Windows\Start Menu\Programs\Startup'
$lnk = Join-Path $startup 'apk.lnk'
if (Test-Path $lnk) { Remove-Item $lnk -Force; Write-Output "Removed startup shortcut" }

# remove registry run
$runName = 'apk'
if ((Get-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Run' -Name $runName -ErrorAction SilentlyContinue)) {
    Remove-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Run' -Name $runName -ErrorAction SilentlyContinue
    Write-Output "Removed HKCU Run entry"
}

# optional: remove scheduled task
if ($RemoveScheduledTask) {
    try {
        schtasks /Delete /TN 'apk' /F | Out-Null
        Write-Output "Removed scheduled task apk"
    } catch {
        Write-Warning "Failed to remove scheduled task: $_"
    }
}

# remove folder
if (Test-Path $InstallDir) {
    try {
        Remove-Item -Path $InstallDir -Recurse -Force
        Write-Output "Removed folder $InstallDir"
    } catch {
        Write-Warning "Failed to remove folder: $_"
    }
}

Write-Output "Uninstall complete."
