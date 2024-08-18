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

require 'vendor/autoload.php'; // Include Composer autoload

// Redis connection settings
$redis = new Predis\Client(getenv('REDIS_URL'));

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug log
    error_log("POST request received");

    // Debug log start time
    $start_time = microtime(true);

    // Prepare job data
    $jobData = json_encode([
        'name' => $_POST['name'],
        'email' => $_POST['email']
    ]);

    // Push job to Redis queue
    $redis->lpush('job_queue', $jobData);

    // Debug log end time and execution time
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time);
    error_log("Execution Time: " . $execution_time . " seconds");

    echo "User addition job has been added to the queue.";

    // No need to close the database connection here
}
?>

<!-- HTML form -->
<form method="post" action="">
    Name: <input type="text" name="name" required>
    Email: <input type="email" name="email" required>
    <input type="submit" value="Add User">
</form>

