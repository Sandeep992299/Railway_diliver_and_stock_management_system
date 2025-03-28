<?php
@include 'config.php';

// Initialize variables
$error = [];
$success = false;

if (isset($_POST['register'])) {
    // Common Fields
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirmation'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format';
    }

    // Validate password
    if (strlen($password) < 8) {
        $error[] = 'Password must be at least 8 characters long';
    }

    // Check if passwords match
    if ($password != $confirm_password) {
        $error[] = 'Passwords do not match!';
    }

    if (empty($error)) {
        // Check if email already exists
        if ($role == 'customer') {
            $check_email = "SELECT * FROM customer WHERE cus_email = '$email'";
        } elseif ($role == 'employee') {
            $check_email = "SELECT * FROM employee WHERE emp_email = '$email'";
        }

        $result = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into customer or employee table based on role
            if ($role == 'customer') {
                $cus_nic = mysqli_real_escape_string($conn, $_POST['Cus_NIC']);
                $cus_name = mysqli_real_escape_string($conn, $_POST['Cus_Name']);
                $cus_phone = mysqli_real_escape_string($conn, $_POST['Cus_TP']);

                $insert = "INSERT INTO customer (cus_nic, cus_name, cus_phone, cus_email, cus_pass) 
                           VALUES ('$cus_nic', '$cus_name', '$cus_phone', '$email', '$hashed_password')";

            } elseif ($role == 'employee') {
                $emp_id = mysqli_real_escape_string($conn, $_POST['Em_ID']);
                $emp_nic = mysqli_real_escape_string($conn, $_POST['Em_NIC']);
                $emp_name = mysqli_real_escape_string($conn, $_POST['Em_Name']);
                $emp_phone = mysqli_real_escape_string($conn, $_POST['Em_TP']);
                $emp_position = mysqli_real_escape_string($conn, $_POST['Position']);
                $emp_station = mysqli_real_escape_string($conn, $_POST['Station_Name']);
                $dbo = mysqli_real_escape_string($conn, $_POST['DOB']);
                $emp_age = mysqli_real_escape_string($conn, $_POST['age']);

                $insert = "INSERT INTO employee(emp_id, emp_nic, emp_name, emp_phone, emp_position, emp_station, dbo, emp_age, emp_email, emp_pass) 
                          VALUES ('$emp_id', '$emp_nic', '$emp_name', '$emp_phone', '$emp_position', '$emp_station', '$dbo', '$emp_age', '$email', '$hashed_password')";
            }

            // Execute the query
            if (mysqli_query($conn, $insert)) {
                $success = true;
                header('Location: login.php?registration=success');
                exit();
            } else {
                $error[] = 'Registration failed: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Railway System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('images/railwaystation.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Left side with image -->
            <div class="hidden md:block md:w-1/2 bg-[#8de149]">
                <div class="h-full flex items-center justify-center p-8">
                    <div class="text-white text-center">
                        <h1 class="text-3xl font-bold mb-4">Join Our Railway System</h1>
                        <p class="mb-6">Register now to access all features and services</p>
                        <div class="flex justify-center">
                            <img src="images/1.png" alt="Railway Logo" class="w-24 h-24 object-contain">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right side with form -->
            <div class="w-full md:w-1/2 p-8 form-container">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Create Account</h2>
                <p class="text-gray-600 mb-6">Please fill in your details</p>
                
                <!-- Error messages -->
                <?php if(!empty($error)): ?>
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <?php foreach($error as $err): ?>
                            <p><?php echo $err; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Registration Form -->
                <form method="POST" action="#" class="space-y-4">
                    <!-- Select Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Register As</label>
                        <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" onchange="toggleFields()">
                            <option value="customer">Customer</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>

                    <!-- Customer Form Fields -->
                    <div id="customer-fields" class="space-y-4 hidden">
                        <div>
                            <label for="Cus_NIC" class="block text-sm font-medium text-gray-700 mb-1">NIC Number</label>
                            <input type="text" id="Cus_NIC" name="Cus_NIC" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Enter your NIC">
                        </div>
                        <div>
                            <label for="Cus_Name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="Cus_Name" name="Cus_Name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Your full name">
                        </div>
                        <div>
                            <label for="Cus_TP" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="Cus_TP" name="Cus_TP" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="+94 7X XXX XXXX">
                        </div>
                    </div>

                    <!-- Employee Form Fields -->
                    <div id="employee-fields" class="space-y-4 hidden">
                        <div>
                            <label for="Em_ID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
                            <input type="text" id="Em_ID" name="Em_ID" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="EMP-XXXX">
                        </div>
                        <div>
                            <label for="Em_NIC" class="block text-sm font-medium text-gray-700 mb-1">NIC Number</label>
                            <input type="text" id="Em_NIC" name="Em_NIC" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Enter your NIC">
                        </div>
                        <div>
                            <label for="Em_Name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="Em_Name" name="Em_Name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Your full name">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="Em_TP" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" id="Em_TP" name="Em_TP" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="+94 7X XXX XXXX">
                            </div>
                            <div>
                                <label for="Position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                <input type="text" id="Position" name="Position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Your position">
                            </div>
                        </div>
                        <div>
                            <label for="Station_Name" class="block text-sm font-medium text-gray-700 mb-1">Station</label>
                            <input type="text" id="Station_Name" name="Station_Name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Assigned station">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="DOB" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" id="DOB" name="DOB" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition">
                            </div>
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <input type="number" id="age" name="age" min="18" max="65" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition">
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="your@email.com" required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="At least 8 characters" required>
                            <button type="button" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8de149] focus:border-[#8de149] transition" placeholder="Confirm your password" required>
                            <button type="button" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="register" class="w-full py-3 px-4 bg-[#8de149] hover:bg-[#7bcb3a] text-white font-semibold rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#8de149] focus:ring-offset-2">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">Already have an account? <a href="login.php" class="text-[#8de149] hover:text-[#7bcb3a] font-medium">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle between customer and employee fields
        function toggleFields() {
            const role = document.getElementById('role').value;
            document.getElementById('customer-fields').classList.toggle('hidden', role !== 'customer');
            document.getElementById('employee-fields').classList.toggle('hidden', role !== 'employee');
        }
        
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Initialize fields on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
        });
    </script>
</body>
</html>