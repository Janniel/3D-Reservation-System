<?php
session_start();
require 'php/connect.php';

$seat_id = $_GET['seat_id'];
$user_id = $_SESSION['username'];
$date = $_GET['date'];
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];

// Check if the selected date and time range already exists in the database for the specified seat
$query = "SELECT * FROM reservation WHERE seat_id = '$seat_id' AND date = '$date' AND start_time < '$end_time' AND end_time > '$start_time' AND isDone = 0";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

if ($count > 0) {
    // The seat is already reserved for the selected date and time range
    echo "error";
} else {
    // Insert the reservation into the database
    $sql = "INSERT INTO reservation (date, start_time, end_time, user_id, seat_id) 
            VALUES ('$date', '$start_time', '$end_time',  '$user_id', '$seat_id')";

    if (mysqli_query($conn, $sql)) {
        // Reservation inserted successfully
        $message = "reserved seat $seat_id on " . date("F j, Y", strtotime($date)) . " from " . date("h:i A", strtotime($start_time)) . " to " . date("h:i A", strtotime($end_time));

        $sql2 = "INSERT INTO notification (user_id, message, date) 
                 VALUES ('$user_id', '$message', NOW())";

        if (mysqli_query($conn, $sql2)) {
            // Notification inserted into the database successfully
            echo "success";
        } else {
            // Error occurred during the notification insertion
            echo "error";
        }
    } else {
        // Error occurred during the reservation insertion
        echo "error";
    }
}

mysqli_close($conn);
?>
