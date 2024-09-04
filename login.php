<?php
session_start();
require_once "db_Connect.php";

$username_err = $password_err = "";

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
                    header("Location: Reseller/admin_dashboard.php");
                } else {
                    header("Location: Reseller/dashboard.php");
                }
                exit();
            } else {
                $password_err = "Invalid password.";
            }
        }
    } else {
        $username_err = "No user found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>HyperThread - Login</title>
    <link rel="stylesheet" href="css/login.css">
   
    <script defer src="app.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <a href="http://hyperthread.store">
                <img src="Images/logo.png">
            </a>
        </div>
        <!-- Rest of your navigation bar -->
    </nav>

   
        <div class="background"></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h3>Login Here</h3>
            
            <label for="username">Username</label>
            <input type="text" placeholder="Email or Username" id="username" name="username" required>
            <span class="help-block"><?php echo $username_err; ?></span>
    
            <label for="password">Password</label> 
            <input type="password" placeholder="Password" id="password" name="password" required>
            <span class="help-block"><?php echo $password_err; ?></span>
    
            <button type="submit">Log In</button>
            <div class="social">
                <a href="https://discord.gg/hyperthread" target="_blank" class="go"><i class="fab fa-discord"></i> Discord</a>
                <a href="register.php" target="_self" class="fb"><i class="fa-solid fa-user"></i> Register</a>
            </div>
        </form>
    </section>

    <footer>
        <!-- Your footer content -->
    </footer>
</body>
</html>
