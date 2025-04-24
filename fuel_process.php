<?php
include 'config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $volume = isset($_POST['volume']) ? (int)$_POST['volume'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Check if volume is valid and action is either 'add' or 'remove'
    if ($volume <= 0 || !in_array($action, ['add', 'remove'])) {
        echo "Invalid input.";
        exit;
    }

    // Fetch the current fuel amount from the database
    $query = "SELECT fuel_remain FROM fuel ORDER BY fuel_id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $currentFuel = $row ? (int)$row['fuel_remain'] : 0;

    // Calculate new fuel level based on the action (add/remove)
    if ($action === 'add') {
        $newFuel = $currentFuel + $volume;
        $status = 'added';
    } else {
        if ($volume > $currentFuel) {
            echo "Error: Not enough fuel to remove.";
            exit;
        }
        $newFuel = $currentFuel - $volume;
        $status = 'removed';
    }

    // Insert the new fuel entry into the database
    $stmt = mysqli_prepare($conn, "INSERT INTO fuel (fuel_vol, fuel_status, fuel_remain) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isi", $volume, $status, $newFuel);

    if (mysqli_stmt_execute($stmt)) {
        // If the insert is successful, redirect back to the fuel management page
        header("Location: fuel.php");
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
