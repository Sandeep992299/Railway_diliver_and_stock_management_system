<?php
session_start(); 
@include 'config.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Validate input fields
    if (empty($_POST['userType']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error[] = 'All fields are required!';
    } else {
        // Get form data
        $userType = mysqli_real_escape_string($conn, $_POST['userType']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password']; 

        // Determine table and columns based on user type
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
            // Query to check if the user exists using prepared statement
            $stmt = $conn->prepare("SELECT * FROM $table WHERE $emailColumn = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $row[$passwordColumn])) {
                    // Set session variables
                    $_SESSION['user_id'] = $row[$idColumn];
                    $_SESSION['user_name'] = $row[$nameColumn];
                    $_SESSION['user_email'] = $row[$emailColumn];
                    $_SESSION['user_role'] = $role; 

                    // Redirect based on role
                    if ($role == 'customer') {
                        header('location: main.php');
                    } else {
                        header('location: employee_dashboard.php');
                    }
                    exit();
                } else {
                    $error[] = 'Incorrect email or password!';
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
