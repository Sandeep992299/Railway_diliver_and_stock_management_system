<?php
include 'config.php'; // DB connection

// Fetch the last remaining value
$result = mysqli_query($conn, "SELECT mail_pack_remain FROM mail_pack ORDER BY mail_pack_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$currentRemain = $row ? (int)$row['mail_pack_remain'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (int)$_POST['mail_amount'];
    $action = $_POST['action']; // 'add' or 'remove'
    $mail_date = $_POST['mail_date']; // Get the date from the form

    if ($amount > 0 && !empty($mail_date)) {
        if ($action === 'add') {
            $newRemain = $currentRemain + $amount;
            $status = 'added';
            $payment = $amount * 20;
        } elseif ($action === 'remove') {
            $newRemain = max(0, $currentRemain - $amount);
            $status = 'removed';
            $payment = 0;
        } else {
            die('Invalid action.');
        }

        $stmt = $conn->prepare("INSERT INTO mail_pack (mail_pack_amount, mail_pack_status, mail_pack_remain, mail_pay, mail_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiis", $amount, $status, $newRemain, $payment, $mail_date);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: govStock.php');
exit();
?>
