<?php
// Database connection
$dsn = 'mysql:host=us-cdbr-east-01.cleardb.net;dbname=heroku_82f3c661d2b7b36;charset=utf8mb4';
$username = 'bb9db01117ded9';
$password = 'ae365e5b';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
        PDO::ATTR_PERSISTENT => true
    ]);

    // Test connection
    $stmt = $pdo->query("SELECT 1");
    if (!$stmt) {
        die("Could not connect to the database.");
    }

} catch (PDOException $e) {
    error_log($e->getMessage(), 3, '/path/to/your/logs/error.log');
    die("Could not connect to the database: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->execute([$username, $email]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Add User</h1>
    <form action="add_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <button type="submit">Add User</button>
    </form>
    <a href="index.php">Back to User List</a>
</body>
</html>
