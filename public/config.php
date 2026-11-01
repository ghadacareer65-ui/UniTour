<?php

// Google OAuth

define('GOOGLE_CLIENT_ID', getenv('GOOGLE_CLIENT_ID') ?: '');

define('GOOGLE_CLIENT_SECRET', getenv('GOOGLE_CLIENT_SECRET') ?: '');

define('GOOGLE_REDIRECT_URI', getenv('GOOGLE_REDIRECT_URI') ?: 'http://localhost/unitour/public/google_callback.php' );



// Database connection (works on XAMPP and Railway)
$host     = getenv('MYSQLHOST')     ?: "127.0.0.1";
$user     = getenv('MYSQLUSER')     ?: "root";
$password = getenv('MYSQLPASSWORD') ?: "";
$database = getenv('MYSQLDATABASE') ?: "uni_tour_db";
$port     = (int)(getenv('MYSQLPORT') ?: 3306);

$conn = new mysqli($host, $user, $password, $database, $port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>