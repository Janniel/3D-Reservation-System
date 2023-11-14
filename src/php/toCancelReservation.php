<?php
session_start();
require 'connect.php'; // Include your database connection code here

// Check if the user is logged in (you can add more detailed authentication checks)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after redirection
}

$user_id = $_SESSION['user_id'];


// Check if the reservation_id is provided in the URL
if (isset($_GET['reservation_id']) && isset($_GET['reason'])) {
    $reservation_id = $_GET['reservation_id'];
    $cancel_reason =  mysqli_real_escape_string($conn, $_GET['reason']);
   

     // Retrieve start_time and end_time from the occupy table
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
             $update_occupy_query = "UPDATE occupy SET isDone = 1, end_time = '00:00:00' , time_spent = '00:00:00' WHERE reservation_id = '$reservation_id'";

             if (mysqli_query($conn, $update_occupy_query)) {
                 // Update the isDone column in the reservation table to 1
                 $update_reservation_query = "UPDATE reservation SET isDone = 1 WHERE reservation_id = '$reservation_id'";
                 if (mysqli_query($conn, $update_reservation_query)) {
                    
                    $message = "cancelled a reservation with reservation ID: $reservation_id ";

                    $sql2 = "INSERT INTO notification (user_id, message, date) 
                            VALUES ('$user_id', '$message', NOW())";

                    if (mysqli_query($conn, $sql2)) {

                        // Now, delete the corresponding entry from the occupy table
                        $update_history_query = "UPDATE history SET cancel_reason =  '$cancel_reason'  WHERE reservation_id = '$reservation_id'";
                        if (mysqli_query($conn, $update_history_query)) {
                             // Notification inserted into the database successfully
                            echo "Success";
                        }
                        else {
                            // Error occurred during the notification insertion
                            echo "error";
                        }
                       
                    } else {
                        // Error occurred during the notification insertion
                        echo "error";
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
         echo "Error retrieving start_time and end_time from occupy table: " . mysqli_error($conn);
     }
} else {
    // Handle the case where reservation_id is not provided in the URL
    echo "Reservation ID not provided.";
}
?>
