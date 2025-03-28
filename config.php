<?php
$conn = mysqli_connect('localhost', 'root', '', 'railway_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully!";
}
?>