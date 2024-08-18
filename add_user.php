<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// MySQL connection settings from Heroku ClearDB
$servername = "us-cluster-east-01.k8s.cleardb.net";
$username = "bb9db01117ded9";
$password = "ae365e5b";
$dbname = "heroku_82f3c661d2b7b36";

try {
    // Capture start time for debugging
    $startTime = microtime(true);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Log connection time
    $connTime = microtime(true);
    error_log("Connection established in " . ($connTime - $startTime) . " seconds");

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $name, $email);

        // Set parameters and execute
        $name = $_POST['name'];
        $email = $_POST['email'];

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Log execution time
        $executionTime = microtime(true) - $connTime;
        error_log("Query executed in $executionTime seconds");

        echo "New record created successfully";

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add User</h2>
        <a href="index.php" class="btn btn-primary mb-3">Home</a>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add User</button>
        </form>
    </div>
</body>
</html>


