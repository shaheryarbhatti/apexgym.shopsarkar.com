param(
    [string]$Source = "C:\\xampp\\htdocs\\gym",
    [string]$Target = "C:\\xampp\\htdocs\\gymmanagementsystem",
    [string]$YakproPath = "C:\\tools\\yakpro-po\\yakpro-po.php"
)

if (-not (Test-Path -Path $Source)) {
    Write-Error "Source path not found: $Source"
    exit 1
}

if (-not (Test-Path -Path $Target)) {
    Write-Error "Target path not found: $Target"
    exit 1
}

if (-not (Test-Path -Path $YakproPath)) {
    Write-Error "yakpro-po not found: $YakproPath"
    Write-Error "Update -YakproPath to your yakpro-po.php location."
    exit 1
}

$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$backupPath = "${Target}_backup_$timestamp"
Write-Host "Creating backup of target:" $Target
Copy-Item -Path $Target -Destination $backupPath -Recurse -Force
Write-Host "Backup created at:" $backupPath
Write-Host ""

# Keep only the 2 most recent backups
$backupPrefix = (Split-Path -Path $Target -Leaf) + "_backup_"
$backupDir = Split-Path -Path $Target -Parent
$backups = Get-ChildItem -Path $backupDir -Directory |
    Where-Object { $_.Name -like "$backupPrefix*" } |
    Sort-Object Name -Descending

if ($backups.Count -gt 2) {
    $toDelete = $backups | Select-Object -Skip 2
    foreach ($item in $toDelete) {
        Write-Host "Removing old backup:" $item.FullName
        Remove-Item -Path $item.FullName -Recurse -Force
    }
}

Write-Host "Obfuscating source:" $Source
Write-Host "Output target:" $Target
Write-Host "Yakpro path:" $YakproPath
Write-Host ""
Write-Host "Note: This will overwrite matching files in the target directory."
Write-Host "Ensure your original source stays in gym."
Write-Host ""

& php $YakproPath -o $Target $Source
if ($LASTEXITCODE -ne 0) {
    Write-Error "yakpro-po failed with exit code $LASTEXITCODE"
    exit $LASTEXITCODE
}

Write-Host "Obfuscation complete."
