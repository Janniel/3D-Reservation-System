<?php
session_start();
require 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the reservation_id is provided in the URL
if (isset($_GET['reservation_id']) && isset($_GET['reason'])) {
    $reservation_id = $_GET['reservation_id'];
    $cancel_reason = mysqli_real_escape_string($conn, $_GET['reason']);

    // Check the last cancellation time for the user
    $check_last_cancellation_query = "SELECT last_cancel FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $check_last_cancellation_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $last_cancellation_time = strtotime($row['last_cancel']);

        // Check if enough time has passed since the last cancellation (e.g., 24 hours)
        $time_elapsed = time() - $last_cancellation_time;
        $cancellation_limit_time = 24 * 60 * 60; // 24 hours in seconds

        if ($last_cancellation_time !== NULL && $time_elapsed < $cancellation_limit_time) {
            echo "You can only cancel reservation once per day.";
        } else {
            // Retrieve start_time and end_time from the reservation table
            $get_occupy_times_query = "SELECT start_time, end_time FROM reservation WHERE reservation_id = '$reservation_id'";
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
                                      SELECT reservation_id, seat_id, user_id, date, '00:00:00', '00:00:00', '00:00:00' FROM reservation 
                                      WHERE reservation_id = '$reservation_id'";

                if (mysqli_query($conn, $move_to_history_query)) {
                    // Reservation successfully moved to history

                    // Now, delete the corresponding entry from the occupy table
                    $update_occupy_query = "UPDATE occupy SET isDone = 1, end_time = '00:00:00', time_spent = '00:00:00' WHERE reservation_id = '$reservation_id'";

                    if (mysqli_query($conn, $update_occupy_query)) {
                        // Update the isDone column in the reservation table to 1
                        $update_reservation_query = "UPDATE reservation SET isDone = 1 WHERE reservation_id = '$reservation_id'";
                        if (mysqli_query($conn, $update_reservation_query)) {

                            // Notification inserted into the database successfully
                            $update_history_query = "UPDATE history SET cancel_reason =  '$cancel_reason'  WHERE reservation_id = '$reservation_id'";
                            if (mysqli_query($conn, $update_history_query)) {

                                // Update the last cancellation time for the user
                                $update_last_cancellation_query = "UPDATE users SET last_cancel = NOW() WHERE user_id = '$user_id'";
                                if (mysqli_query($conn, $update_last_cancellation_query)) {
                                    echo "Success";
                                } else {
                                    echo "Error updating last cancellation time: " . mysqli_error($conn);
                                }
                            } else {
                                echo "Error updating history table: " . mysqli_error($conn);
                            }
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
                echo "Error retrieving start_time and end_time from reservation table: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error checking last cancellation time: " . mysqli_error($conn);
    }
} else {
    echo "Reservation ID not provided.";
}
?>
