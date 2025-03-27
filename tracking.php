<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Stock Management</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="tracking.css">
   
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
            <h1>Package Tracking</h1>
        </header>

        <div class="tracking-box">
            <h2>Track Your Parcel</h2>
            <input type="text" id="parcelId" placeholder="Enter Parcel ID" />
            <button id="searchButton" class="btn">Search</button>
            <div id="statusLabel" class="status-label"></div>
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
            <h3>Copyright &COPY;2025 All Rights Reserved. Sri Lanka Railway Department</h3>
        </section>
    </footer>

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
    const parcelId = document.getElementById('parcelId').value;
    const statusLabel = document.getElementById('statusLabel');

    // Simulated parcel status check based on parcel ID
    if (parcelId) {
        let statusMessage;
        statusLabel.className = 'status-label'; // Reset classes

        switch (parcelId) {
            case '123':
                statusMessage = 'Status for Parcel ID 123: In Transit';
                statusLabel.classList.add('in-transit');
                break;
            case '456':
                statusMessage = 'Status for Parcel ID 456: Delivered';
                statusLabel.classList.add('delivered');
                break;
            case '789':
                statusMessage = 'Status for Parcel ID 789: At Station';
                statusLabel.classList.add('at-station');
                break;
            default:
                statusMessage = 'Status for Parcel ID ' + parcelId + ': Not Found';
                statusLabel.classList.add('not-found');
        }
        statusLabel.textContent = statusMessage;
    } else {
        statusLabel.textContent = 'Please enter a valid Parcel ID.';
        statusLabel.className = 'status-label not-found'; // Add not-found class
    }
});
    </script>
    
</body>
</html>
