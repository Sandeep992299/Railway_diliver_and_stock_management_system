<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Parcel List</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Customer Parcel List</h1>
            <div>
                <a href="main.php">Back</a>
            </div>
        </header>
        
        <?php session_start(); ?>
        <?php if (isset($_SESSION["create"])) { ?>
            <div class="alert"> <?php echo $_SESSION["create"]; ?> </div>
            <?php unset($_SESSION["create"]); } ?>
        <?php if (isset($_SESSION["update"])) { ?>
            <div class="alert"> <?php echo $_SESSION["update"]; ?> </div>
            <?php unset($_SESSION["update"]); } ?>
        <?php if (isset($_SESSION["delete"])) { ?>
            <div class="alert"> <?php echo $_SESSION["delete"]; ?> </div>
            <?php unset($_SESSION["delete"]); } ?>
        
        <table>
        <thead>
            <tr>
                <th>Parcel ID</th>
                <th>Sender NIC</th>
                <th>Receiver NIC</th>
                <th>Receiver Name</th>
                <th>Phone Number</th>
                <th>Pickup Location</th>
                <th>Drop Station</th>
                <th>Weight (kg)</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>

            
            <!-- Fetch data dynamically from database -->
            <?php
            include('config.php');
            $sqlSelect = "SELECT * FROM parcel";
            $result = mysqli_query($conn, $sqlSelect);
            while ($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $data['parcel_id']; ?></td>
                <td><?php echo $data['sender_nic']; ?></td>
                <td><?php echo $data['rec_nic']; ?></td>
                <td><?php echo $data['rec_name']; ?></td>
                <td><?php echo $data['rec_phone']; ?></td>
                <td><?php echo $data['pickup']; ?></td>
                <td><?php echo $data['dropoff']; ?></td>
                <td><?php echo $data['weight']; ?></td>
                <td><?php echo $data['status']; ?></td>
                <td>
                    <a href="edit.php?parcel_id=<?php echo $data['parcel_id']; ?>" class="button warning">Edit</a>
                    <br>
                    <br>
                    <a href="delete.php?id=<?php echo $data['parcel_id']; ?>" class="button danger">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>

    </div>
</body>
</html>