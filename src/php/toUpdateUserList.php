<?php
session_start();
require 'assets/php/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get other data from the POST request
    $userId = $_POST['userId'];
    $rfidNo = $_POST['rfidNo'];
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $courseCode = $_POST['courseCode'];
    $accountType = $_POST['accountType'];
   

   
    // Handle file upload
    $picture = null;
    if (isset($_FILES['profile_picture'])) {
        $uploadFolder = 'assets/img/profile/'; // Specify the folder where you want to store the images
        $picture = $uploadFolder . $_FILES['profile_picture']['name'];

        // Upload the file to the designated folder
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $picture);
    }

    // Update the user's information in the "account" table, including the picture column
    $updateQuery = "UPDATE users
                    JOIN account ON users.user_id = account.username
                    SET users.first_name = '$firstName',
                        users.last_name = '$lastName',
                        users.course_code = '$courseCode',
                        
                        account.email = '$email',
                        account.account_type = '$accountType',
                        account.picture = '$picture'
                    WHERE users.user_id = $userId";

    if ($conn->query($updateQuery) === true) {
        // Success message
        $response = ['status' => 'success', 'message' => 'User information updated successfully.'];
    } else {
        // Error message
        $response = ['status' => 'error', 'message' => 'Error updating user information.'];
    }

    // Convert the response to JSON and echo it
    echo json_encode($response);
}
?>
