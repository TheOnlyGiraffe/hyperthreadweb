<?php
session_start();
require_once "db_Connect.php";

$username_err = $password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Login process
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
    } elseif (isset($_POST['register'])) {
        // Registration process
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate username
        if (empty(trim($username))) {
            $username_err = "Please enter a username.";
        }

        // Validate email
        if (empty(trim($email))) {
            $email_err = "Please enter an email.";
        } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } else {
            // Check if email already exists
            $sql = "SELECT id FROM users WHERE email = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_email);
                $param_email = trim($email);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $email_err = "This email is already taken.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }

        // Validate password
        if (empty(trim($password))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($password)) < 6) {
            $password_err = "Password must have at least 6 characters.";
        }

        // Check input errors before inserting into database
        if (empty($username_err) && empty($email_err) && empty($password_err)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO users (username, email, password, is_verified) VALUES (?, ?, ?, 1)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                if ($stmt->execute()) {
                    $_SESSION['register_success'] = true;
                    header("Location: login.php");
                    exit();
                } else {
                    $_SESSION['register_error'] = "Something went wrong. Please try again later.";
                    header("Location: register.php");
                    exit();
                }
            } else {
                $_SESSION['register_error'] = "Something went wrong. Please try again later.";
                header("Location: register.php");
                exit();
            }
        } else {
            $_SESSION['register_error'] = "Please correct the errors and try again.";
            header("Location: register.php");
            exit();
        }
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

   
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h3>Register Here</h3>

            <label for="reg_username">Username</label>
            <input type="text" placeholder="Username" id="reg_username" name="username" value="<?php echo $username; ?>" required>
            <span class="help-block"><?php echo $username_err; ?></span>

            <label for="reg_email">Email</label>
            <input type="email" placeholder="Email" id="reg_email" name="email" value="<?php echo $email; ?>" required>
            <span class="help-block"><?php echo $email_err; ?></span>

            <label for="reg_password">Password</label>
            <input type="password" placeholder="Password" id="reg_password" name="password" required>
            <span class="help-block"><?php echo $password_err; ?></span>

            <button type="submit" name="register">Register</button>
            
        </form>
    </section>

    <footer>
        <!-- Your footer content -->
    </footer>
</body>
</html>
