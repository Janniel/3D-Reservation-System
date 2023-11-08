<?php
session_start();
require 'php/connect.php';
require 'php/session.php';
require 'php/validateReservation.php';




$query123 = "SELECT occupy.*, seat.seat_number, reservation.start_time, reservation.end_time 
          FROM occupy 
          INNER JOIN reservation ON occupy.reservation_id = reservation.reservation_id 
          INNER JOIN seat ON reservation.seat_id = seat.seat_id
          WHERE reservation.user_id = '{$_SESSION['user_id']}' 
          AND reservation.date = CURDATE() 
          AND occupy.isDone = 0";

$result123 = mysqli_query($conn, $query123);

if (mysqli_num_rows($result123) == 1) {
    // If the query returns exactly one result, require the specified file
    require 'php/occupancy_timer.php';
}

// Rest of your code here
?>






<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>

    <!------------------------ Bootstrap 5.3.0 ------------------------>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <!------------------------ CSS Link ------------------------>
    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <!-- animation on scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>




</head>
<style>
    .nav-pills .nav-link {
        outline: none !important;
        border: none !important;
    }

    .nav-pills .nav-link.active {

        background-color: #a81c1c;
    }
</style>


<body>

    <script>
        AOS.init();
    </script>
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




    <!------------------------ HEADER --------------------->

    <header class="header-outer">
        <div class="header-inner responsive-wrapper">
            <div class="header-logo">
                <img src="../src/img/elib logo.png" class="icon">
            </div>
            <nav class="header-navigation">
                <a href="index.php">HOME</a>
                <a href="index.php#aboutus">ABOUT US</a>
                <a href="reserve.php">RESERVE SEAT</a>
                <a id="hidden" href="occupy.php">OCCUPY SEAT</a>

                <a class="active" id="hidden" href="profile.php">ACCOUNT</a>
                <a id="hidden" href="toLogout.php">LOGOUT</a>
                <!-- <a id="show" href="login.php" >LOGIN</a> -->
            </nav>
        </div>
    </header>

    <!------------------------ END HEADER --------------------->
    <?php
    // Retrieve the username from the session
    $username = $_SESSION["username"];

    // Retrieve the user details from the database
    $sql = "SELECT * FROM ACCOUNT
        INNER JOIN USERS ON ACCOUNT.account_id = USERS.account_id
        WHERE ACCOUNT.username = '$username'";

    $result = $conn->query($sql);

    // Check if a matching record is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // $email = $row["email"];
        // $year = $row["year_level"];
        // Populate the HTML template with the fetched data
    } else {
        // Handle the case when no matching record is found
        echo "You are not regular student. Either alumni or faculty";
    }
    ?>

    <div class="container pt-4 ">
        <div class="">
            <div class="row ">
                <div class="col-lg-3 bg-white rounded-4 d-block p-2 m-2 shadow">
                    <div class="p-4">
                        <div class="img-circle text-center">
                            <?php
                            if ($row['picture'] === NULL) {
                                echo '<img src="https://cdn.icon-icons.com/icons2/2550/PNG/512/user_circle_icon_152504.png" alt="Default Image">';
                            } else {
                                echo '<img src="' . $row['picture'] . '" alt="Profile Image">';
                            }
                            ?>
                        </div>
                        <div>
                            <?php
                            // Retrieve the username from the session
                            $username = $_SESSION["username"];

                            // Retrieve the user details from the database
                            $sql = "SELECT *
                                FROM ACCOUNT
                                INNER JOIN USERS ON ACCOUNT.account_id = USERS.account_id
                                WHERE ACCOUNT.username = '$username';
                                ";

                            $result = $conn->query($sql);

                            // Check if a matching record is found
                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                ?>

                            <h4 class="text-center fw-bold">
                                <?= $row["first_name"] . ' ' . $row["last_name"] ?>
                            </h4>
                            <p class="text-center text-sm">
                                <?= $row["user_id"] ?>
                            </p>
                            <div class="text-start">
                                <h6><i class="fas fa-id-card p-2" style="color: gray"></i>
                                    <?php if ($row["rfid_no"] !== null) { ?>
                                    <?= $row["rfid_no"] ?>
                                    <?php } else { ?>
                                    <span style="color: gray;">Not Registered</span>
                                    <?php } ?>
                                </h6>
                                <h6><i class="fas fa-user p-2" style="color: gray"></i>
                                    <?= $row["username"] ?>
                                </h6>
                                <h6><i class="fas fa-envelope p-2" style="color: gray"></i>
                                    <?= $row["email"] ?>
                                </h6>
                                <h6><i class="fas fa-birthday-cake p-2" style="color: gray"></i>
                                    <?php if ($row["age"] !== null) { ?>
                                    <?= $row["age"] ?>
                                    <?php } else { ?>
                                    <span style="color: gray;">Not Set</span>
                                    <?php } ?>
                                </h6>
                                <h6><i class="fas fa-venus-mars p-2" style="color: gray"></i>
                                    <?php if ($row["gender"] !== null) { ?>
                                    <?= $row["gender"] ?>
                                    <?php } else { ?>
                                    <span style="color: gray;">Not Set</span>
                                    <?php } ?>
                                </h6>
                            </div>
                            <div class="edit-info">
                                <a href="update_profile.php" class="btn btn-outline-danger w-100"><i
                                        class="las la-user-edit"></i>Edit Details</a>
                            </div>
                        </div>

                        <?php
                            }
                            ?>
                    </div>


                </div>

                <div class="col-lg-8 rounded-3 d-block p-2 m-2 ">

                    <h5>

                        <?php
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

                        // echo "<span>{$reservation_count} out of {$reservePerDay}</span>";
                        ?>
                    </h5>

                    <!-- <h5 class="pt-3 text-black-50">In Progress</h5> -->
                    <div class="container">

                        <?php
                        $query = "SELECT * FROM occupy WHERE user_id = '{$_SESSION['user_id']}' AND isDone = 0";
                        $result = mysqli_query($conn, $query);


                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $seat_id = $row['seat_id'];
                                $reservation_id = $row['reservation_id'];
                                $date = date('F j, Y', strtotime($row['date'])); // Convert date to desired format
                                $start_time = date('h:i A', strtotime($row['start_time'])); // Convert start time to AM/PM format
                        

                                // Retrieve additional information related to the reservation, such as seat details
                                $seat_query = "SELECT * FROM seat WHERE seat_id = '$seat_id'";
                                $seat_result = mysqli_query($conn, $seat_query);
                                $seat_row = mysqli_fetch_assoc($seat_result);
                                $seat_number = $seat_row['seat_name'];

                                $query1 = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
                                $result1 = mysqli_query($conn, $query1);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        $end_time = date('h:i A', strtotime($row1['end_time'])); // Convert end time to AM/PM format
                                    }
                                }
                            }

                            // Display the pending reservation information
                        
                            echo "<div class='row rounded-3 border border-1 shadow bg-white p-3' ><div class='col-lg-4 text-center rounded-3'>";
                            echo "<p class=' small fw-light text-start  '>6th Floor</p>";

                            echo "<h1 class='fw-bold text-muted text-start '>Seat {$seat_number}</h1><p class='text-muted text-start'>Reservation ID: $reservation_id</p></div>";

                            echo "<div class='col-lg-4  bg-white'><p><i class='far fa-clock  fa-light' style='color: #d6d6d6'></i> {$start_time} - {$end_time}<br>";
                            echo "<p><i class='far fa-calendar-alt fa-lg ' style='color: #d6d6d6'></i> {$date}</p>";


                            //   echo "<div class='row shadow  mt-2  rounded-3' style='background: rgb(215,94,94);
                            //   background: linear-gradient(223deg, rgba(215,94,94,1) 0%, rgba(132,0,0,1) 100%);'>";
                            //   echo "<div class='col-lg-4  text-center p-3 text-white'>";
                            //   echo "<p class='text-white  small fw-light text-start  '>6th Floor</p>";
                            //   echo "<h1 class='fw-bold  text-start'>Seat {$seat_number}</h1>";
                            //   echo "<p class='text-white text-start'>Reservation ID: $reservation_id</p>";
                        
                            //   echo "</div>";
                        




                            // Check if the reservation_id exists in the history table
                            $sql_check_history = "SELECT COUNT(*) AS history_count FROM history WHERE reservation_id = $reservation_id";
                            $result_check_history = $conn->query($sql_check_history);

                            // Check if the reservation_id exists in the occupy table
                            $sql_check_occupy = "SELECT COUNT(*) AS occupy_count FROM occupy WHERE reservation_id = $reservation_id";
                            $result_check_occupy = $conn->query($sql_check_occupy);

                            if ($result_check_occupy && $result_check_history) {
                                $row_check_history = $result_check_history->fetch_assoc();
                                $history_count = $row_check_history['history_count'];

                                $row_check_occupy = $result_check_occupy->fetch_assoc();
                                $occupy_count = $row_check_occupy['occupy_count'];

                                if ($occupy_count > 0) {
                                    echo "<p><i class='far fa-circle-check fa-lg ' style='color: #d6d6d6'></i>";
                                    echo "<span class='badge rounded-pill bg-warning text-light'>In Progress </span></div>";
                                }
                                // If not found in history or occupy table, display the Delete button
                                else {
                                    echo "<a href='#' class='btn text-warning btn-sm' onclick='confirmDelete({$row['reservation_id']}); return false;'>Cancel</a></div>";
                                }
                            } else {
                                // Handle SQL error if needed
                                echo "Error: " . $conn->error;
                            }
                            // Add View Details button
                            echo "<div class='col-lg-4    bg-white p-1 text-center'>";
                            echo "<small>Ends in: </small><h3 class='fw-bold text-muted text-center' id='remainingTimeDisplay'>Loading</h3>";
                            echo "<a href='php/timer.php' class='btn btn-warning btn w-100 text-center text-white '>View Timer</a></div>";




                        }
                        ?>
                    </div>

                    <script>
                        $(document).ready(function () {
                            var timerInterval;

                            function updateRemainingTime() {
                                var currentTime = new Date().getTime();
                                var remainingTime = Math.max(0, <?php echo $end_time_milliseconds; ?> - currentTime);

                                var minutes = Math.floor(remainingTime / (1000 * 60));
                                var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                                var remainingTimeString = minutes + 'm ' + seconds + 's';

                                // Update the <p> element with the remaining time
                                $('#remainingTimeDisplay').text(remainingTimeString);


                            }

                            // Set the timer interval
                            timerInterval = setInterval(updateRemainingTime, 1000);
                        });

                    </script>


                    <div class="container">
                        <ul class="nav nav-tabs pt-4 pb-4" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a id="navss" class="nav-link active text-black p-3" id="pending-tab"
                                    data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending"
                                    aria-selected="true">My Reservations</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a id="navss" class="nav-link text-black p-3" id="history-tab" data-bs-toggle="tab"
                                    href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
                            </li>
                        </ul>


                        <div class="tab-content" id="myTabsContent">
                            <div class="tab-pane fade show active" id="pending" role="tabpanel"
                                aria-labelledby="pending-tab">
                                <div class="">
                                    <?php
                                    $query = "SELECT * FROM reservation WHERE user_id = '{$_SESSION['user_id']}' AND date >= CURDATE() AND isDone = 0";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {


                                            $seat_id = $row['seat_id'];
                                            $reservation_id = $row['reservation_id'];
                                            $date = date('F j, Y', strtotime($row['date']));
                                            $start_time = date('h:i A', strtotime($row['start_time']));
                                            $end_time = date('h:i A', strtotime($row['end_time']));

                                            // Retrieve additional information related to the reservation, such as seat details
                                            $seat_query = "SELECT * FROM seat WHERE seat_id = '$seat_id'";
                                            $seat_result = mysqli_query($conn, $seat_query);
                                            $seat_row = mysqli_fetch_assoc($seat_result);
                                            $seat_number = $seat_row['seat_name'];



                                            // Check if the reservation_id exists in the occupy table
                                            $checkOccupancy = "SELECT * FROM occupy WHERE reservation_id = $reservation_id";
                                            $result_checkOccupancyy = $conn->query($checkOccupancy);


                                            // Check if the reservation_id exists in the history table
                                            $sql_check_history = "SELECT COUNT(*) AS history_count FROM history WHERE reservation_id = $reservation_id";
                                            $result_check_history = $conn->query($sql_check_history);

                                            // Check if the reservation_id exists in the occupy table
                                            $sql_check_occupy = "SELECT COUNT(*) AS occupy_count FROM occupy WHERE reservation_id = $reservation_id";
                                            $result_check_occupy = $conn->query($sql_check_occupy);



                                            echo "<div data-aos='fade-up'  data-aos-duration='300'  class='row  border border-1 shadow  mt-2  rounded-3' style='background: rgb(215,94,94);
                                            background: linear-gradient(223deg, rgba(215,94,94,1) 0%, rgba(132,0,0,1) 100%);'>";
                                            echo "<div class='col-lg-4  text-center p-3 text-white'>";
                                            echo "<p class='text-white  small fw-light text-start  '>6th Floor</p>";
                                            echo "<h1 class='fw-bold  text-start'>Seat {$seat_number}</h1>";
                                            echo "<p class='text-white text-start'>Reservation ID: $reservation_id</p>";

                                            echo "</div>";

                                            echo "<div class='col-lg-4 p-3  bg-white' ><div class=' m-2'> ";
                                            echo "<p><i class='far fa-clock fa-light  m-1 ' style='color:lightgray'></i> {$start_time} - {$end_time}<br>";
                                            echo "<p><i class='far fa-calendar-alt fa-lg  m-1' style='color:lightgray' ></i> {$date}</p>";
                                            echo "<p><i class='far fa-circle-check fa-lg  m-1' style='color:lightgray'></i>";

                                            if (mysqli_num_rows($result_checkOccupancyy) > 0) {

                                                // replace this query using ajax 
                                            }


                                            if ($result_check_occupy && $result_check_history) {
                                                $row_check_history = $result_check_history->fetch_assoc();
                                                $history_count = $row_check_history['history_count'];

                                                $row_check_occupy = $result_check_occupy->fetch_assoc();
                                                $occupy_count = $row_check_occupy['occupy_count'];

                                                if ($history_count > 0) {
                                                    echo "<span class='badge rounded-pill text-bg-success m-1'>Completed</span></div></div>";
                                                } elseif ($occupy_count > 0) {
                                                    echo "<span class='badge rounded-pill bg-warning text-light  m-1'>In Progress </span></div></div>";
                                                } else {
                                                    echo "<span class='badge rounded-pill bg-danger text-light  m-1'>Pending</span></div></div>";
                                                }
                                            } else {
                                                echo "Error: " . $conn->error;
                                            }

                                            echo "<div class='col-lg-4 bg-white d-flex align-items-center justify-content-center'>";
                                            echo "<div class='text-center w-100'><a href='#' class='btn text-danger btn-m' onclick='confirmDelete({$row['reservation_id']}); return false;'>Cancel </a><a href='receipt.php?reservation_id={$row['reservation_id']}' class='btn btn-danger ' style='background-color:#a81c1c;'>View Details&nbsp&nbsp&nbsp<i class='fa-solid fa-arrow-right'></i></a></div>";

                                            echo "</div>";
                                            echo "</div>";


                                        }
                                    } else {
                                        echo "<div class='bg-light text-center text-muted pt-5'> <h1 class='display-1'> <i class='las la-frown'></i> </h1><br><h4 class='fw-bold '> No Reservation Found</h4><p>  It seems like you don't have any reservation yet.. </p><a class='btn  btn-danger' style='background-color: #a81c1c' href='reserve.php'>Reserve Seat </a></div>";
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="tab-content" id="myTabsContent">
                            <div class="tab-pane fade " id="history" role="tabpanel" aria-labelledby="history-tab">
                                <div class="">
                                    <?php
                                    $query = "SELECT * FROM history WHERE user_id = '{$_SESSION['user_id']}'  ORDER BY history_id DESC;";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $seat_id = $row['seat_id'];
                                            $start_time_cancel = $row['start_time'];
                                            $time_spent_cancel = $row['time_spent'];
                                            $reservation_id = $row['reservation_id'];
                                            $date = date('F j, Y', strtotime($row['date']));
                                            $start_time = date('h:i A', strtotime($row['start_time']));
                                            $end_time = date('h:i A', strtotime($row['end_time']));

                                            // Calculate the time spent in hours, minutes, and seconds
                                            $start_timestamp = strtotime($row['start_time']);
                                            $end_timestamp = strtotime($row['end_time']);
                                            $time_spent_seconds = $end_timestamp - $start_timestamp;
                                            $time_spent_hours = floor($time_spent_seconds / 3600); // Calculate hours
                                            $time_spent_seconds %= 3600; // Remaining seconds after calculating hours
                                            $time_spent_minutes = floor($time_spent_seconds / 60); // Calculate minutes
                                            $remaining_seconds = $time_spent_seconds % 60; // Calculate remaining seconds
                                    

                                            $start_time_reservation = "";
                                            $end_time_reservation = "";

                                            $time_spent_formatted = "";

                                            // Retrieve additional information related to the reservation, such as seat details
                                            $seat_query = "SELECT * FROM seat WHERE seat_id = '$seat_id'";
                                            $seat_result = mysqli_query($conn, $seat_query);
                                            $seat_row = mysqli_fetch_assoc($seat_result);
                                            $seat_number = $seat_row['seat_name'];


                                            if ($start_time_cancel && $time_spent_cancel == '00:00:00') {
                                                $badgeText = 'Cancelled';
                                                $badgeClass = 'text-bg-secondary';
                                                $timeSpentDisplay = "";
                                                $bg_status = 'background: linear-gradient(223deg, #ffffff 0%, #6c757d 100%)';

                                                $start_time_query = "SELECT * FROM reservation WHERE reservation_id = '$reservation_id'";
                                                $start_time_query_result = mysqli_query($conn, $start_time_query);
                                                $start_time_row = mysqli_fetch_assoc($start_time_query_result);
                                                $start_time_reservation = date('H:i A', strtotime($start_time_row['start_time']));
                                                $end_time_reservation = date('H:i A', strtotime($start_time_row['end_time']));

                                                $the_time = "<p><i class='far fa-clock fa-light m-1' style='color: lightgray'></i> $start_time_reservation - $end_time_reservation<br>";

                                            } else {
                                                $badgeText = 'Completed';
                                                $badgeClass = 'text-bg-success';
                                                $bg_status = 'background: linear-gradient(223deg, #00ff77 0%, #198754 100%);';
                                                $start_time_fetch = $start_time;
                                                if ($time_spent_hours > 0) {
                                                    $time_spent_formatted .= "{$time_spent_hours}hr ";
                                                }

                                                if ($time_spent_minutes > 0) {
                                                    $time_spent_formatted .= "{$time_spent_minutes}min ";
                                                }

                                                if ($remaining_seconds > 0) {
                                                    $time_spent_formatted .= "{$remaining_seconds}s";
                                                }
                                                $timeSpentDisplay = "<p><i class='far fa-clock fa-light  m-1 ' style='color:lightgray'></i> {$time_spent_formatted}<br>";
                                                $the_time = "<p><i class='far fa-clock fa-light m-1' style='color: lightgray'></i> $start_time - $end_time<br>";

                                            }

                                            echo "<div class='row border border-1 shadow mt-2 rounded-3' style='$bg_status'>";
                                            echo "<div class='col-lg-4 text-center p-3 text-white'>";
                                            echo "<p class='text-white small fw-light text-start'>6th Floor</p>";
                                            echo "<h1 class='fw-bold text-start'>Seat $seat_number</h1>";
                                            echo "<p class='text-white text-start'>Reservation ID: $reservation_id</p></div>";

                                            echo "<div class='col-lg-4 p-3 bg-white'><div class='m-2'>";
                                            echo $the_time;
                                            echo "<p><i class='far fa-calendar-alt fa-lg m-1' style='color: lightgray'></i> $date</p>";
                                            echo "<p><i class='far fa-circle-check fa-lg m-1' style='color: lightgray'></i><span class='badge rounded-pill $badgeClass m-1'>$badgeText</span>";


                                            echo $timeSpentDisplay;

                                            echo '</div></div>';


                                            echo "<div class='col-lg-4 bg-white d-flex align-items-center justify-content-center'>";
                                            echo "<div class='text-center w-100'></div>";
                                            echo "</div>";
                                            echo "</div>";

                                            // echo "<div class='row shadow bg-white mt-2 p-3 rounded-3 border border-start'>";
                                            // echo "<div class='col'>";
                                            // echo "<h1 class='fw-bold text-center'>Seat {$seat_number}</h1>";
                                            // echo "<p class=' text-danger text-center'>Reservation ID: $reservation_id</p>";
                                            // echo "</div>";
                                    
                                            // echo "<div class='col'>";
                                            // echo "<p><i class='far fa-clock fa-light' style='color: #d6d6d6'></i> {$start_time} - {$end_time}<br>";
                                            // echo "<p><i class='far fa-calendar-alt fa-lg' style='color: #d6d6d6'></i> {$date}</p>";
                                            // echo "<p><i class='far fa-circle-check fa-lg' style='color: #d6d6d6'></i>";
                                            // echo "<span class='badge rounded-pill text-bg-success'>Completed</span></div>";
                                    
                                            // echo "<div class='col'></div>";
                                            // echo "<div class='col-lg-2 text-center w-100'>";
                                            // echo "<a href='receipt.php?reservation_id={$row['reservation_id']}' class='btn btn-danger w-100 btn text-center'>View Details</a>";
                                            // echo "</div>";
                                            // echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='bg-light text-center text-muted pt-5'> <h1 class='display-1'> <i class='las la-frown'></i> </h1><br><h4 class='fw-bold '> No History Found</h4><p>  It seems like you don't have any reservation yet.. </p><a class='btn  btn-danger' style='background-color: #a81c1c' href='reserve.php'>Reserve Seat </a></div>";
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>




            </div>

        </div>
    </div>









    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(reservationId) {
            Swal.fire({
                title: 'Cancel reservation?',
                text: 'You will not be able to recover this reservation!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#a81c1c",
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                cancelButtonColor: '#d3d3d3',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with the deletion via AJAX
                    $.ajax({
                        url: `php/toCancelReservation.php?reservation_id=${reservationId}`,
                        type: 'GET',
                        success: function (response) {
                            if (response === "Success") {
                                // Deletion was successful, show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The reservation has been deleted.',
                                    icon: 'success',
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        // Redirect to profile.php or perform other actions
                                        window.location.href = 'profile.php';
                                    }
                                });
                            } else if (response === "Ongoing reservation") {
                                // Reservation is still ongoing; show an error message
                                Swal.fire({
                                    title: 'Error',
                                    text: 'You cannot delete a reservation that is currently ongoing.',
                                    icon: 'error',
                                    confirmButtonColor: "#a81c1c",
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // Handle other error cases here
                                Swal.fire({
                                    title: 'Error',
                                    text: response,
                                    icon: 'error',
                                    confirmButtonColor: "#a81c1c",
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            // Handle AJAX errors here
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while deleting the reservation.',
                                icon: 'error',
                                confirmButtonColor: "#a81c1c",
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    </script>





    </div>

    </div>



    <!------------------------ FOOTER ------------------------>
    </div>

</body>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>



</html>