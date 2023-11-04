<?php
session_start();
require 'php/connect.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];

    // Retrieve the current reservation details
    $reservation_query = "SELECT seat_id, end_time FROM reservation WHERE reservation_id = '$reservation_id'";
    $reservation_result = mysqli_query($conn, $reservation_query);

    if ($reservation_result && $reservation_row = mysqli_fetch_assoc($reservation_result)) {
        $seat_id = $reservation_row['seat_id'];
        $end_time = $reservation_row['end_time'];

        // Calculate the new end time after extension
        $extend_minutes = 30; // Extend by 30 minutes
        $new_end_time = date('Y-m-d H:i:s', strtotime($end_time) + ($extend_minutes * 60)); // Extend by 30 minutes

        // Check if there are any conflicting reservations
        $conflict_query = "SELECT * FROM reservation WHERE seat_id = '$seat_id' AND start_time < '$new_end_time' AND end_time > '$end_time' AND reservation_id != '$reservation_id' AND isDone = 0";
        $conflict_result = mysqli_query($conn, $conflict_query);

        if ($conflict_result && mysqli_num_rows($conflict_result) > 0) {
            // There are reservations that conflict with the extension
            echo json_encode(array('success' => false, 'message' => 'Sorry, but time extension is not allowed. There is a reservation after your time ends. '));
        } else {
            // Update the reservation end time to the new extended time
            $update_query = "UPDATE reservation SET end_time = '$new_end_time' WHERE reservation_id = '$reservation_id'";
            $result = mysqli_query($conn, $update_query);

            if ($result) {
                echo json_encode(array('success' => true, 'message' => 'Reservation time extended by 30 minutes.'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Failed to extend reservation time.'));
            }
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to retrieve reservation details.'));
    }
} else {
    // Handle invalid request method (e.g., GET request)
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
?>
