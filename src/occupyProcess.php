<?php
session_start();
require 'php/connect.php';
require 'php/session.php';

// // Set the server's time zone to Asia/Manila
// date_default_timezone_set('Asia/Manila');

if (isset($_POST['seat_id'])) {
    $seat_id = $_POST['seat_id'];
    $user_id = $_SESSION['user_id'];
    $current_date = date('Y-m-d');  // Current date
    $current_time = date('H:i:s');  // Current time

    // Check if the user already occupies a seat
    $occupy_check_query = "SELECT COUNT(*) AS occupy_count FROM occupy WHERE user_id = $user_id AND isDone = 0";
    $occupy_check_result = mysqli_query($conn, $occupy_check_query);

    if ($occupy_check_result) {
        $occupy_count = mysqli_fetch_assoc($occupy_check_result)['occupy_count'];

        if ($occupy_count >= 1) {
            echo "Hi, $user_id. You cannot occupy more than one seat at a time.";
            exit();
        }
    } else {
        // Handle the error if the query fails
        echo "An error occurred while checking occupancy.";
        exit();
    }

    // Check if the user has a reservation for the specified time and seat
    $query = "SELECT reservation_id, date, start_time, end_time FROM reservation WHERE user_id = $user_id AND isDone = 0 AND seat_id = $seat_id ";

    $reservation_result = mysqli_query($conn, $query);

    if ($reservation_result && mysqli_num_rows($reservation_result) > 0) {
        $reservation = mysqli_fetch_assoc($reservation_result);

        $reservation_id = $reservation['reservation_id'];
        $date = $reservation['date'];
        $start_time = $reservation['start_time'];
        $end_time = $reservation['end_time'];

        $start_timestamp = strtotime($date . ' ' . $start_time);
        $end_timestamp = strtotime($date . ' ' . $end_time);
        $current_timestamp = strtotime($current_date . ' ' . $current_time);

        if ($current_timestamp >= $start_timestamp && $current_timestamp <= $end_timestamp) {
            // Insert data into the occupy table
            $occupy_query = "INSERT INTO occupy (reservation_id, date, start_time, user_id, seat_id) VALUES ($reservation_id, '$date', '$current_time', $user_id, $seat_id)";
            $occupy_result = mysqli_query($conn, $occupy_query);

            if ($occupy_result) {
                // Update the status of the seat in the seat table
                $update_seat_query = "UPDATE seat SET status = 1 WHERE seat_id = $seat_id";
                $update_seat_query_result = mysqli_query($conn, $update_seat_query);

                if ($update_seat_query_result) {
                    // Send a response indicating success
                    $response['success'] = true;
                    echo "Seat $seat_id occupied successfully. You are $user_id. Occupied on $current_date from $current_time until $end_time";

                    // Start a JavaScript timer to update the time spent every second
                    echo "<script>
                            var timeSpent = 0;
                            setInterval(function() {
                                timeSpent++;
                                document.getElementById('timeSpent').innerHTML = 'Time Spent: ' + timeSpent + ' seconds';
                            }, 1000);
                          </script>";
                    echo "<div id='timeSpent'></div>"; // Display the time spent here
                } else {
                    // Send an error response
                    $response['success'] = false;
                    $response['error'] = "Error updating seat status: " . mysqli_error($conn);
                }
            } else {
                // Send an error response
                $response['success'] = false;
                $response['error'] = "Error inserting data into the occupy table: " . mysqli_error($conn);
            }
        } else {
            echo "Hi, $user_id. Occupancy not successful. Please check your reservation time on this seat";
        }
    } else {
        echo "Hi, $user_id. Occupancy not successful because you don't have any reservation for this seat.";
    }
} else {
    echo "Invalid request.";
}
?>
