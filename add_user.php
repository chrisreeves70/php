<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add New User</h1>
        <a href="index.php" class="btn btn-primary mt-3">Home</a>

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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ss", $name, $email);

            // Set parameters and execute
            $name = $_POST['name'];
            $email = $_POST['email'];

            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }

            echo "<div class='alert alert-success mt-3'>New record created successfully</div>";

            // Close the statement
            $stmt->close();

            // Close the connection
            $conn->close();
        }
        ?>

        <form method="post" action="add_user.php" class="mt-3">
            Name: <input type="text" name="name" required class="form-control mb-2">
            Email: <input type="email" name="email" required class="form-control mb-2">
            <input type="submit" value="Add User" class="btn btn-success">
        </form>
    </div>
</body>
</html>
