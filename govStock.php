<?php include 'auth_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Stock Management</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="govStock.css">
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
    <div class="stock-container" id="mailStorage">
        <div class="stock-bar" id="mailBar"></div>
    </div>
    <p>Current Storage: <span id="mailStorageValue">0</span>/1000 (0%)</p><br>
    
    <!-- Input for Stock Quantity -->
    <input type="number" id="mailInput" placeholder="Amount" min="1" />
    
    <!-- Buttons for Add and Remove -->
    <button onclick="updateMailStorage(1)">Add</button>
    <button onclick="updateMailStorage(-1)">Remove</button>
</section><br><br>

<!-- Fertilizer Stock Management -->
<section class="stock-management">
    <h2><b>Fertilizer Stock Management</b></h2><br>
    <div class="stock-container" id="fertilizerStorage">
        <div class="stock-bar" id="fertilizerBar"></div>
    </div>
    <p>Current Storage: <span id="fertilizerStorageValue">0 kg</span>/100000 kg (0%)</p><br>
    
    <!-- Input for Stock Quantity -->
    <input type="number" id="fertilizerInput" placeholder="Amount (Packs)" min="1" />
    
    <!-- Buttons for Add and Remove -->
    <button onclick="updateFertilizerStorage(1)">Add Pack</button>
    <button onclick="updateFertilizerStorage(-1)">Remove Pack</button>
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

    <script src="main.js" defer></script>
    <script src="govStock.js" defer></script>
</body>
</html>
