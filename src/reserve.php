<?php
session_start();
require 'php/connect.php';
require 'php/session.php';

// Fetch the reservation status from the settings table
$settings_query = "SELECT reservation FROM settings WHERE settings_id = '1'";
$settings_result = mysqli_query($conn, $settings_query);
$settings_row = mysqli_fetch_assoc($settings_result);

$reservation_status = $settings_row['reservation'];

// Check if the reservation status is disabled
if ($reservation_status != '0') {
  header("Location: php/maintenance.php");
  exit();
}

// Fetch the settings from the database
$query = "SELECT * FROM settings WHERE settings_id = '1'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // $reservation = $row["reservation"];
        // $minDuration = $row["minDuration"];
        // $maxDuration = $row["maxDuration"];
        // $reservePerDay = $row["reservePerDay"];
        $start_hour = $row["start_hour"];
        $end_hour = $row["end_hour"];
        // $disabled_dates = json_decode($row["disabled_dates"]);
    }
} else {
    echo "No settings found";
}

$count_query = "SELECT COUNT(*) AS reservation_count FROM reservation WHERE user_id = '{$_SESSION['user_id']}' AND date >= CURDATE()";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$reservation_count = $count_row['reservation_count'];

// Retrieve the maximum reservation per day from the settings table
$settings_query = "SELECT reservePerDay FROM settings WHERE settings_id = '1'";
$settings_result = mysqli_query($conn, $settings_query);
$settings_row = mysqli_fetch_assoc($settings_result);
$reservePerDay = $settings_row['reservePerDay'];

$_SESSION["reservation_count"] = $reservation_count;

// Check if the reservation count has reached the limit
if ($reservation_count >= $reservePerDay) {
  echo "<script>
                Swal.fire({
                  icon: 'warning',
                  title: 'Reservation Limit Reached',
                  text: 'You have reached the maximum reservation limit for today.',
                  confirmButtonText: 'OK',
                  onClose: function() {
                    window.location.href = '../index.php';
                  }
                });
            </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>BulSU Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- <link rel="stylesheet" href="styles/reserve.css"> -->
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
  <script src="https://cdn.jsdelivr.net/npm/timepicker@1.14.1/jquery.timepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.14.1/jquery.timepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  


</head>
<body>
  <?php /* require_once 'php/header.php' */ ?>
  
  <div>
    <canvas class="webgl2"></canvas>
    <div class="container">
      <div class="title-container">
        <div class="title">
          <p class="text-white big-title">Find your <b>ideal seat</b> in <b>3D</b></p>
          <p class="text-white">Welcome to the E-Library's 6th Floor. Select date and time now!</p>
          <button class="explore btn">Reserve Seat</button>
        </div>
      </div>
    </div>


    
    <div class="section-nav">
      <div class="dateTimeSelected">
        <h6> Available Seats on 
          <b id="chosen_date"></b> 
          <b id="chosen_time"></b>
        </h6>
      </div>
   
      <button class="filterBtn" >Filter &nbsp; <i class="fas fa-sliders-h" style="color: #ffffff;"></i></button>
      <button class="section1">Section A</button>
      <button class="section2">Section B</button>
      <button class="section3">Section C</button>
      <button class="section4">Section D</button>
     
    </div>
    
    
    <form method="post" id="reservationForm">
        <div class="container2">
            <div class="dateTimeDiv">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="date">Select date and time</label>
                            <input type="text" class="form-control text-white bg-transparent" name="date" id="date">                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="start_time"></label>
                            <input type="text" class="form-control  text-white bg-transparent" name="start_time" id="start_time" placeholder="Starts from" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="end_time"></label>
                            <input type="text" class="form-control text-white bg-transparent" name="end_time" id="end_time" placeholder="Ends at ">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                    <button type="button" id="viewSeatsButton" class="explore2 mt-3 w-100 btn">Find Seats</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
      let disabledDates;

      // Fetch disabled dates from PHP
      fetch('get_disabled_dates.php')
        .then((response) => response.json())
        .then((data) => {
          disabledDates = data;

          flatpickr("#date", {
            theme: "dark",
            inline: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: "today",
            disable: disabledDates, // Use the fetched disabled dates
          });
        })
        .catch((error) => console.error('Error fetching disabled dates.'));

        function convertTimeTo24HourFormat(time) {
  const [timeStr, ampm] = time.split(' ');
  const [hours, minutes] = timeStr.split(':').map(Number);

  let convertedHours = hours;

  if (ampm === 'PM' && hours !== 12) {
    convertedHours += 12;
  } else if (ampm === 'AM' && hours === 12) {
    convertedHours = 0;
  }

  const formattedHours = convertedHours.toString().padStart(2, '0');
  const formattedMinutes = minutes.toString().padStart(2, '0');

  return `${formattedHours}:${formattedMinutes}`;
}

$(document).ready(function () {
  $('#start_time').timepicker({
    'timeFormat': 'h:i A',
    'forceRoundTime': true,
    'minTime': '<?php echo date('H:i A', strtotime($start_hour))?>', // the min time of the start time is come from the databae column called  start_hour
    'maxTime': '<?php echo date('H:i A', strtotime($end_hour))?>', // the maxTime of start time is came from the database column called end_hour
    'step': 15,
  });

  $('#end_time').timepicker({
    'maxTime': '<?php echo date('H:i A', strtotime($end_hour))?>', //the maxTime of end time is came from the database column called end_hour
    'step': 15,
    'showDuration': true,
    'timeFormat': 'h:i A',
  });

  $('#start_time').on('change', function () {
    var startTimeValue = $(this).val();
    $('#end_time').timepicker('option', 'minTime', startTimeValue);
    validateTimeSelection();
  });

  $('#end_time').on('change', function () {
    validateTimeSelection();
  });

  $('#viewSeatsButton').prop('disabled', true);


 // Function to validate and disable the button if necessary
 function validateTimeSelection() {
  const startTime = $('#start_time').val();
  const endTime = $('#end_time').val();

  // Regular expression to match time in HH:MM AM/PM format
  const timeFormatPattern = /^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i;

  // Check if the start time and end time are empty
  if (startTime === '' || endTime === '') {
    $('#viewSeatsButton').prop('disabled', true);
    return;
  }

  // Check if both start time and end time match the time format
  if (timeFormatPattern.test(startTime) && timeFormatPattern.test(endTime)) {
    // Parse the time values to compare them
    const startTime24Hour = convertTimeTo24HourFormat(startTime);
    const endTime24Hour = convertTimeTo24HourFormat(endTime);

    if (startTime24Hour < endTime24Hour) {
      $('#viewSeatsButton').prop('disabled', false);
    } else {
      $('#viewSeatsButton').prop('disabled', true);
    }
  } else {
    $('#viewSeatsButton').prop('disabled', true);
  }
}




});



   
    });
    </script>
    
    <div class="tooltip">
      <p></p>
      <h2></h2>
    </div>

    <div id="reserveDiv" class="reserveDiv" style="display: none;">
      <small>You Selected</small>
      <!-- <small class="btn btn-sm  text-white float-end" id="reserveDivClose">close</small> -->
      <h1><b></b></h1>
      <p></p>
      <p></p>
      <button id="reserveBtn" class="btn explore">Reserve Seat</button>
      <button class="btn text-white" id="reserveDivClose">Cancel</button>
    </div>


  </div>

  <script>
    
  document.addEventListener('DOMContentLoaded', function () {
    // Get references to the form and the submit button
    var form = document.getElementById('reservationForm');
    var viewSeatsButton = document.getElementById('viewSeatsButton');

    // Add a click event listener to the button
    viewSeatsButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = new FormData(form);

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'viewSeats.php', true);

        // Set the callback function to handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful, handle the response here
                var response = xhr.responseText;
                // You can update your page with the response data as needed
                console.log(response);
            } else {
                // Request failed
                console.error('Request failed with status ' + xhr.status);
            }
        };

        // Send the form data as the request body
        xhr.send(formData);
    });
});

</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
