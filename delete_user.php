<?php
// Database connection
$dsn = 'mysql:host=us-cdbr-east-01.cleardb.net;dbname=heroku_82f3c661d2b7b36;charset=utf8mb4';
$username = 'bb9db01117ded9';
$password = 'ae365e5b';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
        PDO::ATTR_PERSISTENT => true,
    ]);

    // Test the connection
    $stmt = $pdo->query("SELECT 1");
    if (!$stmt) {
        die("Could not connect to the database.");
    }
} catch (PDOException $e) {
    // Attempt to reconnect
    for ($i = 0; $i < 3; $i++) {
        try {
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_PERSISTENT => true,
            ]);
            // Test the connection again
            $stmt = $pdo->query("SELECT 1");
            if ($stmt) {
                break;
            }
        } catch (PDOException $e) {
            if ($i == 2) {
                die("Could not connect to the database after multiple attempts: " . $e->getMessage());
            }
            sleep(1); // Wait before retrying
        }
    }
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$statement = $pdo->prepare($sql);
$statement->execute([$id]);

header("Location: index.php");
exit;
?>
