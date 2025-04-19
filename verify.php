<?php
session_start();

if (!isset($_SESSION['otp']) || !isset($_SESSION['user_email'])) {
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];

    if (time() - $_SESSION['otp_time'] > 300) {
        $error = "OTP expired. Please login again.";
        session_destroy();
    } elseif ($enteredOtp == $_SESSION['otp']) {
        // OTP is correct
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);

        // Redirect based on role
        if ($_SESSION['user_role'] == 'customer') {
            header('location: main.php');
        } else {
            header('location: employee_dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1>OTP Verification</h1>
        <?php if (isset($error)) echo "<span class='error-msg'>$error</span>"; ?>

        <form method="POST">
            <div class="input-box">
                <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn">Verify</button>
        </form>
    </div>
</body>
</html>
