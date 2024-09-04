<?php
session_start();

// Include database connection
require_once "db_Connect.php";

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Function to add an admin
function addAdmin($username, $password) {
    global $conn;
    $username = sanitize($username);
    $password = sanitize($password);
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Admin added successfully.');</script>";
    } else {
        echo "<script>alert('Error adding admin.');</script>";
    }
}

// Handle admin addition form submission
if (isset($_POST['add_admin'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    
    addAdmin($new_username, $new_password);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-setup-container">
        <h2>Admin Setup</h2>
        <form method="post" action="">
            <div class="input-group">
                <label for="new_username">New Admin Username:</label>
                <input type="text" id="new_username" name="new_username" required>
            </div>
            <div class="input-group">
                <label for="new_password">New Admin Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="add_admin">Add Admin</button>
        </form>
    </div>
</body>
</html>
