<?php
// session_start();
require 'php/connect.php';
// require 'php/session.php';

// Check if the request is a POST request (for form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set
    if (isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time'])) {
        // Retrieve data from the form
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        // Convert start_time to 24-hour format
        $start_time_24hr = date("H:i", strtotime($start_time));
        $end_time_24hr = date("H:i", strtotime($end_time));

        // Query to fetch seat_id based on the specified conditions
        $sql = "SELECT seat_id FROM reservation WHERE `date` = '$date' AND `start_time` <= '$end_time_24hr'  AND `end_time` >= '$start_time_24hr' AND `isDone` = 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Create an array to store seat numbers
            $seat_numbers = array();

            while ($row = $result->fetch_assoc()) {
                $seat_id = $row['seat_id'];

                // Query to fetch seat number from the seat table
                $seatQuery = "SELECT seat_number FROM seat WHERE seat_id = $seat_id";
                $seatResult = $conn->query($seatQuery);

                if ($seatResult->num_rows > 0) {
                    // Fetch and store the seat number
                    $seatRow = $seatResult->fetch_assoc();
                    $seat_number = $seatRow['seat_number'];
                    $seat_numbers[] = $seat_number;
                }
            }

            if (!empty($seat_numbers)) {
                // Return the seat numbers in the response
                echo implode(', ', $seat_numbers);
            } else {
                echo "viewSeats said Seat numbers not found for the reservations.";
            }
        } else {
            echo "viewSeats said No matching reservations found.";
        }

        // Add debugging statements
        // echo "SQL Query: $sql";
        // echo "Number of Rows: " . $result->num_rows;

    } else {
        // Handle cases where required parameters are missing
        echo "Required parameters (date, start_time, end_time) are missing.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the request method is not POST
    echo "Invalid request method";
}
?>
