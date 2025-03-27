<?php
include('config.php'); 

if (isset($_POST["create"])) {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sender_nic = mysqli_real_escape_string($conn, $_POST["sender_id"]);
    $rec_nic = mysqli_real_escape_string($conn, $_POST["receiver_id"]);
    $rec_name = mysqli_real_escape_string($conn, $_POST["receiver"]);
    $rec_phone = mysqli_real_escape_string($conn, $_POST["tel"]);
    $pickup = mysqli_real_escape_string($conn, $_POST["pickup"]);
    $dropoff = mysqli_real_escape_string($conn, $_POST["drop"]);
    $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $sqlInsert = "INSERT INTO parcel (parcel_id, sender_nic, rec_nic, rec_name, rec_phone, pickup, dropoff, weight, status) 
                 VALUES ('$parcel_id', '$sender_nic', '$rec_nic', '$rec_name', '$rec_phone', '$pickup', '$dropoff', '$weight', '$status')";

    if (mysqli_query($conn, $sqlInsert)) {
        session_start();
        $_SESSION["create"] = "Parcel Added Successfully!";
        header("Location: customer_parcel.php");
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}

if (isset($_POST["edit"])) {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sender_nic = mysqli_real_escape_string($conn, $_POST["sender_id"]);
    $rec_nic = mysqli_real_escape_string($conn, $_POST["receiver_id"]);
    $rec_name = mysqli_real_escape_string($conn, $_POST["receiver"]);
    $rec_phone = mysqli_real_escape_string($conn, $_POST["tel"]);
    $pickup = mysqli_real_escape_string($conn, $_POST["pickup"]);
    $dropoff = mysqli_real_escape_string($conn, $_POST["drop"]);
    $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $sqlUpdate = "UPDATE parcel SET 
                 sender_nic = '$sender_nic', 
                 rec_nic = '$rec_nic', 
                 rec_name = '$rec_name', 
                 rec_phone = '$rec_phone', 
                 pickup = '$pickup', 
                 dropoff = '$dropoff', 
                 weight = '$weight', 
                 status = '$status' 
                 WHERE parcel_id='$parcel_id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        session_start();
        $_SESSION["update"] = "Parcel Updated Successfully!";
        header("Location: customer_parcel.php");
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}
?>