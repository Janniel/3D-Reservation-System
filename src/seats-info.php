<?php
session_start();
require 'php/connect.php';
require 'php/session.php';
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!------------------------ Bootstrap 4 ------------------------>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <?php 
    // include 'php/libraries_admin.php'
     ?>

    <style>
        #btn-check {
            border: 1px solid #a81c1c !important;

        }

        .btn-check:checked+.btn,
        .btn.active {
            background: #a81c1c;
        }


        #selectSeatForm,
        #view-3d {
            height: 95vh !important;
        }

        body::before {
            content: "XS";
            color: red;
            font-size: 2rem;
            font-weight: bold;
            position: fixed;
            top: 0;
            right: 0;
        }

        model-viewer {
            width: 100%;
            height: 85vh !important;
        }


        /* This box class is purely used for explaining how the bootstrap grid system works. */
        @media (min-width: 576px) {
            body::before {
                content: "XS";
            }

        }

        @media (min-width: 768px) {
            body::before {
                content: "MD";
            }
        }

        @media (min-width: 992px) {
            body::before {
                content: "LG";
            }
        }

        .form-check-input {
            clear: left;
        }


        .form-switch.form-switch-md {
            margin-bottom: 1rem;
            /* JUST FOR STYLING PURPOSE */
        }

        .form-switch.form-switch-md .form-check-input {
            height: 1.5rem;
            width: calc(2rem + 0.75rem);
            border-radius: 3rem;
        }

        .form-check-input[type="checkbox"]:checked {
            background-color: #a81c1c;
            border: 1px solid #a81c1c;
        }

        .hidden {
            display: none;
        }

        .container-fluid {
            height: 100vh;
        }
    </style>
</head>


<body>

    <body onload="handleFormChange();">
        <?php if ($_SESSION['isSuperAdmin'] === 'no') {
            echo '<style type="text/css">
       .sidebar-menu #hidden{
           display: none;
       }
      </style>';
        }
        ; ?>

        <input type="checkbox" id="nav-toggle">
        <!------------------------ SIDEBAR ------------------------>
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="img/bulsu logo.png" alt="bulsu logo" class="logo">
                <h2> <span>SOAR Admin</span></h2>
            </div>

            <div class="sidebar-menu" id="tabButton">
                <ul>
                    <li class="tabs"> <a href="admin.php" data-tabName="dashboard" 
                            id="tabButtons"><span class="las la-th-large"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="tabs"> <a href="seats-info.php" class="active"><span class="las la-check"></span>
                            <span>Seats Information</span></a>
                    </li>
                    <li class="tabs"> <a href="php/reserved.php"><span class="las la-clock"></span>
                            <span>Reserved</span></a>
                    </li>
                    <li class="tabs"> <a href="php/user-list.php"><span class="las la-user-friends"></span>
                            <span>User List</span></a>
                    </li>
                    <li class="tabs"> <a href="php/history.php"><span class="las la-history"></span>
                            <span>History</span></a>
                    </li>
                    <li class="tabs"> <a href="php/adminReviews.php"><span class="las la-star"></span>
                            <span>Reviews</span></a>
                    </li>
                    <li class="tabs"> <a href="php/analytics.php"><span class="las la-chart-bar"></span>
                            <span>Analytics</span></a>
                    </li>
                    <li class="tabs"> <a href="php/settings.php"><span class="las la-cog"></span>
                            <span>Settings</span></a>
                    </li>
                    <li id="hidden" class="manage tabs" data-toggle="modal" data-target="#exampleModal"> <a
                            href="php/manageAdmin.php"><span class="las la-users-cog"></span>
                            <span>Manage Accounts</span></a>
                    </li>
                    <li class="logout"> <a href="toLogout.php">
                            <span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!------------------------ END OF SIDEBAR ------------------------>
        </input>

        <!------------------------ HEADER ------------------------>
        <div class="header">
            <header>
                <h2>
                    <label for="nav-toggle">
                        <div class="toggle">
                            <span class="la la-bars"></span>
                        </div>
                    </label>
                    Seats Information
                </h2>

                <div class="dropdown">
                    <button class="dropdown-toggle" class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <div class="user-wrapper">
                            <img src="<?php if ($_SESSION['gender'] == "Male") {
                                echo "https://cdn-icons-png.flaticon.com/512/2552/2552801.png";
                            } elseif ($_SESSION['gender'] == "Female") {
                                echo "https://cdn-icons-png.flaticon.com/512/206/206864.png";
                            } ?>" alt="Admin" class="rounded-circle p-1 bg-secondary" width="45">
                            <div id="user_admin">
                                <h4>
                                    <?php echo $_SESSION["username"]; ?>
                                </h4>
                            </div>
                        </div>
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="php/adminProfile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="toLogout.php">Logout</a></li>
                    </div>
                </div>
            </header>
        </div>
        <!------------------------ END OF HEADER ------------------------>

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


    
    <div class="section-nav d-none">
      <div class="dateTimeSelected d-none">
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
                            <h1 for="date">View Seats Information</h1>
                            <input type="text" class="form-control text-white bg-transparent d-none" name="date" id="date">                            
                        </div>
                    </div>
                </div>

                <div class="row d-none">
                    <div class="col">
                        <div class="form-group">
                            <label for="start_time"></label>
                            <input type="text" class="form-control  text-white bg-transparent d-none" name="start_time" id="start_time" placeholder="Starts from" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="end_time"></label>
                            <input type="text" class="form-control text-white bg-transparent d-none" name="end_time" id="end_time" placeholder="Ends at ">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                    <button type="button" id="viewSeatsButton" class="btn btn-danger explore2 mt-3 w-100">Manage Seats</button>
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
      <p><b>Drag across the screen to view available seats.</b></p>
      <small>Dismiss</small>
    </div>

    <div id="reserveDiv" class="reserveDiv" style="display: none;">
      <small>You Selected</small>
      <!-- <small class="btn btn-sm  text-white float-end" id="reserveDivClose">close</small> -->
      <h1><b></b></h1>
      <p></p>
      <p></p>
      <div class="col">
      <button id="reserveBtn" class="btn btn-danger explore" >Select Seat</button>
<button id="fixBtn" class="btn btn-success explore">Select Seat</button>

        <button class="btn text-white" id="reserveDivClose">Cancel</button>
      </div>
     
    </div>


  </div>


    </body>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js'></script>

</html>