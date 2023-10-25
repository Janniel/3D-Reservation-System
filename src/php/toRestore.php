<?php
require 'connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST["reservationId"];

    
    $sql = "UPDATE reservation SET is_archived = 0 WHERE reservation_id = $reservationId";

    if ($conn->query($sql) === TRUE) {
        echo "success"; 
    } else {
        echo "error". $conn->error; 
    }
}
?>
