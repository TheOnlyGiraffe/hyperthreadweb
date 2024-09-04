<!-- generate_invite_code.php -->
<?php
session_start();
require_once 'db_connect.php'; // Replace with your database connection script

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid_until = $_POST['valid_until'];
    
    // Generate unique code
    $code = generateInviteCode();
    
    // Insert into database
    $sql = "INSERT INTO admin_invite_codes (code, valid_until, used_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $code, $valid_until, $_SESSION['admin_id']);
    $stmt->execute();
    $stmt->close();
    
    echo "Invite code generated successfully: $code";
}

function generateInviteCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}
?>
