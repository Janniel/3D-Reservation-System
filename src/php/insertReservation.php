<?php
session_start();
require 'assets/php/connect.php';

// Get reservation data from the AJAX request
$data = json_decode(file_get_contents('php://input'));

$seatNumber = $data->seatNumber;
$date = $data->date;
$startTime = $data->startTime;
$endTime = $data->endTime;
$user_id = $_SESSION['user_id'];

// Check if the selected date and time range already exists in the database for the specified seat
$query = "SELECT * FROM reservation WHERE seat_id = '$seatNumber' AND date = '$date' AND start_time < '$endTime' AND end_time > '$startTime' AND isDone = 0";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

if ($count > 0) {
  // The seat is already reserved for the selected date and time range
  echo "error";
} else {
  // Insert the reservation into the database
  $sql = "INSERT INTO reservation (date, start_time, end_time, user_id, seat_id) 
  VALUES ('$date', '$startTime', '$endTime', '$user_id', '$seatNumber')";

  if (mysqli_query($conn, $sql)) {
    // Reservation inserted successfully
    echo "success";
  } else {
    // Error occurred during the database insertion
    echo "error";
  }
}

mysqli_close($conn);
?>
