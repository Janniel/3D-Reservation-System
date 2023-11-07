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

    <!-- <?php include 'php/libraries_admin.php' ?> -->

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


        <div class="main-content">
            <main>
                <div class="wrapper">
                    <canvas class="webgl3"></canvas>
                    <div class="info-container">
                       <h3>Reservation List</h3>
                       <p></p>
                       <button class="maintenance-btn">Mark as Under Maintenance</button>
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