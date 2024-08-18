<?php
require 'vendor/autoload.php'; // Include Composer autoload

// Redis connection settings
$redis = new Predis\Client(getenv('REDIS_URL'));

// MySQL connection settings
$servername = "us-cluster-east-01.k8s.cleardb.net";
$username = "bb9db01117ded9";
$password = "ae365e5b";
$dbname = "heroku_82f3c661d2b7b36";

function processJob($name, $email) {
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        return;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        return;
    }

    $stmt->bind_param("ss", $name, $email);

    // Execute the statement
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
    } else {
        error_log("Record inserted successfully: Name = $name, Email = $email");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Process jobs from the Redis queue
while (true) {
    $jobData = $redis->rpop('job_queue'); // Retrieve a job from the queue
    if ($jobData) {
        $job = json_decode($jobData, true);
        processJob($job['name'], $job['email']);
    }
    sleep(5); // Check the queue every 5 seconds
}
