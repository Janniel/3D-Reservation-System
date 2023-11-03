<?php
require 'connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $historyId = $_POST["historyId"];

    
    $sql = "UPDATE history SET is_archived = 0 WHERE history_id = $historyId";

    if ($conn->query($sql) === TRUE) {
        echo "success"; 
    } else {
        echo "error". $conn->error; 
    }
}
?>
