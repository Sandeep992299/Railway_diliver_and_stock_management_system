<?php 
include 'auth_check.php'; 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate each input field
    if (empty($_POST['id'])) $errors[] = "Parcel ID is required.";
    if (empty($_POST['sender_id'])) $errors[] = "Sender NIC is required.";
    if (empty($_POST['receiver_id'])) $errors[] = "Receiver NIC is required.";
    if (empty($_POST['receiver'])) $errors[] = "Receiver Name is required.";
    if (empty($_POST['tel'])) $errors[] = "Phone Number is required.";
    if (empty($_POST['pickup'])) $errors[] = "Pickup Location is required.";
    if (empty($_POST['drop'])) $errors[] = "Drop Station is required.";
    if (empty($_POST['weight'])) $errors[] = "Weight is required.";
    if (empty($_POST['status'])) $errors[] = "Status selection is required.";

    if (empty($errors)) {
        // Process form data (e.g., save to database)
        echo "<script>alert('Parcel added successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Parcel Management</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="customer_parcel.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
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

    <div class="main-content">
        <header>
            <h1>Customer Parcel Management</h1>
        </header>

        <div class="container">
            <?php
            // Display errors if there are any
            if (!empty($errors)) {
                echo '<div class="error-messages">';
                foreach ($errors as $error) {
                    echo '<p class="error">'.$error.'</p>';
                }
                echo '</div>';
            }
            ?>

            <form id="packageForm" method="POST" onsubmit="return validateForm()">
                <h1>Generate QR Code for Package</h1>
                
                <label for="parcel_id">Parcel ID:</label>
                <input type="text" id="id" name="id" required>

                <label for="sender_nic">Sender NIC:</label>
                <input type="text" id="sender_id" name="sender_id" required>

                <label for="receiver_nic">Receiver NIC:</label>
                <input type="text" id="receiver_id" name="receiver_id" required>

                <label for="receiver">Receiver Name:</label>
                <input type="text" id="receiver" name="receiver" required>

                <label for="tel">Phone Number:</label>
                <input type="tel" id="tel" name="tel" required>

                <label for="pickup">Pickup Location:</label>
                <input type="text" id="pickup" name="pickup" required>

                <label for="drop">Drop Station:</label>
                <input type="text" id="drop" name="drop" required>

                <label for="weight">Weight (kg):</label>
                <input type="text" id="weight" name="weight" step="0.01" min="0.1" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="ready_for_dispatch">Ready for Dispatch</option>
                    <option value="dispatched">Dispatched</option>
                    <option value="arrived_at_destination">Arrived at Destination</option>
                </select>
                <div class="form-element">
                    <input type="submit" class="btn" name="create" value="Add item">
                </div>

                <button type="button" onclick="generateQRCode()">Generate QR Code</button>
            </form>

            <div id="qrResult" style="display: none;">
                <h2>QR Code:</h2>
                <div id="qrcode"></div>
            </div>
        </div>
    </div>

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
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
                        <a href="https://twitter.com/?lang=en"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                        <a href="https://lk.linkedin.com/"><i class="fab fa-linkedin"></i></a>
                    </section>
                </section>
            </section>
        </section>
        <section class="copyright">
            <h3>Copyright &COPY;2023 All Rights Reserved. Nature Guide Ceylon</h3>
        </section>
    </footer>

    <script src="qrcode.min.js"></script>
    <script src="script.js"></script>

    <script>
        function validateForm() {
            let requiredFields = ["id", "sender_id", "receiver_id", "receiver", "tel", "pickup", "drop", "weight", "status"];
            for (let field of requiredFields) {
                if (document.getElementById(field).value.trim() === "") {
                    alert("Please fill all fields before submitting.");
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
