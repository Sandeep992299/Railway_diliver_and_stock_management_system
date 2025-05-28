<?php
include 'config.php'; // DB connection

// Fetch the last remaining value
$result = mysqli_query($conn, "SELECT fert_remain FROM fertilizer ORDER BY fert_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$currentRemain = $row ? (int)$row['fert_remain'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packs = (int)$_POST['fert_packs'];
    $action = $_POST['action']; // 'add' or 'remove'
    $fert_date = $_POST['fert_date']; // Get the selected date from form

    if ($packs > 0 && !empty($fert_date)) {
        if ($action === 'add') {
            $newRemain = $currentRemain + $packs;
            $status = 'added';
            $payment = $packs * 30;
        } elseif ($action === 'remove') {
            $newRemain = max(0, $currentRemain - $packs);
            $status = 'removed';
            $payment = 0;
        } else {
            die('Invalid action.');
        }

        $stmt = $conn->prepare("INSERT INTO fertilizer (fert_packs, fert_status, fert_remain, fert_pay, fert_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiis", $packs, $status, $newRemain, $payment, $fert_date);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: govStock.php');
exit();
?>
