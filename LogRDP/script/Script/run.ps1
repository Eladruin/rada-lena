$user = [Environment]::Username
$comp = [environment]::GetEnvironmentVariable("ClientName")
$date = Get-Date;
cd d:\logs
echo "$user $comp $date" >> log\ts.log
