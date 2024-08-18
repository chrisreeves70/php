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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Prepare failed: " . $mysqli->error);
    }

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

<?php
$mysqli->close();
?>
