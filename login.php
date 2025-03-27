<?php
session_start(); 
@include 'config.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $userType = mysqli_real_escape_string($conn, $_POST['userType']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); 

    // Determine which table to query based on the user type
    if ($userType == 'user') {
        $table = 'customer';
        $emailColumn = 'cus_email';
        $passwordColumn = 'cus_pass';
        $nameColumn = 'cus_name';
        $idColumn = 'cus_id'; 
        $role = 'customer'; 
    } elseif ($userType == 'employee') {
        $table = 'employee';
        $emailColumn = 'emp_email';
        $passwordColumn = 'emp_pass';
        $nameColumn = 'emp_name';
        $idColumn = 'emp_id'; 
        $role = 'employee'; 
    } else {
        $error[] = 'Invalid user type selected!';
    }

    if (!isset($error)) {
        // Query to check if the user exists
        $select = "SELECT * FROM $table WHERE $emailColumn = '$email' AND $passwordColumn = '$password'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data
            $row = mysqli_fetch_array($result);

            // Set session variables
            $_SESSION['user_id'] = $row[$idColumn];
            $_SESSION['user_name'] = $row[$nameColumn];
            $_SESSION['user_email'] = $row[$emailColumn];
            $_SESSION['user_role'] = $role; 

            // Redirect based on role
            if ($role == 'customer') {
                header('location: customer_dashboard.php');
            } else {
                header('location: employee_dashboard.php');
            }
            exit();
        } else {
            $error[] = 'Incorrect email or password!';
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
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <!-- Login Container -->
    <div class="login-container">
        <!-- Logo overlapping the login form -->
        <div class="logo">
            <img src="images/1.png" alt="Logo" style="width: 60px; height: 60px; border-radius: 50%;">
        </div>

        <h1>Login</h1>
        <?php
        if(isset($error)){
            foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
            };
        };
        ?>
        
        <form id="loginForm" method="POST" action="{{ route('login') }}">

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
    
            <button type="button" class="btn" name="login" onclick="window.location.href='main.php';">Login</button>

    
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>