<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// MySQL connection settings
$servername = "us-cluster-east-01.k8s.cleardb.net";
$username = "bb9db01117ded9";
$password = "ae365e5b";
$dbname = "heroku_82f3c661d2b7b36";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid input.");
        }

        // Debug log start time
        $start_time = microtime(true);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $name, $email);

        // Set parameters and execute
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Debug log end time and execution time
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        error_log("Execution Time: " . $execution_time . " seconds");

        echo "New record created successfully";

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    error_log("Error: " . $e->getMessage());
}
?>

<!-- HTML form -->
<form method="post" action="">
    Name: <input type="text" name="name" required>
    Email: <input type="email" name="email" required>
    <input type="submit" value="Add User">
</form>
