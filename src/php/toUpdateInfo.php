<?php
session_start();
require 'connect.php';
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user ID, new first name, and new last name from the AJAX request
    $userId = $_SESSION['user_id'];
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newAge = $_POST['age'];
    $newBday = $_POST['bday'];

    $newNumber = $_POST['contact_number'];
    $newGender = $_POST['gender'];

    // Update the user's information in the database
    $sql = "UPDATE users SET first_name = '$newFirstName', last_name = '$newLastName', gender = '$newGender', bday = '$newBday', contact_number = '$newNumber', 
            age = '$newAge'  WHERE user_id = '$userId'";
    if ($conn->query($sql) === TRUE) {
        // Return a success response as JSON if the update is successful
        echo json_encode(array('status' => 'success'));
    } else {
        // Return an error response as JSON if the update fails
        echo json_encode(array('status' => 'error'));
    }

    // Close the database connection
    $conn->close();
}
?>