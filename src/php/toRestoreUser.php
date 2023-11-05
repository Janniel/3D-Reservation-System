<?php
require 'connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["userId"];

    // Update 'users' table to set is_archived to 0
    $sqlUsers = "UPDATE users SET is_archived = 0 WHERE user_id = $userId";

    // Update 'account' table to set is_archived to 0
    $sqlAccount = "UPDATE account SET is_archived = 0 WHERE username = $userId";

    // Use a transaction to ensure both updates succeed or fail together
    $conn->begin_transaction();

    if ($conn->query($sqlUsers) === TRUE && $conn->query($sqlAccount) === TRUE) {
        $conn->commit(); // Both queries succeeded, commit the transaction
        echo json_encode(["success" => true]);
    } else {
        $conn->rollback(); // One or both queries failed, rollback the transaction
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}
?>
