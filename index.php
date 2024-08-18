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

// Fetch all users
$sql = "SELECT * FROM users";
$statement = $pdo->query($sql);
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>User List</h1>
    <a href="add_user.php">Add New User</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>



