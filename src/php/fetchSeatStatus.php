<?php
// Include your database connection configuration
include 'php/connect.php';


// SQL query to fetch maintenance seats
$sql = "SELECT seat_number FROM seat Where status = 404";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $maintenanceSeats = array();
    while ($row = $result->fetch_assoc()) {
        $maintenanceSeats[] = $row["seat_number"];
    }

    // Return JSON response
    header("Content-Type: application/json");
    echo json_encode(['maintenanceSeats' => $maintenanceSeats]);
} else {
    // Handle no results or errors
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => 'Internal Server Error']);
}

// Close the MySQLi connection
$conn->close();

?>
