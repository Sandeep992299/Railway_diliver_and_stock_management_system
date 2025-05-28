<?php 
session_start(); 
include('config.php');

// Handle search input
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sqlSelect = "SELECT * FROM parcel WHERE dropoff LIKE '%$search%'";
} else {
    $sqlSelect = "SELECT * FROM parcel";
}
$result = mysqli_query($conn, $sqlSelect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Parcel List</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="styles3.css?v=1.0">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Customer Parcel List</h1>
            <div>
                <a href="admin.php">Back</a>
            </div>
        </header>

        <?php if (isset($_SESSION["create"])) { ?>
            <div class="alert"><?php echo $_SESSION["create"]; unset($_SESSION["create"]); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION["update"])) { ?>
            <div class="alert"><?php echo $_SESSION["update"]; unset($_SESSION["update"]); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION["delete"])) { ?>
            <div class="alert"><?php echo $_SESSION["delete"]; unset($_SESSION["delete"]); ?></div>
        <?php } ?>

        <!-- Search Bar -->
        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" placeholder="Search by Dropoff Location" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th>Parcel ID</th>
                    <th>Sender NIC</th>
                    <th>Receiver NIC</th>
                    <th>Receiver Name</th>
                    <th>Phone Number</th>
                    <th>Receiver Email</th>
                    <th>Pickup Location</th>
                    <th>Drop Station</th>
                    <th>Weight (kg)</th>
                    <th>Recieved Date</th>
                    <th>Payment (LKR)</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $data['parcel_id']; ?></td>
                    <td><?php echo $data['sender_nic']; ?></td>
                    <td><?php echo $data['rec_nic']; ?></td>
                    <td><?php echo $data['rec_name']; ?></td>
                    <td><?php echo $data['rec_phone']; ?></td>
                    <td><?php echo $data['rec_email']; ?></td>
                    <td><?php echo $data['pickup']; ?></td>
                    <td><?php echo $data['dropoff']; ?></td>
                    <td><?php echo $data['weight']; ?></td>
                    <td><?php echo $data['recieved_date']; ?></td>
                    <td><?php echo $data['payment']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                        <a href="edit.php?parcel_id=<?php echo $data['parcel_id']; ?>" class="button warning">Edit</a>
                        <br><br>
                        <a href="delete.php?id=<?php echo $data['parcel_id']; ?>" class="button danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
                <?php if (mysqli_num_rows($result) === 0) { ?>
                <tr>
                    <td colspan="12">No parcels found for the given dropoff location.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
