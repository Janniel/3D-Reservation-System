<?php
session_start();
require 'connect.php';
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newUsername = $_POST['newUsername'];

    if (isset($_SESSION['selected_admin']) == TRUE) {
        $account_id = $_SESSION['selected_admin'];
    } else {
        $account_id = $_SESSION['account_id'];
        $_SESSION["username"] = $newUsername;
    }
    
    // Update the user's information in the database
    $sql = "UPDATE account SET username = '$newUsername' WHERE account_id = '$account_id';";
    $sql2 = " UPDATE admin SET admin_id = '$newUsername'  WHERE account_id = '$account_id';";

    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        // Return a success response as JSON if the update is successful
        echo json_encode(array('status' => 'success'));
    } else {
        // Return an error response as JSON if the update fails
        echo json_encode(array('status' => 'error'));
    }

    // Close the database connection
    $conn->close();
    unset($_SESSION["selected_admin"]);
}

?>