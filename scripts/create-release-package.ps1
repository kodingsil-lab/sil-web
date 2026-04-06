param(
    [string]$ProjectRoot = (Get-Location).Path
)

$ErrorActionPreference = 'Stop'

$timestamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$deployDir = Join-Path $ProjectRoot 'deploy'
$themeDir = Join-Path $ProjectRoot 'wp-content\themes\sil-portfolio'
$pluginDir = Join-Path $ProjectRoot 'wp-content\plugins\sil-core'
$uploadsDir = Join-Path $ProjectRoot 'wp-content\uploads'
$dbFile = Join-Path $deployDir "database-$timestamp.sql"
$themeZip = Join-Path $deployDir "sil-portfolio-theme-$timestamp.zip"
$pluginZip = Join-Path $deployDir "sil-core-plugin-$timestamp.zip"
$uploadsZip = Join-Path $deployDir "uploads-$timestamp.zip"

if (-not (Test-Path $deployDir)) {
    New-Item -ItemType Directory -Path $deployDir | Out-Null
}

Write-Host 'Build asset production...' -ForegroundColor Cyan
Push-Location $themeDir
try {
    npx @tailwindcss/cli -i ./assets/css/input.css -o ./assets/css/output.css --minify
} finally {
    Pop-Location
}

Write-Host 'Export database...' -ForegroundColor Cyan
Push-Location $ProjectRoot
try {
    wp db export $dbFile --add-drop-table
} finally {
    Pop-Location
}

Write-Host 'Buat ZIP theme...' -ForegroundColor Cyan
if (Test-Path $themeZip) {
    Remove-Item $themeZip -Force
}
Compress-Archive -Path $themeDir -DestinationPath $themeZip -CompressionLevel Optimal

Write-Host 'Buat ZIP plugin...' -ForegroundColor Cyan
if (Test-Path $pluginZip) {
    Remove-Item $pluginZip -Force
}
Compress-Archive -Path $pluginDir -DestinationPath $pluginZip -CompressionLevel Optimal

if (Test-Path $uploadsDir) {
    Write-Host 'Buat ZIP uploads...' -ForegroundColor Cyan
    if (Test-Path $uploadsZip) {
        Remove-Item $uploadsZip -Force
    }
    Compress-Archive -Path $uploadsDir -DestinationPath $uploadsZip -CompressionLevel Optimal
}

Write-Host ''
Write-Host 'Release package selesai dibuat di folder deploy:' -ForegroundColor Green
Write-Host $deployDir
