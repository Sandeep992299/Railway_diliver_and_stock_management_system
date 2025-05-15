<?php 
session_start(); 
include('config.php');

// Fetch Mail/Package stock
$mail_query = "SELECT * FROM mail_pack";
$mail_result = mysqli_query($conn, $mail_query);

// Fetch Fertilizer stock
$fert_query = "SELECT * FROM fertilizer";
$fert_result = mysqli_query($conn, $fert_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Government Stock Management</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="styles3.css?v=1.0">
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Government Stock Management</h1>
        <div><a href="admin.php">Back</a></div>
    </header>

    <!-- Mail/Package Stock Table -->
    <h2>Mail / Package Stock</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Remaining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($mail = mysqli_fetch_assoc($mail_result)) { ?>
                <tr>
                    <td><?php echo $mail['mail_pack_id']; ?></td>
                    <td><?php echo $mail['mail_pack_amount']; ?></td>
                    <td><?php echo $mail['mail_pack_status']; ?></td>
                    <td><?php echo $mail['mail_pack_remain']; ?></td>
                    <td>
                        <a href="edit_mail.php?id=<?php echo $mail['mail_pack_id']; ?>" class="button warning">Edit</a><br><br>
                        <a href="delete_mail.php?id=<?php echo $mail['mail_pack_id']; ?>" class="button danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if (mysqli_num_rows($mail_result) === 0) { ?>
                <tr><td colspan="5">No mail/package records found.</td></tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br>

    <!-- Fertilizer Stock Table -->
    <h2>Fertilizer Stock</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Packs</th>
                <th>Status</th>
                <th>Remaining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fert = mysqli_fetch_assoc($fert_result)) { ?>
                <tr>
                    <td><?php echo $fert['fert_id']; ?></td>
                    <td><?php echo $fert['fert_packs']; ?></td>
                    <td><?php echo $fert['fert_status']; ?></td>
                    <td><?php echo $fert['fert_remain']; ?></td>
                    <td>
                        <a href="edit_fert.php?id=<?php echo $fert['fert_id']; ?>" class="button warning">Edit</a><br><br>
                        <a href="delete_fert.php?id=<?php echo $fert['fert_id']; ?>" class="button danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if (mysqli_num_rows($fert_result) === 0) { ?>
                <tr><td colspan="5">No fertilizer records found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
