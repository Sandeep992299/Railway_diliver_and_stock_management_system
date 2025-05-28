<?php
session_start();
include('config.php');

// Fetch all fuel stock records ordered by latest first
$fuel_query = "SELECT * FROM fuel ORDER BY fuel_id DESC";
$fuel_result = mysqli_query($conn, $fuel_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fuel Stock Management</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="styles3.css?v=1.0">
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Fuel Stock Management</h1>
        <div><a href="admin.php">Back</a></div>
    </header>

    <!-- Fuel Stock Table -->
    <h2>Fuel Stock Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Volume (Liters)</th>
                <th>Status</th>
                <th>Remaining</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($fuel_result) > 0): ?>
                <?php while ($fuel = mysqli_fetch_assoc($fuel_result)) { ?>
                <tr>
                    <td><?php echo $fuel['fuel_id']; ?></td>
                    <td><?php echo $fuel['fuel_vol']; ?></td>
                    <td><?php echo ucfirst($fuel['fuel_status']); ?></td>
                    <td><?php echo $fuel['fuel_remain']; ?></td>
                    <td>
                        <?php
                            // Show date if you have a date column, else show "-"
                            echo isset($fuel['fuel_date']) ? $fuel['fuel_date'] : '-';
                        ?>
                    </td>
                    <td>
                        <a href="edit_fuel.php?id=<?php echo $fuel['fuel_id']; ?>" class="button warning">Edit</a><br><br>
                        <a href="delete_fuel.php?id=<?php echo $fuel['fuel_id']; ?>" class="button danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr><td colspan="6">No fuel records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
