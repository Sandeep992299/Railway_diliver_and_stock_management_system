<?php 
include("config.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parcel</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Parcel</h1>
            <div>
                <a href="customer_parcel.php">Back</a>
            </div>
        </header>

        <form action="update_parcel.php" method="post">
            <?php 
            if (isset($_GET['parcel_id'])) {  
                $parcel_id = mysqli_real_escape_string($conn, $_GET['parcel_id']); 
                
                $sql = "SELECT * FROM parcel WHERE parcel_id='$parcel_id'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="form-element">
                        <label>Sender NIC:</label>
                        <input type="text" name="sender_nic" value="<?php echo $row['sender_nic']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Receiver NIC:</label>
                        <input type="text" name="receiver_nic" value="<?php echo $row['rec_nic']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Receiver Name:</label>
                        <input type="text" name="receiver_name" value="<?php echo $row['rec_name']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Phone Number:</label>
                        <input type="text" name="phone" value="<?php echo $row['rec_phone']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Receiver Email:</label>
                        <input type="text" name="email" value="<?php echo $row['rec_email']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Received Date:</label>
                        <input type="date" name="recieved_date" value="<?php echo $row['recieved_date']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Pickup Location:</label>
                        <input type="text" name="pickup" value="<?php echo $row['pickup']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Drop Station:</label>
                        <input type="text" name="dropoff" value="<?php echo $row['dropoff']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Weight (kg):</label>
                        <input type="text" name="weight" value="<?php echo $row['weight']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Payment (LKR):</label>
                        <input type="number" step="0.01" name="payment" value="<?php echo $row['payment']; ?>" required>
                    </div>

                    <div class="form-element">
                        <label>Status:</label>
                        <select name="status">
                            <option value="Ready for Dispatch" <?php if ($row['status'] == "Ready for Dispatch") echo "selected"; ?>>Ready for Dispatch</option>
                            <option value="Dispatched" <?php if ($row['status'] == "Dispatched") echo "selected"; ?>>Dispatched</option>
                            <option value="Arrived at Destination" <?php if ($row['status'] == "Arrived at Destination") echo "selected"; ?>>Arrived at Destination</option>
                        </select>
                    </div>

                    <input type="hidden" name="parcel_id" value="<?php echo $parcel_id; ?>">

                    <div class="form-element">
                        <input type="submit" name="edit" value="Update Parcel" class="btn">
                    </div>
            <?php
                } else {
                    echo "<h3>Parcel does not exist</h3>"; 
                }
            } else {
                echo "<h3>Invalid Request</h3>"; 
            }
            ?>
        </form>
    </div>
</body>
</html>
