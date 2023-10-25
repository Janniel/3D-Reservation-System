<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST["reservationId"];

    
    $sql = "DELETE FROM reservation WHERE reservation_id = $reservationId";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}
?>