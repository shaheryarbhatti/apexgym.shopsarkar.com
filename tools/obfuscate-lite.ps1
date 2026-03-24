param(
    [string]$Source = "C:\\xampp\\htdocs\\gym",
    [string]$Target = "C:\\xampp\\htdocs\\gymmanagementsystem",
    [switch]$Medium,
    [switch]$Aggressive,
    [switch]$Views
)

if (-not (Test-Path -Path $Source)) {
    Write-Error "Source path not found: $Source"
    exit 1
}

if (-not (Test-Path -Path $Target)) {
    Write-Error "Target path not found: $Target"
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

Write-Host "Lite obfuscation from:" $Source
Write-Host "Output target:" $Target
Write-Host ""

$args = @()
if ($Aggressive) {
    $args += '--aggressive'
} elseif ($Medium) {
    $args += '--medium'
}
if ($Views) {
    $args += '--views'
}

& php "C:\\xampp\\htdocs\\gym\\tools\\obfuscate-lite.php" $Source $Target @args
if ($LASTEXITCODE -ne 0) {
    Write-Error "obfuscate-lite failed with exit code $LASTEXITCODE"
    exit $LASTEXITCODE
}

Write-Host "Lite obfuscation complete."
