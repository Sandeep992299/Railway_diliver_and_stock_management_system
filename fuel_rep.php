<?php
session_start();
include('config.php');

// Fuel stock summary without date filter
$fuel_sql = "
    SELECT 
        SUM(CASE WHEN fuel_status = 'added' THEN fuel_vol ELSE 0 END) AS added,
        SUM(CASE WHEN fuel_status = 'removed' THEN fuel_vol ELSE 0 END) AS removed
    FROM fuel
";
$fuel_result = mysqli_query($conn, $fuel_sql);
$fuel_totals = mysqli_fetch_assoc($fuel_result);

// Get the most recent remaining fuel amount
$remain_sql = "SELECT fuel_remain FROM fuel ORDER BY fuel_id DESC LIMIT 1";
$remain_result = mysqli_query($conn, $remain_sql);
$remain_row = mysqli_fetch_assoc($remain_result);
$remaining = $remain_row ? $remain_row['fuel_remain'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fuel Stock Report</title>
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="parcel_rep.css?v=1.0">
</head>
<body>
<div class="report-container">
    <header class="report-header">
        <h1>⛽ Fuel Stock Summary Report</h1>
        <a href="reports.php" class="back-link">← Back to Reports</a>
    </header>

    <section class="report-body">
        <div class="report-entry">
            <p><strong>Total Fuel Added:</strong> <?php echo $fuel_totals['added'] ?? 0; ?> liters</p>
            <p><strong>Total Fuel Removed:</strong> <?php echo $fuel_totals['removed'] ?? 0; ?> liters</p>
            <p><strong>Current Remaining Fuel:</strong> <?php echo $remaining; ?> liters</p>
        </div>
    </section>
</div>
</body>
</html>
