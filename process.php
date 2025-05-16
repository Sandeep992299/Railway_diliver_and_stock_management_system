<?php
session_start();
include('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sender_nic = mysqli_real_escape_string($conn, $_POST["sender_id"]);
    $rec_nic = mysqli_real_escape_string($conn, $_POST["receiver_id"]);
    $rec_name = mysqli_real_escape_string($conn, $_POST["receiver"]);
    $rec_phone = mysqli_real_escape_string($conn, $_POST["tel"]);
    $recieved_date = mysqli_real_escape_string($conn, $_POST["date"]);
    $pickup = mysqli_real_escape_string($conn, $_POST["pickup"]);
    $dropoff = mysqli_real_escape_string($conn, $_POST["drop"]);
    $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    $payment = mysqli_real_escape_string($conn, $_POST["pay"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    if (isset($_POST["create"])) {
        $insert = "INSERT INTO parcel 
            (parcel_id, sender_nic, rec_nic, rec_name, rec_phone, recieved_date, pickup, dropoff, weight, payment, status) 
            VALUES 
            ('$parcel_id', '$sender_nic', '$rec_nic', '$rec_name', '$rec_phone', '$recieved_date', '$pickup', '$dropoff', '$weight', '$payment', '$status')";

        if (mysqli_query($conn, $insert)) {
            $_SESSION["create"] = "Parcel Added Successfully!";
        } else {
            $_SESSION["error"] = "Error adding parcel: " . mysqli_error($conn);
        }
    }

    // Handle update 
    
    if (isset($_POST["update"])) {
        $update = "UPDATE parcel SET 
            sender_nic='$sender_nic', 
            rec_nic='$rec_nic', 
            rec_name='$rec_name', 
            rec_phone='$rec_phone', 
            recieved_date='$recieved_date',
            pickup='$pickup', 
            dropoff='$dropoff', 
            weight='$weight', 
            payment='$payment', 
            status='$status'
            WHERE parcel_id='$parcel_id'";

        if (mysqli_query($conn, $update)) {
            $_SESSION["update"] = "Parcel Updated Successfully!";
        } else {
            $_SESSION["error"] = "Error updating parcel: " . mysqli_error($conn);
        }
    }
    

    header("Location: customer_parcel.php");
    exit();
}
?>
