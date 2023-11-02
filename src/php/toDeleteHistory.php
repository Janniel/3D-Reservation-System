<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $historyId = $_POST["historyId"];

    
    $sql = "DELETE FROM history WHERE history_id = $historyId";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}
?>