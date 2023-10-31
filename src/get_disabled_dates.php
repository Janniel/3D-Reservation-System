<?php
require 'php/connect.php';

// Fetch disabled dates from the database and convert to array
$sql = "SELECT disabled_dates FROM settings WHERE settings_id = 1"; // Use the appropriate settings_id
$result = $conn->query($sql);

$disabledDates = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decode the JSON string into an array
        $disabledDates = json_decode($row['disabled_dates'], true);
    }
}

// Pass $disabledDates to JavaScript
echo json_encode($disabledDates);
?>
