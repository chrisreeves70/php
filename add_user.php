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

// Function to create and return a database connection
function getConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Collect POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (empty($name) || empty($email)) {
        echo "Name and email are required.";
    } else {
        // Create connection
        $conn = getConnection();

        // Log connection time
        $start_time = microtime(true);

        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $name, $email);

        // Execute the query
        if ($stmt->execute()) {
            echo "User added successfully";
        } else {
            echo "Error adding user: " . $stmt->error;
        }

        // Log query execution time
        $execution_time = microtime(true) - $start_time;
        echo "<br>Query execution time: " . $execution_time . " seconds";

        // Close statement
        $stmt->close();

        // Close connection
        $conn->close();
    }
}
?>

<!-- HTML form -->
<a href="view_users.php">View Users</a>
<br><br>
<form method="post" action="">
    Name: <input type="text" name="name" required>
    

