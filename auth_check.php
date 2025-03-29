<?php
session_start();

if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

// Define allowed pages for each user type
$allowedPages = [
    'customer' => ['main.php', 'customer_parcel.php'],
    'employee' => ['main.php', 'customer_parcel.php', 'govStock.php', 'tracking.php', 'fuel.php', 'notifications.php', 'reports.php']
];

// Get the current script name
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the user is trying to access an unauthorized page
if ($_SESSION['user_role'] == 'customer' && !in_array($current_page, $allowedPages['customer'])) {
    die("Access Denied! You are not allowed to access this page.");
}
?>
