<?php
// MySQL connection settings from Heroku ClearDB
$servername = "us-cluster-east-01.k8s.cleardb.net";
$username = "bb9db01117ded9";
$password = "ae365e5b";
$dbname = "heroku_82f3c661d2b7b36";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test query
$result = $conn->query("SELECT 1");
if ($result === false) {
    die("Query failed: " . $conn->error);
} else {
    echo "Simple query executed successfully<br>";
}

// Collect POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $name, $email);

    // Execute the query
    if ($stmt->execute()) {
        echo "User added successfully<br>";
    } else {
        die("Execute failed: " . $stmt->error);
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!-- HTML form -->
<form method="post" action="">
    Name: <input type="text" name="name" required>
    Email: <input type="email" name="email" required>
    <input type="submit" value="Add User">
</form>

