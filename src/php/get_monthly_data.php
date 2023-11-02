<?php
require 'connect.php';
session_start();

if (isset($_GET['year'])) {
    $selectedYear = $_GET['year'];

    // Modify your SQL query to fetch data for the selected year
    $sqlMonth = "SELECT DATE_FORMAT(date, '%c') AS month, COUNT(*) AS reservation_count 
        FROM reservation
        WHERE is_archived = 0 AND YEAR(date) = " . $selectedYear . "
        GROUP BY month";
    $resultMonth = $conn->query($sqlMonth);

    $monthData = [];
    while ($row = $resultMonth->fetch_assoc()) {
        $month = (int)$row['month'];
        $monthData[$month] = $row['reservation_count'];
    }

    // Fill in missing months with 0 counts
    $finalData = [];
    $months = range(1, 12);
    foreach ($months as $month) {
        $finalData[] = isset($monthData[$month]) ? $monthData[$month] : 0;
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode(['finalData' => $finalData]);
} else {
    // Handle the case where no year is provided
    echo json_encode(['error' => 'No year provided']);
}
?>
