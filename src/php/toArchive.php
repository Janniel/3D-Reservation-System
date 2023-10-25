<?php
require 'connect.php';

//ARCHIVE RESERVATION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    $reservationId = $_POST['reservation_id'];

    $archiveSql = "UPDATE reservation SET is_archived = 1 WHERE reservation_id = ?";
    $stmt = $conn->prepare($archiveSql);
    $stmt->bind_param('i', $reservationId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'Invalid request';
}




?>
