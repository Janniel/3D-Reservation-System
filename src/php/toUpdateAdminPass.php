<?php
session_start();
require 'connect.php';
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newPass = password_hash($_POST['newPass'],PASSWORD_DEFAULT);

    if (isset($_SESSION['selected_admin']) == TRUE) {
        $account_id = $_SESSION['selected_admin'];
    } else {
        $account_id = $_SESSION['account_id'];
        $_SESSION["password"] = $newPass;
    }


    // Update the user's information in the database
    $sql = "UPDATE account SET password = '$newPass' WHERE account_id = '$account_id';";

    if ($conn->query($sql) === TRUE) {
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