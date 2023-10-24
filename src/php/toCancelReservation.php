<?php
session_start();
require 'connect.php'; // Include your database connection code here

// Check if the user is logged in (you can add more detailed authentication checks)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after redirection
}

// Check if the reservation_id is provided in the URL
if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    // Perform a database query to delete the reservation
    $delete_query = "DELETE FROM reservation WHERE reservation_id = '$reservation_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        // Deletion was successful
        // You can also perform any additional actions or redirect the user as needed
        echo "Success"; // This message will be received by the AJAX success callback
    } else {
        // Deletion failed, handle the error (e.g., display an error message)
        echo "Error deleting reservation: " . mysqli_error($conn);
    }
} else {
    // Handle the case where reservation_id is not provided in the URL
    echo "Reservation ID not provided.";
}
?>
