<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Management</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="fuel.css">
   
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
                <li><a href="customer_Parcel.php">Customer Parcel Management</a></li>
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
            <h1>Fuel Tank Status</h1>
        </header>

        <!-- Fuel Tank Section -->
        <div class="container">
            <div class="tank">
                <div class="fuel-level" id="fuelLevel"></div>
                <div class="tank-border"></div>
            </div>
            <div class="controls">
                <input type="number" id="fuelInput" placeholder="Enter Liters" min="0">
                <button onclick="changeFuel('add')">Add Fuel</button>
                <button onclick="changeFuel('remove')">Remove Fuel</button>
            </div>
            <p>Current Fuel: <span id="fuelLiters">0 L</span> | <span id="fuelPercentage">0%</span></p><br><br>
        </div>

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

    <script src="main.js" defer></script>
    <script src="fuel.js" defer></script>
</body>
</html>
