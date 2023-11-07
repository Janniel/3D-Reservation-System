<?php
session_start();
require 'connect.php';
require 'session.php';


// Initialize variables
$settingsUpdated = false;

// Update the settings in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation = $_POST['customRadio'];
    $minDuration = $_POST['min_duration'];
    $maxDuration = $_POST['max_duration'];
    $reservePerDay = $_POST['reserve_per_day'];
    $start_hour = $_POST['start_hour'];
    $end_hour = $_POST['end_hour'];

   $sql = "UPDATE `settings` SET `reservation` = '$reservation', `start_hour` = '$start_hour', `end_hour` = '$end_hour', `minDuration` = '$minDuration', `maxDuration` = '$maxDuration', `reservePerDay` = '$reservePerDay' WHERE `settings_id` = 1";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $settingsUpdated = true;
        // Display SweetAlert2 success message
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Settings Updated",
                text: "The settings have been updated successfully.",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "settings.php"; // Redirect to settings page
                }
            });
        </script>';
    } else {
        echo "Error updating settings: " . mysqli_error($conn);
    }
}

// Retrieve the data from the settings table
$sql = "SELECT * FROM `settings` WHERE `settings_id` = 1";
$result = mysqli_query($conn, $sql);

// Rest of your code...
?>

<!DOCTYPE HTML>
<html>
<!--  SweetAlert2 CSS and JS files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>


<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!------------------------ Bootstrap 4 ------------------------>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="assets/css/analytics.css" />

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<style>
    /* Custom CSS to change flatpickr selection color to gray and add 'x' text */
.flatpickr-day.selected, .flatpickr-day.selected:focus {
    background: lightgray !important;
    color: #fff;
    outline: 1px solid lightgray !important;
    border: 1px solid lightgray !important;
}


</style>


<body>
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
            <img src="../img/bulsu logo.png" alt="bulsu logo" class="logo">
            <h2> <span>SOAR Admin</span></h2>
        </div>

        <div class="sidebar-menu" id="tabButton">
            <ul>
                <li class="tabs"> <a href="../admin.php" data-tabName="dashboard" id="tabButtons"><span
                            class="las la-th-large"></span>
                        <span>Dashboard</span></a>
                </li>
                <li class="tabs"> <a href="../seats-info.php"><span class="las la-check"></span>
                        <span>Seats Information</span></a>
                </li>
                <li class="tabs"> <a href="reserved.php"><span class="las la-clock"></span>
                        <span>Reserved</span></a>
                </li>
                <li class="tabs"> <a href="user-list.php"><span class="las la-user-friends"></span>
                        <span>User List</span></a>
                </li>
                <li class="tabs"> <a href="history.php"><span class="las la-history"></span>
                        <span>History</span></a>
                </li>
                <li class="tabs"> <a href="adminReviews.php"><span class="las la-star"></span>
                        <span>Reviews</span></a>
                </li>
                <li class="tabs"> <a href="analytics.php"><span class="las la-chart-bar"></span>
                        <span>Analytics</span></a>
                </li>
                <li class="tabs"> <a href="settings.php" class="active"><span class="las la-cog"></span>
                        <span>Settings</span></a>
                </li>
                <li id="hidden" class="manage tabs" data-toggle="modal" data-target="#exampleModal"> <a
                        href="manageAdmin.php"><span class="las la-users-cog"></span>
                        <span>Manage Accounts</span></a>
                </li>
                <li class="logout"> <a href="../toLogout.php">
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
                Settings
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
                    <li><a class="dropdown-item" href="adminProfile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="../toLogout.php">Logout</a></li>
                </div>
            </div>
        </header>
    </div>
    <!------------------------ END OF HEADER ------------------------>


    <div class="main-content">

        <?php
        // Assuming you have established a database connection
        
        // Retrieve the data from the settings table
        $sql = "SELECT * FROM `settings` WHERE `settings_id` = 1";
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful and fetch the row of data
        if ($result && mysqli_num_rows($result) > 0) {
            $settings = mysqli_fetch_assoc($result);
        } else {
            echo "Error retrieving settings: " . mysqli_error($conn);
        }

        $sql2 = "SELECT * FROM `settings` WHERE `settings_id` = 1";
        // Execute the query
        $result2 = mysqli_query($conn, $sql2);

        if ($result2) {
            // Fetch the row
            $row2 = mysqli_fetch_assoc($result2);

            // Parse the JSON data to get an array of disabled dates
            $disabledDates = json_decode($row2['disabled_dates']);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

    

        <main>
        <div class="container mt-4">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="reservation-tab" data-toggle="tab" href="#reservation" role="tab" aria-controls="reservation" aria-selected="true">Reservation Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="modify-dates-tab" data-toggle="tab" href="#modify-dates" role="tab" aria-controls="modify-dates" aria-selected="false">Modify Dates</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="reservation" role="tabpanel" aria-labelledby="reservation-tab">
      
     
      <div class="container mt-4">
                
                <br>
                <form id="settings-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <!-- Enable Reservation -->
                    <div class="form-group row">
                        <label for="enableReservation" class="col-sm-2 col-form-label">Maintenance Mode</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input"
                                    value="1" <?php if ($settings['reservation'] == 1)
                                        echo 'checked'; ?>>
                                <label class="custom-control-label" for="customRadio1">Enable</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input"
                                    value="0" <?php if ($settings['reservation'] == 0)
                                        echo 'checked'; ?>>
                                <label class="custom-control-label" for="customRadio2">Disable</label>
                            </div>
                        </div>
                    </div>

                    <!-- Min duration -->
                    <div class="form-group row">
                        <label for="min_duration" class="col-sm-2 col-form-label">Min duration</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="min_duration" name="min_duration"
                                value="<?php echo $settings['minDuration']; ?>">
                            <small class="form-text text-muted">Enter the minimum duration in hours</small>
                        </div>
                    </div>

                    <!-- Max duration -->
                    <div class="form-group row">
                        <label for="max_duration" class="col-sm-2 col-form-label">Max duration</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="max_duration" name="max_duration"
                                value="<?php echo $settings['maxDuration']; ?>">
                            <small class="form-text text-muted">Enter the maximum duration in hours</small>
                        </div>
                    </div>

                    <!-- Reserve per day -->
                    <div class="form-group row">
                        <label for="reserve_per_day" class="col-sm-2 col-form-label">Reserve per day</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="reserve_per_day" name="reserve_per_day"
                                value="<?php echo $settings['reservePerDay']; ?>">
                        </div>
                    </div>

                    <!-- reservation hours -->
                    <div class="form-group row">
                        <label for="start_hour" class="col-sm-2 col-form-label">Reservation hours</label>
                        <div class="col-sm">
                            <input type="time" class="form-control" id="start_hour" name="start_hour"
                                value="<?php echo $settings['start_hour']; ?>">
                        </div>
                      
                        <div class="col-sm">
                            <input type="time" class="form-control" id="end_hour" name="end_hour"
                                value="<?php echo $settings['end_hour']; ?>">
                        </div>
                    </div>


             


                   


                    <button type="submit" class="btn btn-danger" name="apply" id="applyButton" disabled>Apply
                        Changes</button>
                </form>
            </div>
      </form>
    </div>

    <!-- second tab -->
    <div class="tab-pane fade" id="modify-dates" role="tabpanel" aria-labelledby="modify-dates-tab">
    <div class="container m-4">
           
    <form action="update_disabled_dates.php" method="post">
        <!-- Disabled Dates -->
        <div class="form-group row">
            <label for="disabled_dates" class="col-sm-2 col-form-label">Disabled Dates</label>
            <div class="col-sm-10">
                <input type="text" id="disabled_dates" class="form-control d-none" name="disabled_dates" required="required">
                <small class="form-text text-muted">Select multiple dates to be restrict on the reservation</small>
            </div>
        </div>
        <script>
  // Assuming $disabledDates is the array of disabled dates obtained from PHP
  var disabledDates = <?php echo json_encode($disabledDates); ?>;

  var input = document.getElementById('disabled_dates');

  var formattedDates = disabledDates.map(function (date) {
    return new Date(date).toISOString().split('T')[0];
  });

  input.value = JSON.stringify(formattedDates);

  flatpickr("#disabled_dates", {
  mode: "multiple",
  dateFormat: "Y-m-d",
  inline: true,
  defaultDate: formattedDates,
  onChange: function (selectedDates, dateStr, instance) {
    var formattedSelectedDates = selectedDates.map(function(date) {
      // Adjust date to UTC
      var utcDate = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
      return utcDate.toISOString().split('T')[0];
    });
    document.getElementById('disabled_dates').value = JSON.stringify(formattedSelectedDates);
  }
});
  // Submit form using AJAX when the button is clicked
  $('form').on('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    var formData = $(this).serialize(); // Serialize form data

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'), // Get the form action URL
      data: formData,
      success: function (response) {
        // Handle successful response
        console.log('Form submitted successfully.', response);
        // Show SweetAlert2 success alert
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Date restricted successfully!',
          confirmButtonColor: 'darkred',
          
        });
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error('Form submission failed. Status: ' + status + ', Error: ' + error);
        Swal.fire({
          icon: 'error',
          title: 'error',
          text: 'Date restricted unsucessful!',
        });
      }
    });
  });
</script>

        <button type="submit" class="btn btn-danger">Apply</button>
    </form>
</div>

      </form>
    </div>
  </div>
</div>
            
<br>
<br>
<br>

          
            
        </main>









    </div>




</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js
"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

<!-- AJAX script -->
<script>
$(document).ready(function () {
    const settingsForm = $("#settings-form");
    const applyButton = $("#applyButton");
    

    // Store the initial values of the form fields
        const initialValues = {
        customRadio: <?php echo $settings['reservation']; ?>,
        min_duration: <?php echo $settings['minDuration']; ?>,
        max_duration: <?php echo $settings['maxDuration']; ?>,
        reserve_per_day: <?php echo $settings['reservePerDay']; ?>,
        start_hour: "<?php echo $settings['start_hour']; ?>",
        end_hour: "<?php echo $settings['end_hour']; ?>",
        
        
    };


    // Function to check if any changes have been made
    function hasChanges() {
    const currentValues = {
        customRadio: parseInt(settingsForm.find("input[name='customRadio']:checked").val()),
        min_duration: parseInt(settingsForm.find("#min_duration").val()),
        max_duration: parseInt(settingsForm.find("#max_duration").val()),
        reserve_per_day: parseInt(settingsForm.find("#reserve_per_day").val()),
        start_hour: settingsForm.find("input[name='start_hour']").val(),
        end_hour: settingsForm.find("input[name='end_hour']").val(),
       
    };

    return JSON.stringify(currentValues) !== JSON.stringify(initialValues);
}


    // Check if there are changes on form input
    settingsForm.on("input", function () {
        applyButton.prop("disabled", !hasChanges());
    });

    settingsForm.on("submit", function (event) {
        if (!hasChanges()) {
            event.preventDefault();
            return;
        }

        event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: "settings.php",
                method: "POST",
                data: settingsForm.serialize(),
                success: function (responseText) {
                    Swal.fire({
                        icon: "success",
                        title: "Settings Updated",
                        text: "The settings have been updated successfully.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            window.location.href = "settings.php"; // Redirect to settings page
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    });
</script>


<!-- <script src="assets/js/analytics.js"></script> -->


</html>