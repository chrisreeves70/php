<?php
// Database connection
$host = 'us-cluster-east-01.k8s.cleardb.net';
$dbname = 'heroku_82f3c661d2b7b36';
$username = 'bb9db01117ded9';
$password = 'ae365e5b';

$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Test the connection
if (!$mysqli->ping()) {
    die("Could not connect to the database.");
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
} else {
    die("Prepare failed: " . $mysqli->error);
}

header("Location: index.php");
exit;

$mysqli->close();
?>
