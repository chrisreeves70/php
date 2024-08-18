<?php
// Include database connection file
include 'db_connection.php';

// Create connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch users
$sql = "SELECT * FROM users"; // Use lowercase 'users'
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">User List</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th> <!-- Updated column name -->
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["username"]); ?></td> <!-- Updated column name -->
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
    </div>
</body>
</html>

<?php
// Close the connection
$mysqli->close();
?>
