<?php include 'auth_check.php'; 
include 'config.php';

// Fetch latest mail stock
$mailQuery = mysqli_query($conn, "SELECT mail_pack_remain FROM mail_pack ORDER BY mail_pack_id DESC LIMIT 1");
$mailData = mysqli_fetch_assoc($mailQuery);
$mailRemain = $mailData ? $mailData['mail_pack_remain'] : 0;

// Fetch latest fertilizer stock
$fertQuery = mysqli_query($conn, "SELECT fert_remain FROM fertilizer ORDER BY fert_id DESC LIMIT 1");
$fertData = mysqli_fetch_assoc($fertQuery);
$fertRemainPacks = $fertData ? $fertData['fert_remain'] : 0;
$fertRemainKg = $fertRemainPacks * 50;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Stock Management</title>
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/1.png" type="image/png">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="govStock.css?v=1.0">

</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="logo">
            <img src="images/1.png" alt="Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="customer_parcel.php">Customer Parcel Management</a></li>
                <li><a href="govStock.php">Government Stock Management</a></li>
                <li><a href="tracking.php">Parcel Tracking</a></li>
                <li><a href="fuel.php">Fuel Stock</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
            <div class="auth-buttons">
                <button onclick="location.href='login.php'">Log out</button>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Government Stock Management</h1>
        </header>

        <!-- Mail Stock Management -->
        <section class="stock-management">
            <h2><b>Mail and Packages Stock Management</b></h2><br>
            <form action="mail_process.php" method="POST">
                <input type="number" name="mail_amount" placeholder="Amount" min="1" required />
                <input type="date" name="mail_date" required />
                <input type="hidden" name="action" id="mailAction" />
                <button type="submit" onclick="document.getElementById('mailAction').value='add'">Add</button>
                <button type="submit" onclick="document.getElementById('mailAction').value='remove'">Remove</button>
            </form>
            <div class="stock-container">
                <div class="stock-bar" id="mailBar" style="width: <?= ($mailRemain / 1000 * 100) ?>%;"></div>
            </div>
            <p>Current Storage: <span id="mailStorageValue"><?= $mailRemain ?></span>/1000 (<?= number_format(($mailRemain / 1000 * 100), 2) ?>%)</p>
        </section><br><br>

        <!-- Fertilizer Stock Management -->
        <section class="stock-management">
            <h2><b>Fertilizer Stock Management</b></h2><br>
            <form action="fertilizer_process.php" method="POST">
                <input type="number" name="fert_packs" placeholder="Amount (Packs)" min="1" required />
                <input type="date" name="fert_date" required />
                <input type="hidden" name="action" id="fertAction" />
                <button type="submit" onclick="document.getElementById('fertAction').value='add'">Add Pack</button>
                <button type="submit" onclick="document.getElementById('fertAction').value='remove'">Remove Pack</button>
            </form>
            <div class="stock-container">
                <div class="stock-bar" id="fertilizerBar" style="width: <?= ($fertRemainKg / 100000 * 100) ?>%;"></div>
            </div>
            <p>Current Storage: 
                <span id="fertilizerStorageValue"><?= $fertRemainKg ?> kg</span>/100000 kg 
                (<?= number_format(($fertRemainKg / 100000 * 100), 2) ?>%) - 
                <?= $fertRemainPacks ?> packs
            </p>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <section class="container">
            <section class="row">
                <section class="footer-col">
                    <h3>Contact Us</h3>
                    <ul>
                        <h4>Email - dissanayakesandeep@gmail.com</h4>
                        <h4>Phone - +94714568342</h4>
                        <h4>Address - No.142, Rajawella 2<br>Digana</h4>
                    </ul>
                </section>
                <section class="footer-col">
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="home.html">Home</a></li>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="contact_us.html">Contact Us</a></li>
                        <li><a href="about_us.html">About Us</a></li>
                    </ul>
                </section>
                <section class="footer-col">
                    <h3>Follow Us</h3>
                    <section class="social-links">
                        <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/?lang=en"><i class="fa fa-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
                        <a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a>
                        <a href="https://lk.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                    </section>
                </section>
            </section>
        </section>
        <section class="copyright">
            <h3>Copyright &COPY;2023 All Rights Reserved. Nature Guide Ceylon</h3>
        </section>
    </footer>
</body>
</html>
