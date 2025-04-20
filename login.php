<?php
session_start();
@include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    if (empty($_POST['userType']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error[] = 'All fields are required!';
    } else {
        $userType = mysqli_real_escape_string($conn, $_POST['userType']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Setting table and column names based on user type
        if ($userType == 'user') {
            $table = 'customer';
            $emailColumn = 'cus_email';
            $passwordColumn = 'cus_pass';
            $nameColumn = 'cus_name';
            $idColumn = 'cus_id'; // ID column for customer
            $role = 'customer';
        } elseif ($userType == 'employee') {
            $table = 'employee';
            $emailColumn = 'emp_email';
            $passwordColumn = 'emp_pass';
            $nameColumn = 'emp_name';
            $idColumn = 'emp_id'; // ID column for employee
            $role = 'employee';
        } else {
            $error[] = 'Invalid user type selected!';
        }

        if (!isset($error)) {
            // SQL query to get the user based on email
            $stmt = $conn->prepare("SELECT * FROM $table WHERE $emailColumn = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Ensure the row contains the necessary columns before accessing them
                if (isset($row[$passwordColumn])) {
                    if (password_verify($password, $row[$passwordColumn])) {
                        // Store user information in session
                        $_SESSION['temp_user'] = [
                            'id' => $row[$idColumn], // Use dynamic ID column
                            'name' => $row[$nameColumn],
                            'email' => $row[$emailColumn],
                            'role' => $role,
                            'table' => $table
                        ];

                        // Generate OTP
                        $otp = rand(100000, 999999);
                        $_SESSION['otp'] = $otp;

                        // Send OTP via PHPMailer
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'kandyrailwaystationofficial@gmail.com'; 
                            $mail->Password = 'nybp sxeg godn qjip'; 
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('kandyrailwaystationofficial@gmail.com', 'Kandy Railway Station');
                            $mail->addAddress($email, $row[$nameColumn]);
                            $mail->isHTML(true);
                            $mail->Subject = 'Your OTP Code';
                            $mail->Body = "<h3>Your OTP is: <strong>$otp</strong></h3><p>Do not share this code with anyone.</p>";

                            $mail->send();
                            header("Location: verify.php");
                            exit();
                        } catch (Exception $e) {
                            $error[] = "Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        $error[] = 'Incorrect email or password!';
                    }
                } else {
                    $error[] = 'Database column for password does not exist.';
                }
            } else {
                $error[] = 'User not found!';
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="images/1.png" alt="Logo" style="width: 60px; height: 60px; border-radius: 50%;">
        </div>

        <h1>Login</h1>
        <?php
        if(isset($error)){
            foreach($error as $msg){
                echo '<span class="error-msg">'.$msg.'</span>';
            }
        }
        ?>
        
        <form id="loginForm" method="POST">
            <div class="input-box">
                <select id="userType" name="userType" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="user">User</option>
                    <option value="employee">Employee</option>
                </select>
            </div>

            <div class="input-box">
                <input id="email" type="text" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input id="password" type="password" name="password" placeholder="Password" required>
            </div>
    
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#">Forgot Password?</a>
            </div>
    
            <button type="submit" class="btn" name="submit">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
