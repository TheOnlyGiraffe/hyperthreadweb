<?php
session_start();
require_once "db_Connect.php";

$email = $code = "";
$email_err = $code_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate code
    if (empty(trim($_POST["code"]))) {
        $code_err = "Please enter the verification code.";
    } else {
        $code = trim($_POST["code"]);
    }

    // Check input errors before verifying in database
    if (empty($email_err) && empty($code_err)) {
        $sql = "SELECT id, code_expiry FROM users WHERE email = ? AND verification_code = ? AND is_verified = 0";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $email, $code);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $code_expiry);
                    if ($stmt->fetch()) {
                        if (new DateTime() < new DateTime($code_expiry)) {
                            // Verification successful, update user status
                            $update_sql = "UPDATE users SET is_verified = 1, verification_code = NULL, code_expiry = NULL WHERE id = ?";
                            if ($update_stmt = $conn->prepare($update_sql)) {
                                $update_stmt->bind_param("i", $id);
                                if ($update_stmt->execute()) {
                                    $_SESSION['verification_success'] = true;
                                    header("Location: login.php");
                                    exit();
                                } else {
                                    $_SESSION['verification_error'] = "Something went wrong. Please try again later.";
                                    header("Location: verify.php");
                                    exit();
                                }
                            }
                        } else {
                            $_SESSION['verification_error'] = "Verification code expired. Please register again.";
                            header("Location: register.php");
                            exit();
                        }
                    }
                } else {
                    $_SESSION['verification_error'] = "Invalid verification code.";
                    header("Location: verify.php");
                    exit();
                }
            } else {
                $_SESSION['verification_error'] = "Something went wrong. Please try again later.";
                header("Location: verify.php");
                exit();
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <link rel="stylesheet" href="css/verify.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Verify Your Email</h3>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
        <span class="help-block"><?php echo $email_err; ?></span>

        <label for="code">Verification Code</label>
        <input type="text" id="code" name="code" required>
        <span class="help-block"><?php echo $code_err; ?></span>

        <button type="submit">Verify</button>
    </form>
</body>
</html>
