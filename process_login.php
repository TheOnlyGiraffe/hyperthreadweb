<?php
session_start();
require_once "db_Connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT id, username, password, is_admin FROM users WHERE username='$user' OR email='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                
                if ($row['is_admin'] == 1) {
                    $_SESSION['is_admin'] = true;
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid password.";
                header("Location: login.php");
                exit();
            }
        }
    } else {
        $_SESSION['login_error'] = "No user found.";
        header("Location: login.php");
        exit();
    }
}

$conn->close();
?>
