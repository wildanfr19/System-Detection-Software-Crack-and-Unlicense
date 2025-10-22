<#
Uninstall-AppDetector.ps1
Removes AppDetector installation created by Install-AppDetector.ps1
#>

param(
    [string]$InstallFolder = "$env:LOCALAPPDATA\AppDetector",
    [string]$TaskName = "AppDetector",
    [switch]$Force
)

function Stop-And-Remove-Task($name){
    try{ Unregister-ScheduledTask -TaskName $name -Confirm:$false -ErrorAction Stop; Write-Host "Removed scheduled task $name" }catch{ Write-Warning "Unregister-ScheduledTask failed: $_" }
    # also try schtasks delete
    try{ cmd.exe /C "schtasks /Delete /TN \"$name\" /F" | Out-Null; Write-Host "schtasks delete attempted for $name" }catch{}
}

if(Test-Path $InstallFolder){
    Write-Host "Removing files in $InstallFolder"
    Remove-Item -Path $InstallFolder -Recurse -Force -ErrorAction SilentlyContinue
} else { Write-Host "Install folder not found: $InstallFolder" }

Stop-And-Remove-Task -name $TaskName
Write-Host "Uninstall complete."
