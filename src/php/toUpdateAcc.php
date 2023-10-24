<?php
session_start();
require 'connect.php';
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $newEmail = $_POST['email'];

    // Check if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];

        // Handle file processing and update the profile picture in the database
        $uploadDir = 'img/profile';
        $uploadedFilePath = $uploadDir . $fileName;
        move_uploaded_file($fileTmpPath, $uploadedFilePath);

        $sql = "UPDATE account SET email = '$newEmail', picture = '$uploadedFilePath' WHERE username = '$username'";
    } else {
        // Update only the email
        $sql = "UPDATE account SET email = '$newEmail' WHERE username = '$username'";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }

    $conn->close();
}
?>
