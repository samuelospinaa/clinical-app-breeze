# Levanta el entorno local: MySQL propio (puerto 3307), Laravel (8000) y Vite (5173).
# Uso: .\dev.ps1
$php = "$env:USERPROFILE\php83"
$env:Path = "$php;$env:Path"
$env:NODE_EXTRA_CA_CERTS = "$php\cacert-win.pem"   # AVG intercepta TLS

$myBase = "C:\Program Files\MySQL\MySQL Server 8.0"
$myData = "$env:USERPROFILE\mysql-dev\data"
if (-not (Get-NetTCPConnection -LocalPort 3307 -State Listen -ErrorAction SilentlyContinue)) {
   Start-Process "$myBase\bin\mysqld.exe" -WindowStyle Hidden -ArgumentList `
      "--no-defaults", "--basedir=`"$myBase`"", "--datadir=`"$myData`"", "--port=3307", "--bind-address=127.0.0.1", "--mysqlx=OFF"
   Start-Sleep 10
}
if (-not (Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue)) {
   Start-Process php -WindowStyle Hidden -ArgumentList "artisan", "serve", "--port=8000"
}
if (-not (Get-NetTCPConnection -LocalPort 5173 -State Listen -ErrorAction SilentlyContinue)) {
   Start-Process cmd -WindowStyle Hidden -ArgumentList "/c", "pnpm dev"
}
Write-Host "Listo -> http://127.0.0.1:8000/admin  (admin@dev.test / password)"
