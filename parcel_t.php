<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Parcel List</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Customer Parcel List</h1>
            <div>
                <a href="admin_page.php">Back</a>
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
            <!-- Hardcoded rows -->
            <tr>
                <td>1001</td><td>987654321V</td><td>123456789V</td><td>John Doe</td><td>+94712345678</td>
                <td>Colombo</td><td>Kandy</td><td>5.5</td><td>Dispatched</td>
                <td>
                    <a href="#" class="button info">Read More</a>
                    <a href="#" class="button warning">Edit</a>
                    <a href="#" class="button danger">Delete</a>
                </td>
            </tr>
            <tr>
                <td>1002</td><td>876543219V</td><td>234567891V</td><td>Jane Smith</td><td>+94787654321</td>
                <td>Galle</td><td>Jaffna</td><td>10</td><td>Arrived at Destination</td>
                <td>
                    <a href="#" class="button info">Read More</a>
                    <a href="#" class="button warning">Edit</a>
                    <a href="#" class="button danger">Delete</a>
                </td>
            </tr>

            
            <!-- Fetch data dynamically from database -->
            <?php
            include('connect.php');
            $sqlSelect = "SELECT * FROM parcel";
            $result = mysqli_query($conn2, $sqlSelect);
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
                    <a href="view.php?id=<?php echo $data['parcel_id']; ?>" class="button info">Read More</a>
                    <a href="edit.php?id=<?php echo $data['parcel_id']; ?>" class="button warning">Edit</a>
                    <a href="delete.php?id=<?php echo $data['parcel_id']; ?>" class="button danger">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
        <br>
        <div>
            <a href="create.php" class="button primary">Add New Parcel</a>
        </div> 
    </div>
</body>
</html>