<?php
session_start();
require 'connect.php';
require 'session.php';
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!------------------------ Bootstrap 4 ------------------------>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="css/seats-info.css" />

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <?php include 'libraries_admin.php' ?>

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
                <img src="../img/bulsu logo.png" alt="bulsu logo" class="logo">
                <h2> <span>SOAR Admin</span></h2>
            </div>

            <div class="sidebar-menu" id="tabButton">
                <ul>
                    <li class="tabs"> <a href="../admin.php" data-tabName="dashboard" 
                            id="tabButtons"><span class="las la-th-large"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="tabs"> <a href="seats-info.php" class="active"><span class="las la-check"></span>
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
                    <li class="tabs"> <a href="settings.php"><span class="las la-cog"></span>
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
                        <li><a class="dropdown-item" href="adminProfile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="../toLogout.php">Logout</a></li>
                    </div>
                </div>
            </header>
        </div>
        <!------------------------ END OF HEADER ------------------------>


        <div class="main-content">

            <main>

                <div class="wrapper">
                    <div class="container-fluid">
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-4">
                                <!-------------------------DATE & TIME PICKER CARD DIV--------------------->
                                <div id="dateTimeDiv" class="card" data-aos="fade-right" style="display: flex;">
                                    <div class="card-header bg-light">
                                        <h5>Date</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="reserveForm" method="get">
                                            <div class="">
                                                <div class="form-group">
                                                    <!-- <label for="date" class="text-muted">Reserve seat on</label> -->
                                                    <div class="row d-flex justify-content-center">
                                                        <input type="text" id="date" class="form-control d-none"
                                                            min="<?php echo date('Y-m-d') ?>" name="date"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <!-- date picker -->
                                                <script>
                                                    flatpickr("#date", {
                                                        theme: "default",
                                                        inline: true,
                                                        dateFormat: "Y-m-d",
                                                        minDate: "today",
                                                        defaultDate: "today"

                                                    });
                                                </script>
                                                <!-- end of date picker -->

                                                <!-- hiddeeeennnnn -->
                                                <div class="hidden">
                                                    <div class="form-floating mb-3">
                                                        <input type="time" class="form-control" id="start_time"
                                                            name="start_time" required onchange="getEndTime()"
                                                            min="<?php echo date('H:i'); ?>" value="">
                                                        <label for="start_time" class="text-muted">From</label>

                                                        <input type="time" class="form-control-plaintext" readonly
                                                            id="end_time" name="end_time" required="required">
                                                        <label for="end_time" class="text-muted">To:</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="duration"
                                                            class="text-muted small m-2">Duration:</label>
                                                        <div class="btn-group btn-group-toggle w-100" role="group"
                                                            aria-label="Basic radio toggle button group">
                                                            <?php
                                                            $sql = "SELECT * FROM `settings` WHERE `settings_id` = 1";
                                                            $result = mysqli_query($conn, $sql);

                                                            // Check if the query was successful and fetch the row of data
                                                            if ($result && mysqli_num_rows($result) > 0) {
                                                                $settings = mysqli_fetch_assoc($result);
                                                                $minDuration = $settings['minDuration'];
                                                                $maxDuration = $settings['maxDuration'];

                                                                for ($i = $minDuration; $i <= $maxDuration; $i++) {
                                                                    echo '<input type="radio" class="btn-check" name="options" id="option' . $i . '" value="' . $i . '" autocomplete="off" onclick="getEndTime()">';
                                                                    echo '<label class="btn btn-outline-danger m-2 rounded ml-2 mr-2" id="btn-check" for="option' . $i . '">' . $i . ' hour' . (($i > 1) ? 's' : '') . '</label>';
                                                                }
                                                            } else {
                                                                echo "Error retrieving settings: " . mysqli_error($conn);
                                                            }

                                                            // Close the result set
                                                            mysqli_free_result($result);

                                                            // Close the database connection
                                                            mysqli_close($conn);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="time" class="form-control-plaintext" readonly
                                                            id="end_time" name="end_time" required="required">
                                                        <label for="end_time" class="text-muted">To:</label>
                                                    </div>

                                                </div>

                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" checked
                                                        id="flexSwitchCheckDefault" name="viewOption"
                                                        onchange="handleFormChange()"
                                                        style="--background-color: #FF0000;">
                                                    <label class="form-check-label m-1" for="flexSwitchCheckDefault"
                                                        style="padding-left: 20px;">3D View</label>
                                                </div>

                                                <!-- <button type="submit" id="newReservationBtn" class="btn btn-lg btn-primary rounded w-100">Check Availability</button> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-------------------------END OF DATE & TIME PICKER CARD DIV --------------------->
                            </div>

                            <div id="selectSeatForm" class="col mt-1">

                                <?php

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // $date = $_POST["date"];
                                    // $start_time = $_POST["start_time"];
                                    // $end_time = $_POST["end_time"];
                                    // include "view-3d.php";
                                    // include "view-2d.php";
                                }
                                ?>

                            </div>
                        </div>
                        <!-------------------------END OF DATE & TIME PICKER--------------------->
                    </div>
                </div>


            </main>


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