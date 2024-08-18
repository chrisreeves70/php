<?php
// Database connection settings
$servername = "us-cluster-east-01.k8s.cleardb.net";
$username = "bb9db01117ded9";
$password = "ae365e5b";
$dbname = "heroku_82f3c661d2b7b36";

// Create MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("UPDATE Users SET name = ?, email = ? WHERE id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("ssi", $name, $email, $id);
    if ($stmt->execute()) {
        echo "<p>User updated successfully.</p>";
    } else {
        die("Execute failed: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}

// Fetch user details
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM Users WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("User not found");
}

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit User</h1>
        <form method="post" action="edit_user.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
        <a href="view_users.php" class="btn btn-secondary mt-3">Back to User List</a>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
