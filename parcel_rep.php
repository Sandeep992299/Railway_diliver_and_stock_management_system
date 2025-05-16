<?php
session_start();
include('config.php');

// Default date range: today
$from = isset($_GET['from']) ? $_GET['from'] : date('Y-m-d');
$to = isset($_GET['to']) ? $_GET['to'] : date('Y-m-d');

// Fetch summarized parcel data for given date range
$sql = "
    SELECT 
        recieved_date,
        COUNT(*) AS total_parcels,
        SUM(weight) AS total_weight,
        SUM(payment) AS total_payment
    FROM parcel
    WHERE recieved_date BETWEEN '$from' AND '$to'
    GROUP BY recieved_date
    ORDER BY recieved_date DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parcel Revenue Report</title>
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="parcel_rep.css?v=1.0">
</head>
<body>
<div class="report-container">
    <header class="report-header">
        <h1>📦 Daily Parcel Revenue Report</h1>
        <a href="reports.php" class="back-link">← Back to Reports</a>
    </header>

    <!-- Date Filter Form -->
    <form method="GET" class="filter-form">
        <label for="from">From:</label>
        <input type="date" name="from" value="<?php echo $from; ?>" required>
        <label for="to">To:</label>
        <input type="date" name="to" value="<?php echo $to; ?>" required>
        <button type="submit">Generate Report</button>
    </form>

    <!-- Report Output -->
    <section class="report-body">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="report-entry">
                    <h2>📅 Date: <?php echo $row['recieved_date']; ?></h2>
                    <p><strong>Total Parcels:</strong> <?php echo $row['total_parcels']; ?></p>
                    <p><strong>Total Weight:</strong> <?php echo number_format($row['total_weight'], 2); ?> kg</p>
                    <p><strong>Total Payment:</strong> Rs. <?php echo number_format($row['total_payment'], 2); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-data">No parcel data available for the selected date range.</p>
        <?php endif; ?>
    </section>
</div>
</body>
</html>
