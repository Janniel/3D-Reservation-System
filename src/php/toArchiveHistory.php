<?php
require 'connect.php';

//ARCHIVE RESERVATION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['history_id'])) {
    $historyId = $_POST['history_id'];

    $archiveSql = "UPDATE history SET is_archived = 1 WHERE history_id = ?";
    $stmt = $conn->prepare($archiveSql);
    $stmt->bind_param('i', $historyId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'Invalid request';
}




?>
