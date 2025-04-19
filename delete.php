<?php
include("config.php"); // Include database connection
session_start();

if (isset($_GET['id'])) {
    $parcel_id = mysqli_real_escape_string($conn, $_GET['id']); // Secure input

    // Delete query
    $sqlDelete = "DELETE FROM parcel WHERE parcel_id='$parcel_id'";

    // Execute the query
    if (mysqli_query($conn, $sqlDelete)) {
        $_SESSION['delete'] = "Parcel deleted successfully!";
        header("Location: parcel_t.php"); // Redirect back to parcel_t.php
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
