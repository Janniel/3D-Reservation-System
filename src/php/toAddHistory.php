<?php
session_start();
require 'connect.php';

// Set the server's time zone to Asia/Manila
date_default_timezone_set('Asia/Manila');

if (isset($_GET['reservation_id'])) {
    $reservation_id = mysqli_real_escape_string($conn, $_GET['reservation_id']);

    // Get the current time
    $current_time = date('H:i:s');

    // Update the seat status to 0 (available)
    $update_seat_query = "UPDATE seat SET status = 0 WHERE seat_id IN (SELECT seat_id FROM reservation WHERE reservation_id = '$reservation_id')";

    if (mysqli_query($conn, $update_seat_query)) {
        // Retrieve start_time and end_time from the occupy table
        $get_occupy_times_query = "SELECT start_time, end_time FROM occupy WHERE reservation_id = '$reservation_id'";

        $occupy_times_result = mysqli_query($conn, $get_occupy_times_query);

        if ($occupy_times_result) {
            $row = mysqli_fetch_assoc($occupy_times_result);

            // Calculate time spent in seconds
            $start_time = new DateTime($row['start_time']);
            $end_time = new DateTime($row['end_time']);
            $interval = $start_time->diff($end_time);
            $time_spent = $interval->format('%H:%I:%S');

            // Move the reservation to history and insert the spent time
            $move_to_history_query = "INSERT INTO history (reservation_id, seat_id, user_id, date, start_time, end_time, time_spent) 
                                 SELECT reservation_id, seat_id, user_id, date, '{$row['start_time']}', '$current_time', '$time_spent' FROM reservation 
                                 WHERE reservation_id = '$reservation_id'";

            if (mysqli_query($conn, $move_to_history_query)) {
                // Reservation successfully moved to history

                // Now, delete the corresponding entry from the occupy table
                $update_occupy_query = "UPDATE occupy SET isDone = 1, end_time = '$current_time', time_spent = '$time_spent' WHERE reservation_id = '$reservation_id'";

                if (mysqli_query($conn, $update_occupy_query)) {
                    // Update the isDone column in the reservation table to 1
                    $update_reservation_query = "UPDATE reservation SET isDone = 1 WHERE reservation_id = '$reservation_id'";
                    if (mysqli_query($conn, $update_reservation_query)) {
                        echo "Success";
                    } else {
                        echo "Error updating isDone column in reservation table: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error updating isDone column in occupy table: " . mysqli_error($conn);
                }
            } else {
                echo "Error moving reservation to history: " . mysqli_error($conn);
            }
        } else {
            echo "Error retrieving start_time and end_time from occupy table: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating seat status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid reservation ID";
}
?>
