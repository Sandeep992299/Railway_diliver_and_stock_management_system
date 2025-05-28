<?php
session_start();
include('config.php');

// Default date range
$from = isset($_GET['from']) ? $_GET['from'] : date('Y-m-d');
$to = isset($_GET['to']) ? $_GET['to'] : date('Y-m-d');

// Mail/Package data
$mail_sql = "
    SELECT 
        mail_date AS report_date,
        SUM(CASE WHEN mail_pack_status = 'added' THEN mail_pack_amount ELSE 0 END) AS added,
        SUM(CASE WHEN mail_pack_status = 'removed' THEN mail_pack_amount ELSE 0 END) AS removed,
        SUM(mail_pay) AS payment
    FROM mail_pack
    WHERE mail_date BETWEEN '$from' AND '$to'
    GROUP BY mail_date
    ORDER BY mail_date ASC
";
$mail_result = mysqli_query($conn, $mail_sql);

// Fertilizer data
$fert_sql = "
    SELECT 
        fert_date AS report_date,
        SUM(CASE WHEN fert_status = 'added' THEN fert_packs ELSE 0 END) AS added,
        SUM(CASE WHEN fert_status = 'removed' THEN fert_packs ELSE 0 END) AS removed,
        SUM(fert_pay) AS payment
    FROM fertilizer
    WHERE fert_date BETWEEN '$from' AND '$to'
    GROUP BY fert_date
    ORDER BY fert_date ASC
";
$fert_result = mysqli_query($conn, $fert_sql);

// Prepare mail data for chart
$mail_dates = $mail_added = $mail_removed = $mail_payments = [];
while ($row = mysqli_fetch_assoc($mail_result)) {
    $mail_dates[] = $row['report_date'];
    $mail_added[] = $row['added'];
    $mail_removed[] = $row['removed'];
    $mail_payments[] = "Rs. " . number_format($row['payment'], 2);
}

// Prepare fertilizer data for chart
$fert_dates = $fert_added = $fert_removed = $fert_payments = [];
while ($row = mysqli_fetch_assoc($fert_result)) {
    $fert_dates[] = $row['report_date'];
    $fert_added[] = $row['added'];
    $fert_removed[] = $row['removed'];
    $fert_payments[] = "Rs. " . number_format($row['payment'], 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Government Stock Report</title>
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="parcel_rep.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="report-container">
    <header class="report-header">
        <h1>📊 Government Stock Summary Report</h1>
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

    <!-- Mail Package Chart -->
    <section class="report-body">
        <h2>📬 Mail / Package Stock</h2>
        <?php if (!empty($mail_dates)): ?>
            <canvas id="mailChart" width="800" height="400"></canvas>
            <script>
                const mailCtx = document.getElementById('mailChart').getContext('2d');
                new Chart(mailCtx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($mail_dates); ?>,
                        datasets: [
                            {
                                label: 'Added',
                                data: <?php echo json_encode($mail_added); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Removed',
                                data: <?php echo json_encode($mail_removed); ?>,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Mail / Package Stock Summary'
                            },
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 300,
                                title: {
                                    display: true,
                                    text: 'Amount'
                                }
                            },
                            x: {
                                ticks: {
                                    callback: function(value, index) {
                                        return this.getLabelForValue(index);
                                    },
                                    font: { size: 12 },
                                },
                                title: {
                                    display: true,

                                }
                            }
                        }
                    },
                    plugins: [{
                        id: 'mailLabelPlugin',
                        afterDraw: chart => {
                            const ctx = chart.ctx;
                            chart.data.labels.forEach((label, index) => {
                                const x = chart.scales.x.getPixelForValue(index);
                                const y = chart.chartArea.bottom + 30;
                                ctx.fillStyle = '#444';
                                ctx.font = '12px sans-serif';
                                ctx.textAlign = 'center';
                                ctx.fillText(<?php echo json_encode($mail_payments); ?>[index], x, y);
                            });
                        }
                    }]
                });
            </script>
        <?php else: ?>
            <p class="no-data">No mail/package data for selected dates.</p>
        <?php endif; ?>
    </section>

    <!-- Fertilizer Chart -->
    <section class="report-body">
        <h2>🌾 Fertilizer Stock</h2>
        <?php if (!empty($fert_dates)): ?>
            <canvas id="fertChart" width="800" height="400"></canvas>
            <script>
                const fertCtx = document.getElementById('fertChart').getContext('2d');
                new Chart(fertCtx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($fert_dates); ?>,
                        datasets: [
                            {
                                label: 'Added',
                                data: <?php echo json_encode($fert_added); ?>,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Removed',
                                data: <?php echo json_encode($fert_removed); ?>,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Fertilizer Stock Summary'
                            },
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 1000,
                                title: {
                                    display: true,
                                    text: 'Amount'
                                }
                            },
                            x: {
                                ticks: {
                                    callback: function(value, index) {
                                        return this.getLabelForValue(index);
                                    },
                                    font: { size: 12 },
                                },
                                title: {
                                    display: true,

                                }
                            }
                        }
                    },
                    plugins: [{
                        id: 'fertLabelPlugin',
                        afterDraw: chart => {
                            const ctx = chart.ctx;
                            chart.data.labels.forEach((label, index) => {
                                const x = chart.scales.x.getPixelForValue(index);
                                const y = chart.chartArea.bottom + 30;
                                ctx.fillStyle = '#444';
                                ctx.font = '12px sans-serif';
                                ctx.textAlign = 'center';
                                ctx.fillText(<?php echo json_encode($fert_payments); ?>[index], x, y);
                            });
                        }
                    }]
                });
            </script>
        <?php else: ?>
            <p class="no-data">No fertilizer data for selected dates.</p>
        <?php endif; ?>
    </section>
</div>
</body>
</html>
