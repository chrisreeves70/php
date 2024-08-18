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

    // Check if ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare and execute the delete query
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        echo "User deleted successfully";
        $stmt->close();
    } else {
        echo "No user ID provided";
    }

    // Close the connection
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
