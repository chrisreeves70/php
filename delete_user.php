<?php
// Database connection details
$host = 'us-cdbr-east-01.cleardb.net';
$dbname = 'heroku_82f3c661d2b7b36';
$username = 'bb9db01117ded9';
$password = 'ae365e5b';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$statement = $pdo->prepare($sql);
$statement->execute([$id]);

header("Location: index.php");
exit;
?>
