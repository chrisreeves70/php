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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $username, $email, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Prepare failed: " . $mysqli->error);
    }

    header("Location: index.php");
    exit;
} else {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            die("User not found.");
        }
    } else {
        die("Prepare failed: " . $mysqli->error);
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
    <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>
        <button type="submit">Update User</button>
    </form>
    <a href="index.php">Back to User List</a>
</body>
</html>

<?php
$mysqli->close();
?>

