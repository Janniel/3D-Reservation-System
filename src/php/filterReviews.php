<?php
session_start();
require 'connect.php';
require 'session.php';

// Define the filterTable function
function filterTable($querySearch)
{
    require 'connect.php'; // You may need to adjust the path to your database connection file.
    $filter_Result = mysqli_query($conn, $querySearch);
    return $filter_Result;
}

// Retrieve filter criteria from the AJAX request
$selectedYear = $_POST['selectedYear'];
$selectedMonth = $_POST['selectedMonth'];
$selectedStars = $_POST['selectedStars'];

// Modify your SQL query based on the selected criteria
$querySearch = "SELECT * FROM rating WHERE rating_id >= 0";

if ($selectedYear != 'all') {
    // Apply year filter
    $querySearch .= " AND YEAR(date) = '$selectedYear'";
}

if ($selectedMonth != 'all') {
    // Apply month filter
    $querySearch .= " AND MONTHNAME(date) = '$selectedMonth'";
}

if ($selectedStars != 'all') {
    // Apply star rating filter
    $querySearch .= " AND rating = '$selectedStars'";
}

// Execute the filtered query
$search_result = filterTable($querySearch);

// Generate HTML for the filtered reviews
$html = '';
if (mysqli_num_rows($search_result) > 0) {
    while ($row2 = mysqli_fetch_array($search_result)) {
        $html .= '<div class="reviews">';
        $html .= '<div class="review-header">';
        $html .= '<div class="review-info">';
        $html .= '<span class="name">' . $row2['user_id'] . '</span>';
        $html .= '<span class="date">' . $row2['date'] . '</span>';
        $html .= '</div>';
        $html .= '<div class="star-rating">';
        $html .= '<span>';
        if ($row2['rating'] == "1") {
            $html .= "⭐";
        } elseif ($row2['rating'] == "2") {
            $html .= "⭐⭐";
        } elseif ($row2['rating'] == "3") {
            $html .= "⭐⭐⭐";
        } elseif ($row2['rating'] == "4") {
            $html .= "⭐⭐⭐⭐";
        } elseif ($row2['rating'] == "5") {
            $html .= "⭐⭐⭐⭐⭐";
        }
        $html .= '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="review-text">';
        $html .= '<p>' . $row2['review'] . '</p>';
        $html .= '</div>';
        $html .= '</div>';
    }
}

// Return the filtered reviews as HTML response
echo $html;
?>
