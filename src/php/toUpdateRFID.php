<?php
session_start();
require 'connect.php';
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $newRFID = trim($_POST['rfid']);
    $sql = "UPDATE users SET rfid_no = '$newRFID' WHERE user_id = '$userId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
    $conn->close();
}
?>