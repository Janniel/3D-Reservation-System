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
  

  <style>
    .body2d {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.btn2d {
    width: 50px;
    height: 50px;
    margin: 5px;
    border: none;
    background: url("./img/chair0.png") no-repeat center center;
    background-size: cover;
    cursor: pointer;
}
.btn2d:hover {
  scale: 1.1;
  transition-duration: 200ms;
}

.table2d {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 1rem;
}

.divider2d {
    /* height: 2px;
    width: 100%;
    background-color: #ccc; 
    margin: 20px 0;  */
}

.long-table2d { /* pwedeng alisin na to */
    height: 40px;
    width: 100%;
    background-color: lightgray; 
    border-radius: 4px;
}

h3 {
    font-size: 18px;
}

.row2d  {
    display: flex;
    gap: 5px;
}

/* .opposite-row2d {
    display: flex;
    gap: 5px;
    transform: scaleX(-1); 
    margin-top: 15px;
} */

.opposite { /* Flips the chair as an opposite */
    /* transform: rotateZ(180deg); */
    transform: rotate(180deg);
}


.topview {
  display:flex;flex: auto; flex-wrap: wrap; align-items: center; align-content: center; flex-direction: column;
  overflow-x: auto;
    overflow-y: auto;
    z-index: 99;
    padding-top: 2rem;
}
#seatContainer {
  padding: 1rem;
}

  </style>


</head>
<body>

<?php

?>
<script>
          
          // Function to trigger the PHP script
          function triggerValidation() {
              var xhr = new XMLHttpRequest();
              xhr.open('GET', 'php/validateReservation.php', true);
              xhr.onreadystatechange = function () {
                  if (xhr.readyState === 4) {
                      if (xhr.status === 200) {
                          console.log('Checked expired validation');
                      } else {
                          console.log('Error in checking expired validation');
                      }
                  }
              };
              xhr.send();
          }
      
          // Call the function immediately
          triggerValidation();
      
          // Set up a recurring timer to call the function every 5 seconds (5000 milliseconds)
          setInterval(triggerValidation, 5000);
      </script>
  <?php /* require_once 'php/header.php' */ ?>

  <nav class="nav">
    <ul class="nav-ul">
      <li><a href="index.php" id="nav_home">Home</a></li>
      <li><a href="profile.php"  id="nav_account" >Account</a></li>
    </ul>
  </nav>
  
 
  
  
  <div>
    <canvas class="webgl2"></canvas>

  
    
    <div class="container">
      <div class="title-container">
        <div class="title">
          <p class="text-white big-title">Find your <b>ideal seat</b> in <b>3D</b></p>
          <p class="text-white">Welcome to the E-Library's 6th Floor. Please select  date and time <br> to view available seats in order to reserve.</p>
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
   
      <button class="sections" id="filterBtn" >Filter &nbsp; <i class="fas fa-sliders-h" style="color: #ffffff;"></i></button>
      <button class="sections" id="section1">Section A</button>
      <button class="sections" id="section2">Section B</button>
      <button class="sections" id="section3">Section C</button>
      <button class="sections" id="section4">Section D</button>
     
    </div>

    <div id="topview" class="topview">
      <div class="topview1  text-center">
        <h4>Section A</h4>
        <div class="table2d">
          <div id="seatContainer">
            
              <div class="row2d">
                <button id="CI_CompChair_4" class="btn2d">A1</button>
                  <button id="CI_CompChair_3"class="btn2d ">A2</button>
                  <button id="CI_CompChair_2"class="btn2d ">A3</button>
                  <button id="CI_CompChair_1"class="btn2d ">A4</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button id="CI_CompChair_5" class="btn2d opposite">A5</button>
                  <button id="CI_CompChair_6"class="btn2d opposite">A6</button>
                  <button id="CI_CompChair_7"class="btn2d opposite">A7</button>
                  <button id="CI_CompChair_8"class="btn2d opposite">A8</button>
              </div>
              <div class="divider2d"></div> 
          </div>
        <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                <button id="CG_CompChair_4" class="btn2d">A9</button>
                  <button id="CG_CompChair_3"class="btn2d ">A10</button>
                  <button id="CG_CompChair_2"class="btn2d ">A11</button>
                  <button id="CG_CompChair_1"class="btn2d ">A12</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button id="CH_CompChair_5" class="btn2d opposite">A13</button>
                  <button id="CH_CompChair_6"class="btn2d opposite">A14</button>
                  <button id="CH_CompChair_7"class="btn2d opposite">A15</button>
                  <button id="CH_CompChair_8"class="btn2d opposite">A16</button>
              </div>
              <div class="divider2d"></div> 
          </div><div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                  <button id="CG_CompChair_4" class="btn2d">A17</button>
                  <button id="CG_CompChair_3"class="btn2d ">A18</button>
                  <button id="CG_CompChair_2"class="btn2d ">A19</button>
                  <button id="CG_CompChair_1"class="btn2d ">A20</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button id="CG_CompChair_5" class="btn2d opposite">A21</button>
                  <button id="CG_CompChair_6"class="btn2d opposite">A22</button>
                  <button id="CG_CompChair_7"class="btn2d opposite">A23</button>
                  <button id="CG_CompChair_8"class="btn2d opposite">A24</button>
              </div>
              <div class="divider2d"></div> 
          </div></div>
        <div class="table2d">
          <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
              <button id="CF_CompChair_4" class="btn2d">A25</button>
                  <button id="CF_CompChair_3"class="btn2d ">A26</button>
                  <button id="CF_CompChair_2"class="btn2d ">A27</button>
                  <button id="CF_CompChair_1"class="btn2d ">A28</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button id="CF_CompChair_5" class="btn2d opposite">A29</button>
                  <button id="CF_CompChair_6"class="btn2d opposite">A30</button>
                  <button id="CF_CompChair_7"class="btn2d opposite">A31</button>
                  <button id="CF_CompChair_8"class="btn2d opposite">A32</button>
              </div>
              <div class="divider2d"></div> 
          </div>
        <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                  <button id="CE_CompChair_4" class="btn2d">A33</button>
                  <button id="CE_CompChair_3"class="btn2d ">A34</button>
                  <button id="CE_CompChair_2"class="btn2d ">A35</button>
                  <button id="CE_CompChair_1"class="btn2d ">A36</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button id="CE_CompChair_5" class="btn2d opposite">A37</button>
                  <button id="CE_CompChair_6"class="btn2d opposite">A38</button>
                  <button id="CE_CompChair_7"class="btn2d opposite">A39</button>
                  <button id="CE_CompChair_8"class="btn2d opposite">A40</button>
              </div>
              <div class="divider2d"></div> 
          </div><div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                <button id="CD_CompChair_4" class="btn2d">A41</button>
                  <button id="CD_CompChair_3"class="btn2d ">A42</button>
                  <button id="CD_CompChair_2"class="btn2d ">A43</button>
                  <button id="CD_CompChair_1"class="btn2d ">A44</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
              <button button id="CD_CompChair_5" class="btn2d opposite">A45</button>
                  <button id="CD_CompChair_6"class="btn2d opposite">A46</button>
                  <button id="CD_CompChair_7"class="btn2d opposite">A47</button>
                  <button id="CD_CompChair_8"class="btn2d opposite">A48</button>
              </div>
              <div class="divider2d"></div> 
          </div></div><div class="table2d">
          <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                  <button id="CC_CompChair_4" class="btn2d">A49</button>
                  <button id="CC_CompChair_3"class="btn2d ">A50</button>
                  <button id="CC_CompChair_2"class="btn2d ">A51</button>
                  <button id="CC_CompChair_1"class="btn2d ">A52</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
                  <button id="CC_CompChair_5" class="btn2d opposite">A53</button>
                  <button id="CC_CompChair_6"class="btn2d opposite">A54</button>
                  <button id="CC_CompChair_7"class="btn2d opposite">A55</button>
                  <button id="CC_CompChair_8"class="btn2d opposite">A56</button>
              </div>
              <div class="divider2d"></div> 
          </div>
        <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                <button id="CB_CompChair_4" class="btn2d">A57</button>
                  <button id="CB_CompChair_3"class="btn2d ">A58</button>
                  <button id="CB_CompChair_2"class="btn2d ">A59</button>
                  <button id="CB_CompChair_1"class="btn2d ">A60</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
                  <button id="CB_CompChair_5" class="btn2d opposite">A61</button>
                  <button id="CB_CompChair_6"class="btn2d opposite">A62</button>
                  <button id="CB_CompChair_7"class="btn2d opposite">A63</button>
                  <button id="CB_CompChair_8"class="btn2d opposite">A64</button>
              </div>
              <div class="divider2d"></div> 
          </div>
          <div id="seatContainer">
              <!-- <h3>SECTION A</h3> -->
              <div class="row2d">
                  <button id="CA_CompChair_4" class="btn2d">A65</button>
                  <button id="CA_CompChair_3"class="btn2d ">A66</button>
                  <button id="CA_CompChair_2"class="btn2d ">A67</button>
                  <button id="CA_CompChair_1"class="btn2d ">A68</button>
              </div>
              <div class="long-table2d"></div> 

              <div class="opposite-row2d">
                  <button id="CA_CompChair_5" class="btn2d opposite">A69</button>
                  <button id="CA_CompChair_6"class="btn2d opposite">A70</button>
                  <button id="CA_CompChair_7"class="btn2d opposite">A71</button>
                  <button id="CA_CompChair_8"class="btn2d opposite">A72</button>
              </div>
              <div class="divider2d"></div> 
          </div>
        </div>
      </div>

      <div class="topview2  text-center" style="display:none">
        <h4>Section B</h4>
      </div>

      <div class="topview3  text-center" style="display:none">
        <h4>Section C</h4>
      </div>

      <div class="topview4  text-center" style="display:none">
        <h4>Section D</h4>
      </div>
    </div>


    
    
    <form method="post" id="reservationForm">
        <div class="container2">
            <div class="dateTimeDiv">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="date">Select date and time</label>
                            <input type="text" class="form-control text-white bg-transparent d-none" name="date" id="date">                            
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
                    <button type="button" id="viewSeatsButton" class="btn btn-primary explore2 mt-3 w-100">Find Seats</button>
                    <button type="button" id="viewSeatsButton2" class="btn btn-secondary topviewBtn mt-2 w-100">Find Seats in 2D</button>
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
            inline: true,
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


// Get the current time
var currentTime = new Date();
var currentHour = currentTime.getHours();
var currentMinute = currentTime.getMinutes();

// Round the current time to the nearest 15-minute interval
var roundedMinute = Math.round(currentMinute / 15) * 15;
if (roundedMinute === 60) {
    currentHour += 1;
    roundedMinute = 0;
}

// Format the rounded current time as a string in HH:mm format
var currentTimeString = currentHour.toString().padStart(2, '0') + ':' + roundedMinute.toString().padStart(2, '0');

$('#start_time').timepicker({
    'timeFormat': 'h:i A',
    'minTime': currentTimeString,
    'maxTime': '<?php echo date('H:i A', strtotime($end_hour))?>',
    'step': 15,
    'forceRoundTime': true,
});




  $('#end_time').timepicker({
   
    // 'maxTime':
    'showDuration': true,
    'timeFormat': 'h:i A',
    'forceRoundTime': true,
  });

  $('#start_time').on('change', function () {
    var startTimeValue = $(this).val();
    
    // Check if start_time has a value and enable/disable end_time accordingly
    if (startTimeValue !== '') {
      $('#end_time').timepicker('option', 'minTime', startTimeValue);
      $('#end_time').prop('disabled', false);
    } else {
      // Clear end_time and disable it
      $('#end_time').val('');
      $('#end_time').prop('disabled', true);
    }
    
    validateTimeSelection();
  });

  $('#end_time').on('change', function () {
    validateTimeSelection();
  });

  $('#viewSeatsButton').prop('disabled', true);

  $('#helper').on('click', function () {
    $(this).hide();
  });

   // Function to hide the first option in the ui-timepicker-list class
   function hideFirstOption() {
    const $timepickerList = $('.ui-timepicker-list');
    $timepickerList.find('li:first').hide();
  }

  $('#end_time').on('showTimepicker', hideFirstOption);



 // Function to validate and disable the button if necessary
 function validateTimeSelection() {
    const startTime = $('#start_time').val();
    const endTime = $('#end_time').val();

    // Regular expression to match time in HH:MM AM/PM format
    const timeFormatPattern = /^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i;

    // Check if both start time and end time are empty
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
      $('#end_time').val('');
      $('#start_time').val('');
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

    <div id="helper"class="helper">
      <img src="img/drag.png" height="75px"></img>
      <p><b><br>Drag across the screen to view available seats.</b></p>
      <small><br><u>Click here to dismiss</u></small>
    </div>

    <div id="reserveDiv" class="reserveDiv" style="display: none;">
      <small>You Selected</small>
      <!-- <small class="btn btn-sm  text-white float-end" id="reserveDivClose">close</small> -->
      <h1><b></b></h1>
      <p></p>
      <p></p>
      <div class="col">
        <button id="reserveBtn" class="btn explore">Reserve Seat</button>
        <button class="btn text-white" id="reserveDivClose">Cancel</button>
      </div>
     
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
