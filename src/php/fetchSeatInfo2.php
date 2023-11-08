<?php
require 'php/connect.php';



// Retrieve the seat_name based on the seat_number
$seatNumber = $_GET['seat_number'];

$sql = "SELECT seat_name FROM seat WHERE seat_number = '$seatNumber'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Assuming that there is only one row for the given seat_number
    $row = $result->fetch_assoc();
    $seatName = $row['seat_name'];
    echo $seatName;
} else {
    // Handle the case where the seat_number is not found
    echo json_encode(['seat_name' => 'Not found']);
}

// Close the database connection
$conn->close();
?>