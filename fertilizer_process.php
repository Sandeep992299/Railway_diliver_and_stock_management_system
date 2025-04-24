<?php
include 'config.php'; // DB connection

// Fetch the last remaining value
$result = mysqli_query($conn, "SELECT fert_remain FROM fertilizer ORDER BY fert_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$currentRemain = $row ? (int)$row['fert_remain'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packs = (int)$_POST['fert_packs'];
    $action = $_POST['action']; // 'add' or 'remove'

    if ($packs > 0) {
        if ($action === 'add') {
            $newRemain = $currentRemain + $packs;
            $status = 'added';
        } elseif ($action === 'remove') {
            $newRemain = max(0, $currentRemain - $packs);
            $status = 'removed';
        } else {
            die('Invalid action.');
        }

        $stmt = $conn->prepare("INSERT INTO fertilizer (fert_packs, fert_status, fert_remain) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $packs, $status, $newRemain);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: govStock.php');
exit();
?>
