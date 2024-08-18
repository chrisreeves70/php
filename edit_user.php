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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$username, $email, $id]);

    header("Location: index.php");
    exit;
} else {
    $sql = "SELECT * FROM users WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>
        <button type=

