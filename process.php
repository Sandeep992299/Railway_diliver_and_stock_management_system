<?php
session_start();
include('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sender_nic = mysqli_real_escape_string($conn, $_POST["sender_id"]);
    $rec_nic = mysqli_real_escape_string($conn, $_POST["receiver_id"]);
    $rec_name = mysqli_real_escape_string($conn, $_POST["receiver"]);
    $rec_phone = mysqli_real_escape_string($conn, $_POST["tel"]);
    $pickup = mysqli_real_escape_string($conn, $_POST["pickup"]);
    $dropoff = mysqli_real_escape_string($conn, $_POST["drop"]);
    $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    if (isset($_POST["create"])) {
        $insert = "INSERT INTO parcel (parcel_id, sender_nic, rec_nic, rec_name, rec_phone, pickup, dropoff, weight, status) 
                   VALUES ('$parcel_id', '$sender_nic', '$rec_nic', '$rec_name', '$rec_phone', '$pickup', '$dropoff', '$weight', '$status')";

        if (mysqli_query($conn, $insert)) {
            $_SESSION["create"] = "Parcel Added Successfully!";
        } else {
            $_SESSION["error"] = "Error adding parcel: " . mysqli_error($conn);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["parcel_id"])) {
        $parcel_id = $_POST["parcel_id"];
        $sender_nic = $_POST["sender_nic"];
        $receiver_nic = $_POST["receiver_nic"];
        $receiver_name = $_POST["receiver_name"];
        $receiver_phone = $_POST["receiver_phone"];
        $pickup = $_POST["pickup"];
        $dropoff = $_POST["dropoff"];
        $weight = $_POST["weight"];
        $status = $_POST["status"]; 
    
        // Update query
        $sql = "UPDATE parcel SET 
                sender_nic='$sender_nic', 
                receiver_nic='$receiver_nic', 
                receiver_name='$receiver_name', 
                receiver_phone='$receiver_phone', 
                pickup='$pickup', 
                dropoff='$dropoff', 
                weight='$weight', 
                status='$status'
                WHERE parcel_id='$parcel_id'";
    
        if (mysqli_query($conn2, $sql)) {
            echo "<script>
                    alert('Parcel Updated Successfully!');
                    window.location.href = 'customer_parcel.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating parcel.');
                    window.history.back();
                  </script>";
        }
    }

    header("Location: customer_parcel.php");
    exit();
}
?>
