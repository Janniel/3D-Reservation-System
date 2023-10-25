<?php
// connect to the database
require 'connect.php';

// get reservation details
$date = $_GET["date"];
$start_time = "7:00 AM";
$end_time = "5:00 PM";

// format date in words
$date_time = new DateTime($date);
$date_in_words = $date_time->format('F j, Y');

// Set the timezone to the Philippines
date_default_timezone_set('Asia/Manila');

// Get the current date and time in the Philippines
$currentDateTime = date('Y-m-d H:i');

// Compare the selected date and start time with the current date and time
$selectedDateTime = $date . ' ' . $start_time;
$currentDateTime = date('Y-m-d H:i');

// Compare the selected date and start time with the current date and time
if (($date < date('Y-m-d')) && ($end_time <= date('H:i', strtotime($currentDateTime)))) {
    // Display the error message with alert()
    echo '<div class="d-flex justify-content-center align-items-center vh-100" data-aos="fade">
        <div class="text-center">
            <i class="bi bi-exclamation-circle-fill text-danger display-1"></i>
            <h5 class="mt-3">Invalid Time Selection</h5>
            <p>Please select another date and time.</p>
        </div>
    </div>';
} else {
    // continue with the rest of the code to display the 3D view card and available seats



    // retrieve all seats
    $sql = "SELECT * FROM seat";
    $result = mysqli_query($conn, $sql);

    // retrieve reservations for the specified date and time
    $reservationSql = "SELECT seat_id FROM reservation WHERE date = '$date' AND start_time <= '$end_time' AND end_time >= '$start_time' AND isDone = 0" ;
    $reservationResult = mysqli_query($conn, $reservationSql);
    $reservedSeats = array();

    // collect the reserved seat IDs
    while ($row = mysqli_fetch_assoc($reservationResult)) {
        $reservedSeats[] = $row['seat_id'];
    }

    $st = date('h:i A', strtotime($start_time));
    $et = date('h:i A', strtotime($end_time));

    // display the 3D view card and available seats
    echo '<div id="view-3d"class="card view-3d">
        <div class="card-header">
        <h5> Seats Information </h5><p class="text-muted">' . $date_in_words . ' | ' . $st . ' - ' . $et . ' </p>
        </div>
        <div class="card-body m-0 p-0">
            <div><model-viewer src="../models/6thFloorV2.glb" 
            camera-controls  
            exposure="0.8"
            camera-orbit="0deg 45deg 2m" 
            ar 
            ar-modes="webxr scene-viewer quick-look" 
            shadow-intensity="1" 
            environment-image="../models/spruit_sunrise_1k_HDR.hdr">';

    while ($row = mysqli_fetch_assoc($result)) {
        $seat_number = $row['seat_number'];
        $seat_id = $row['seat_id'];
        $surface_data = $row['data_surface'];

        if (in_array($seat_id, $reservedSeats)) {
            // seat is already reserved, display disabled button
            echo "<button class='btn btn-dark btn-sm Hotspot' 
            style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;' 
            slot='hotspot-$seat_id' data-surface='$surface_data' 
            data-visibility-attribute='visible' 
            disabled><div class='HotspotAnnotation'>S$seat_number</div></button>";
        } else {
            // seat is available, display enabled button
            echo "<button class='btn btn-success btn-sm Hotspot'
            style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'  
            id='seat-$seat_id' 
            slot='hotspot-$seat_id' 
            data-surface='$surface_data' 
            data-visibility-attribute='visible' 
            onclick='reserveSeat($seat_id)'><div class='HotspotAnnotation'>S$seat_number</div></button>";
        }
    }

    // close the 3D view card and other HTML tags
    echo '</model-viewer></div></div></div>';

    // close the database connection
    mysqli_close($conn);
}
?>