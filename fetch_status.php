<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["parcel_id"])) {
    $parcel_id = mysqli_real_escape_string($conn, $_POST["parcel_id"]);

    // Query to fetch parcel status
    $query = "SELECT status FROM parcel WHERE parcel_id = '$parcel_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(["status" => $row["status"]]);
    } else {
        echo json_encode(["status" => null]);
    }
}
?>
