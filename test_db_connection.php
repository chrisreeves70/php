<?php
// Connection details from CLEARDB_DATABASE_URL
$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'bb9db01117ded9';
$pass = 'ae365e5b';
$dbname = 'heroku_82f3c661d2b7b36';

// Create a connection using mysqli
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo 'Connected successfully to the database';
?>
