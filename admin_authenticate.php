<?php
session_start();
require_once 'db_connect.php'; // Replace with your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate credentials
    $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, set up session variables
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            
            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = "Incorrect password.";
        }
    } else {
        // Admin not found
        $_SESSION['login_error'] = "Admin not found.";
    }
    
    // Close statement and database connection
    $stmt->close();
    $conn->close();
    
    // Redirect back to admin login page with error message
    header("Location: admin_login.php");
    exit();
}
?>
