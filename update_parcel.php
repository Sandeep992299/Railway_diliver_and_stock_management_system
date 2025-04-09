<?php
include("config.php"); 
session_start();

if (isset($_POST['edit'])) {
    // Get form data
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $sender_nic = mysqli_real_escape_string($conn, $_POST['sender_nic']);
    $receiver_nic = mysqli_real_escape_string($conn, $_POST['receiver_nic']);
    $receiver_name = mysqli_real_escape_string($conn, $_POST['receiver_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pickup = mysqli_real_escape_string($conn, $_POST['pickup']);
    $dropoff = mysqli_real_escape_string($conn, $_POST['dropoff']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update query
    $sqlUpdate = "UPDATE parcel SET 
                  sender_nic='$sender_nic', 
                  rec_nic='$receiver_nic', 
                  rec_name='$receiver_name', 
                  rec_phone='$phone', 
                  pickup='$pickup', 
                  dropoff='$dropoff', 
                  weight='$weight', 
                  status='$status' 
                  WHERE parcel_id='$parcel_id'";

    // Execute the query
    if (mysqli_query($conn, $sqlUpdate)) {
        $_SESSION['update'] = "Parcel updated successfully!";
        header("Location: parcel_t.php"); // Redirect back to parcel_t.php
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
