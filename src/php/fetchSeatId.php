<?php
require 'php/connect.php';


// Check if the "seat_number" parameter is set in the POST request
if (isset($_POST['seat_number'])) {
    $seatNumber = $_POST['seat_number'];

    // Retrieve the seat_id based on the seat_number
    $sql = "SELECT seat_id FROM seat WHERE seat_number = '$seatNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Assuming that there is only one row for the given seat_number
        $row = $result->fetch_assoc();
        $seatId = $row['seat_id'];
        echo $seatId;
    } else {
        // Handle the case where the seat_number is not found
        echo json_encode(['seat_id' => 'Not found']);
    }
} else {
    // Handle the case where "seat_number" is not set in the POST request
    echo json_encode(['seat_id' => 'Parameter not set']);
}

// Close the database connection
$conn->close();
?>
