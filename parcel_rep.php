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

// Prepare data for Chart.js
$dates = [];
$parcelCounts = [];
$weights = [];
$payments = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['recieved_date'];
    $parcelCounts[] = $row['total_parcels'];
    $weights[] = $row['total_weight'];
    $payments[] = $row['total_payment'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parcel Revenue Report</title>
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="parcel_rep.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <!-- Report Output as Chart -->
    <section class="report-body">
        <?php if (!empty($dates)): ?>
            <canvas id="parcelChart" width="800" height="400"></canvas>
            <script>
                const ctx = document.getElementById('parcelChart').getContext('2d');

                const parcelChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($dates); ?>,
                        datasets: [
                            {
                                label: 'Total Parcels',
                                data: <?php echo json_encode($parcelCounts); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total Weight (kg)',
                                data: <?php echo json_encode($weights); ?>,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Parcel Count and Weight per Day'
                            },
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    afterBody: function(context) {
                                        const index = context[0].dataIndex;
                                        const payments = <?php echo json_encode($payments); ?>;
                                        return 'Payment: Rs. ' + parseFloat(payments[index]).toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Value'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                      
                                }
                            }
                        }
                    },
                    
                    plugins: [{
                        id: 'paymentLabel',
                        afterDatasetsDraw(chart, args, pluginOptions) {
                            const { ctx, chartArea: {bottom}, scales: {x}, data } = chart;
                            const payments = <?php echo json_encode($payments); ?>;
                            ctx.save();
                            ctx.fillStyle = '#000';
                            ctx.font = '12px sans-serif';
                            ctx.textAlign = 'center';

                            data.labels.forEach((label, index) => {
                                const xPos = x.getPixelForValue(index);
                                ctx.fillText('Rs. ' + parseFloat(payments[index]).toFixed(2), xPos, bottom + 35);
                            });

                            ctx.restore();
                        }
                    }]

                });
            </script>
        <?php else: ?>
            <p class="no-data">No parcel data available for the selected date range.</p>
        <?php endif; ?>
    </section>
</div>
</body>
</html>
