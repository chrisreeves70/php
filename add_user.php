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
        <form method="post" action="add_user.php" class="mt-3">
            Name: <input type="text" name="name" required class="form-control mb-2">
            Email: <input type="email" name="email" required class="form-control mb-2">
            <input type="submit" value="Add User" class="btn btn-success">
        </form>
    </div>
</body>
</html>

