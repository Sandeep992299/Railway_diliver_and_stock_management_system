<?php
session_start();
include('config.php'); 

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sender_nic = mysqli_real_escape_string($conn, $_POST["sender_id"]);
    $rec_nic = mysqli_real_escape_string($conn, $_POST["receiver_id"]);
    $rec_name = mysqli_real_escape_string($conn, $_POST["receiver"]);
    $rec_phone = mysqli_real_escape_string($conn, $_POST["tel"]);
    $rec_email = mysqli_real_escape_string($conn, $_POST["email"]); 
    $recieved_date = mysqli_real_escape_string($conn, $_POST["date"]);
    $pickup = mysqli_real_escape_string($conn, $_POST["pickup"]);
    $dropoff = mysqli_real_escape_string($conn, $_POST["drop"]);
    $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    $payment = mysqli_real_escape_string($conn, $_POST["pay"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    // Handle create
    if (isset($_POST["create"])) {
        $insert = "INSERT INTO parcel 
            (parcel_id, sender_nic, rec_nic, rec_name, rec_phone, rec_email, recieved_date, pickup, dropoff, weight, payment, status) 
            VALUES 
            ('$parcel_id', '$sender_nic', '$rec_nic', '$rec_name', '$rec_phone', '$rec_email', '$recieved_date', '$pickup', '$dropoff', '$weight', '$payment', '$status')";

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
            rec_email='$email', 
            recieved_date='$recieved_date',
            pickup='$pickup', 
            dropoff='$dropoff', 
            weight='$weight', 
            payment='$payment', 
            status='$status'
            WHERE parcel_id='$parcel_id'";

        if (mysqli_query($conn, $update)) {
            $_SESSION["update"] = "Parcel Updated Successfully!";

            // Send email if parcel has arrived
            if (strtolower($status) === "arrived at destination") {
                $mail = new PHPMailer(true);
                try {
                    // SMTP Settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kandyrailwaystationofficial@gmail.com'; 
                    $mail->Password = 'nybp sxeg godn qjip'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Email content
                    $mail->setFrom('kandyrailwaystationofficial@gmail.com', 'Railway Parcel Service');
                    $mail->addAddress($email, $rec_name);
                    $mail->isHTML(true);
                    $mail->Subject = "Your Parcel Has Arrived!";
                    $mail->Body = "
                        <h2>Hello $rec_name,</h2>
                        <p>Your parcel has <strong>arrived at the destination</strong> ($dropoff).</p>
                        <p>Please collect it as soon as possible.</p>
                        <br><p>Thank you,<br>Railway Parcel Service</p>";

                    $mail->send();
                    $_SESSION["update"] .= " Email sent to receiver.";
                } catch (Exception $e) {
                    $_SESSION["update"] .= " Email not sent. Error: " . $mail->ErrorInfo;
                }
            }
        } else {
            $_SESSION["error"] = "Error updating parcel: " . mysqli_error($conn);
        }
    }

    header("Location: customer_parcel.php");
    exit();
}
?>
