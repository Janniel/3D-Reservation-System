<?php
session_start();
require 'php/connect.php';
require 'php/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the rating and opinion from the form
    $rating = $_POST['rating'];
    $opinion = $_POST['opinion'];

    // Assuming you have the user's ID in the session, adjust accordingly
    $userId = $_SESSION['username'];

    // Insert the data into the "rating" table
    $insertQuery = "INSERT INTO rating (rating, review, date, user_id)
                    VALUES ('$rating', '$opinion', NOW(), '$userId')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "Record inserted successfully!";
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}
?>
