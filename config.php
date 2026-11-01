<?php
// Database connection settings come from Railway environment variables.
$db_host = getenv('MYSQLHOST') ?: 'localhost';
$db_user = getenv('MYSQLUSER') ?: 'root';
$db_pass = getenv('MYSQLPASSWORD') ?: '';
$db_name = getenv('MYSQLDATABASE') ?: '';
$db_port = (int)(getenv('MYSQLPORT') ?: 3306);

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
if (!$conn) {
    http_response_code(500);
    error_log('DB connection failed: ' . mysqli_connect_error());
    die('Database connection failed.');
}
mysqli_set_charset($conn, 'utf8mb4');
