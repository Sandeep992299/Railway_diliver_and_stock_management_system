<?php
session_start();
include("config.php");

// Autoload PHPMailer classes via Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['edit'])) {
    // Get form data
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $sender_nic = mysqli_real_escape_string($conn, $_POST['sender_nic']);
    $receiver_nic = mysqli_real_escape_string($conn, $_POST['receiver_nic']);
    $receiver_name = mysqli_real_escape_string($conn, $_POST['receiver_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
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
                  rec_email='$email', 
                  rec_phone='$phone', 
                  pickup='$pickup', 
                  dropoff='$dropoff', 
                  weight='$weight', 
                  status='$status' 
                  WHERE parcel_id='$parcel_id'";

    // Execute the query
    if (mysqli_query($conn, $sqlUpdate)) {
        $_SESSION['update'] = "Parcel updated successfully!";

        // Send email if status is 'Arrived at Destination'
        if (strtolower($status) === 'arrived at destination') {
            $mail = new PHPMailer(true);

            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kandyrailwaystationofficial@gmail.com'; 
                $mail->Password = 'nybp sxeg godn qjip';     
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email content
                $mail->setFrom('kandyrailwaystationofficial@gmail.com', 'Railway Parcel Service');
                $mail->addAddress($email, $receiver_name);
                $mail->isHTML(true);
                $mail->Subject = "Your Parcel Has Arrived!";
                $mail->Body = "
                    <h2>Hello $receiver_name,</h2>
                    <p>Your parcel has <strong>arrived at the destination</strong> ($dropoff).</p>
                    <p>Please collect it as soon as possible.</p>
                    <br><p>Thank you,<br>Railway Parcel Service</p>";

                $mail->send();
                $_SESSION['update'] .= " Email notification sent.";
            } catch (Exception $e) {
                $_SESSION['update'] .= " Email could not be sent. Error: " . $mail->ErrorInfo;
            }
        }

        header("Location: parcel_t.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
