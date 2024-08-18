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
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    error_log("Connection established successfully.");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Log POST data for debugging
        error_log("POST Data: " . print_r($_POST, true));

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        error_log("Statement prepared successfully.");

        $stmt->bind_param("ss", $name, $email);

        // Set parameters and execute
        $name = $_POST['name'];
        $email = $_POST['email'];

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        error_log("Record inserted successfully.");

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
