<?php
// Database connection
$host = 'us-cdbr-east-01.cleardb.net';
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

// Fetch all users
$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

$users = $result->fetch_all(MYSQLI_ASSOC);
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

<?php
$mysqli->close();
?>



