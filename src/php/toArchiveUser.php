<?php
session_start();
require 'assets/php/connect.php';
require 'assets/php/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform an SQL update to set is_archived to 1 in the 'account' table
    $sqlAccount = "UPDATE account SET is_archived = 1 WHERE username = $userId";

    // Perform an SQL update to set is_archived to 1 in the 'users' table
    $sqlUsers = "UPDATE users SET is_archived = 1 WHERE user_id = $userId";

    $response = array();

    if ($conn->query($sqlAccount) === TRUE && $conn->query($sqlUsers) === TRUE) {
        $response["success"] = true;
    } else {
        $response["success"] = false;
        $response["error"] = $conn->error;
    }

    echo json_encode($response);
} else {
    // Handle invalid requests
    header('HTTP/1.1 400 Bad Request');
    echo "Invalid request";
}

?>
