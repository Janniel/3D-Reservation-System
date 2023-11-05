<?php
session_start();
require 'connect.php';
require 'session.php';



$sql = "SELECT r.reservation_id, r.user_id, r.date, r.start_time, r.end_time, a.username, u.user_id, r.seat_id, u.first_name, u.last_name, u.rfid_no, u.contact_number, u.course_code, u.age, a.email, a.picture, a.account_type, u.course_code, c.college_code
        FROM reservation AS r
        INNER JOIN account AS a ON r.user_id = a.username
        INNER JOIN users AS u ON r.user_id = u.user_id
        LEFT JOIN course AS c ON u.course_code = c.course_code
        WHERE r.is_archived = 0";

$result = $conn->query($sql);


?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservation</title>
    <!------------------------ Bootstrap 4 ------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="css/reserved.css" />
    <link rel="stylesheet" type="text/css" href="css/user-list.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="path-to-bootstrap/bootstrap.min.css">

    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <!------------------------ ICONS -------------------------->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



</head>


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
                <li class="tabs"> <a href="seats-info.php"><span class="las la-check"></span>
                        <span>Seats Information</span></a>
                </li>
                <li class="tabs"> <a href="reserved.php" class="active"><span class="las la-clock"></span>
                        <span>Reserved</span></a>
                </li>
                <li class="tabs"> <a href="user-list.php"><span class="las la-user-friends"></span>
                        <span>User List</span></a>
                </li>
                <li class="tabs"> <a href="history.php" ><span class="las la-history"></span>
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
                Reserved
            </h2>

            <div class="dropdown">
                <button class="dropdown-toggle" class="btn btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="user-wrapper">
                    
                        
                        <div id="user_admin">
                            <h4>
                                Hello, <?php echo $_SESSION["first_name"]; ?>
                            </h4>
                        </div>
                    
                    </div>
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="adminProfile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="toLogout.php">Logout</a></li>
                </div>
            </div>
        </header>
    </div>
    <!------------------------ END OF HEADER ------------------------>

    <div class="main-content">


        <main>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="table-tab" data-toggle="tab" href="#table-content" role="tab"
                        aria-controls="table-content" aria-selected="true">All</a>
                </li>



                <li class="nav-item">
                    <a class="nav-link" id="archive-tab" data-toggle="tab" href="#archive-content" role="tab"
                        aria-controls="archive-content" aria-selected="false">Archived</a>
                </li>

            </ul>
            
            <!-- Tab content -->
            <div class="tab-content" id="myTabsContent">
                <!-- Table Tab Content -->
                <div class="tab-pane fade show active" id="table-content" role="tabpanel" aria-labelledby="table-tab">

                    <div class="recent-grid">
                        <div class="history">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <section class="table__header">
                                            <h1>Reservation</h1>
                                            <div class="input-group">
                                                <input type="search" placeholder="Search Data...">
                                                <div class="search-icon">
                                                    <img src="../img/search.png" alt="Search">
                                                </div>
                                            </div>

                                            <div class="export__file">
                                                <label for="export-file" class="export__file-btn" title="Export File">
                                                    <img src="../img/export1.png" alt="Export" class="export_ic">
                                                </label>
                                                <input type="checkbox" id="export-file">
                                                <div class="export__file-options">
                                                    <label>Export As &nbsp; &#10140;</label>
                                                    <label for="export-file" id="toPDF">PDF <img
                                                            src="../img/pdf.png" alt=""></label>
                                                    <label for="export-file" id="toJSON">JSON <img
                                                            src="../img/json.png" alt=""></label>
                                                    <label for="export-file" id="toCSV">CSV <img
                                                            src="../img/csv.png" alt=""></label>
                                                    <label for="export-file" id="toEXCEL">EXCEL <img
                                                            src="../img/excel.png" alt=""></label>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"
                                                            id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="start_date"
                                                        placeholder="Start Date" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"
                                                            id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="end_date"
                                                        placeholder="End Date" readonly>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <button id="filterAll" class="btn btn-outline-info btn-sm">Filter
                                                    Date</button>
                                                <button id="reset"
                                                    class="btn btn-outline-warning btn-sm ">Reset</button>
                                            </div>
                                            

                                        </div>

                                        <section class="table__body">
                                            <table id="reservation_table">
                                                <thead>
                                                    <tr>
                                                        <th id="all-reservation-id"> Reservation ID <span
                                                                class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User ID <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User Type <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Course <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> College <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Seat ID <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Date <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Start Time <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> End Time <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <tr id="reservation_row_<?php echo $row['reservation_id']; ?>">

                                                            <td class="studno">
                                                                <?php echo $row['reservation_id']; ?>
                                                            </td>
                                                            <td>

                                                                <?php echo $row['user_id']; ?>
                                                            </td>

                                                            <td>
                                                                <img src="<?php echo $row['picture']; ?>" alt="">
                                                                <?php echo $row['first_name']; ?>
                                                                <?php echo $row['last_name']; ?>
                                                            </td>

                                                            <td>

                                                                <p
                                                                    class="user-type <?php echo strtolower($row['account_type']); ?>">
                                                                    <?php echo $row['account_type']; ?>
                                                                </p>
                                                            </td>

                                                            <td>

                                                                <?php echo $row['course_code']; ?>
                                                            </td>

                                                            <td>

                                                                <?php echo $row['college_code']; ?>
                                                            </td>

                                                            <td>
                                                                <?php echo $row['seat_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['date']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date("h:i A", strtotime($row['start_time'])); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date("h:i A", strtotime($row['end_time'])); ?>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon view_reservation"
                                                                    data-toggle="modal" data-target="#staticBackdrop"
                                                                    data-userid="<?php echo $row['user_id']; ?>"
                                                                    data-date="<?php echo $row['date']; ?>"
                                                                    data-starttime="<?php echo $row['start_time']; ?>"
                                                                    data-endtime="<?php echo $row['end_time']; ?>"
                                                                    data-firstname="<?php echo $row['first_name']; ?>"
                                                                    data-lastname="<?php echo $row['last_name']; ?>"
                                                                    data-picture="<?php echo $row['picture']; ?>"
                                                                    data-email="<?php echo $row['email']; ?> "
                                                                    data-rfidno="<?php echo $row['rfid_no']; ?> "
                                                                    data-course="<?php echo $row['course_code']; ?> "
                                                                    data-contactno="<?php echo $row['contact_number']; ?> "
                                                                    data-seatid="<?php echo $row['seat_id']; ?> "
                                                                    data-age="<?php echo $row['age']; ?> ">

                                                                    <i class="bi bi-eye-fill text-primary"
                                                                        style="font-size: 1.2em;"></i>
                                                                </button>

                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon archive_btn"
                                                                    data-reservation-id="<?php echo $row['reservation_id']; ?>">
                                                                    <i class="bi bi-trash-fill text-danger"
                                                                        style="font-size: 1.2em;"></i>
                                                                </button>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No history found.</td></tr>";
                                                }
                                                ?>
                                            </table>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archive Tab Content -->
                <div class="tab-pane fade" id="archive-content" role="tabpanel" aria-labelledby="archive-tab">
                    <div class="recent-grid">
                        <div class="archived_reservation">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <section class="table__header">
                                            <h1>Archived Reservation</h1>
                                            <div class="input-group">
                                                <input type="search" placeholder="Search Data...">
                                                <div class="search-icon">
                                                    <img src="assets/img/search.png" alt="Search">
                                                </div>
                                            </div>

                                            <div class="export__file">
                                                <label for="export-file-archive" class="export__file-btn" title="Export File">
                                                    <img src="assets/img/export1.png" alt="Export" class="export_ic">
                                                </label>
                                                <input type="checkbox" id="export-file-archive">
                                                <div class="export__file-options">
                                                    <label>Export As &nbsp; &#10140;</label>
                                                    <label for="export-file-archive" id="toPDFArchive">PDF <img
                                                            src="assets/img/pdf.png" alt=""></label>
                                                    <label for="export-file-archive" id="toJSONArchive">JSON <img
                                                            src="assets/img/json.png" alt=""></label>
                                                    <label for="export-file-archive" id="toCSVArchive">CSV <img
                                                            src="assets/img/csv.png" alt=""></label>
                                                    <label for="export-file-archive" id="toEXCELArchive">EXCEL <img
                                                            src="assets/img/excel.png" alt=""></label>
                                                </div>
                                            </div>
                                        </section>

                                        <div class="row">
                                            
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"
                                                            id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="archive_start_date"
                                                        placeholder="Start Date" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"
                                                            id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="archive_end_date"
                                                        placeholder="End Date" readonly>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <button id="filterArchive" class="btn btn-outline-info btn-sm">Filter
                                                    Date</button>
                                                <button id="resetArchive"
                                                    class="btn btn-outline-warning btn-sm ">Reset</button>
                                            </div>
                                        </div>

                                        <section class="table__body">
                                            <table id="archivedReservation_table">
                                                <thead>
                                                    <tr>
                                                        <th id="archive-reservation-id">Reservation ID<span
                                                                class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User ID <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User Type <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Course <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> College <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Seat ID <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Date <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Start Time <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> End Time <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $archiveSql = "SELECT r.reservation_id, r.user_id, r.date, r.start_time, r.end_time, a.username, u.user_id, r.seat_id, u.first_name, u.last_name, u.rfid_no, u.contact_number, u.course_code, a.email, a.picture, a.account_type, u.course_code, c.college_code
                                                FROM reservation AS r
                                                INNER JOIN account AS a ON r.user_id = a.username
                                                INNER JOIN users AS u ON r.user_id = u.user_id
                                                LEFT JOIN course AS c ON u.course_code = c.course_code
                                                WHERE r.is_archived = 1";

                                                $archiveResult = $conn->query($archiveSql);

                                                if ($archiveResult->num_rows > 0) {
                                                    while ($row = $archiveResult->fetch_assoc()) {
                                                        ?>
                                                        <tr id="archivedReservation_row_<?php echo $row['reservation_id']; ?>">
                                                            <td class="studno">
                                                                <?php echo $row['reservation_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['user_id']; ?>
                                                            </td>
                                                            <td>
                                                                <img src="<?php echo $row['picture']; ?>" alt="">
                                                                <?php echo $row['first_name']; ?>
                                                                <?php echo $row['last_name']; ?>
                                                            </td>

                                                            <td>

                                                                <p
                                                                    class="user-type <?php echo strtolower($row['account_type']); ?>">
                                                                    <?php echo $row['account_type']; ?>
                                                                </p>
                                                            </td>

                                                            <td>

                                                                <?php echo $row['course_code']; ?>
                                                            </td>

                                                            <td>

                                                                <?php echo $row['college_code']; ?>
                                                            </td>


                                                            <td>
                                                                <?php echo $row['seat_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['date']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['start_time']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['end_time']; ?>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon view_reservation"
                                                                    data-toggle="modal" data-target="#staticBackdrop"
                                                                    data-userid="<?php echo $row['user_id']; ?>"
                                                                    data-date="<?php echo $row['date']; ?>"
                                                                    data-starttime="<?php echo $row['start_time']; ?>"
                                                                    data-endtime="<?php echo $row['end_time']; ?>"
                                                                    data-firstname="<?php echo $row['first_name']; ?>"
                                                                    data-lastname="<?php echo $row['last_name']; ?>"
                                                                    data-picture="<?php echo $row['picture']; ?>"
                                                                    data-email="<?php echo $row['email']; ?>"
                                                                    data-rfidno="<?php echo $row['rfid_no']; ?>"
                                                                    data-course="<?php echo $row['course_code']; ?>"
                                                                    data-contactno="<?php echo $row['contact_number']; ?>"
                                                                    data-seatid="<?php echo $row['seat_id']; ?>">
                                                                    <i class="bi bi-eye-fill text-primary"
                                                                        style="font-size: 1.3em;"></i>
                                                                </button>

                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon restore_btn"
                                                                    data-reservation-id="<?php echo $row['reservation_id']; ?>">
                                                                    <i class="bi bi-arrow-counterclockwise text-warning"
                                                                        style="font-size: 1.3em;"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon delete_btn"
                                                                    data-reservation-id="<?php echo $row['reservation_id']; ?>">
                                                                    <i class="bi bi-trash-fill text-danger"
                                                                        style="font-size: 1.3em;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No archived reservation found.</td></tr>";
                                                }
                                                ?>
                                            </table>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--- modal view--->
            <div class="modal fade" id="staticBackdrop" data-backdrop="true" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="text-right"> <i class="bi bi-x-lg close" data-dismiss="modal"></i></div>

                            <div class="px-4 py-5">
                                <img src="" id="user-picture" alt="user picture"
                                    class="rounded-circle p-1 bg-secondary mb-3" width="10"
                                    style="width: 100px; height: 100px;">

                                <h5 class="text-uppercase" id="name_view"></h5>

                                <h6 class="mt-2 theme-color mb-5" id="userID_view"></h6>

                                <span class="font-weight-bold theme-color">User Information</span>
                                <div class="mb-3">
                                    <hr class="new1">
                                </div>



                                <div class="d-flex justify-content-between">
                                    <small id="rfid_view">RFID No.: </small>
                                    <small id="contact_view"></small>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <small id="course_view">Course: </small>
                                    <small>Year and Section: </small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <small id="college_view">College</small>
                                    <small id="age_view">Age: </small>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <small id="email_view"></small>
                                    <small> </small>
                                </div>



                                <span class="font-weight-bold theme-color">Reservation Details</span>
                                <div class="mb-3">
                                    <hr class="new1">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold">Date:</span>
                                    <span class="text-muted" id="date_view">Date: </span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold">Seat ID:</span>
                                    <span class="text-muted" id="seat_view"></span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <small>Start Time:</small>
                                    <small id="stime_view">start time here</small>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <small>End Time:</small>
                                    <small id="etime_view">end time here</small>
                                </div>
                            </div>

                        </div>
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
<script src="https://unpkg.com/xlsx-populate/browser/xlsx-populate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-table2excel/dist/jquery.table2excel.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js"
    integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<!-- Datepicker -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Momentjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





<script>
    $(function () {
        $("#archive_start_date, #start_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });

        $("#archive_end_date, #end_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
    });

    $(document).ready(function () {
        // Function to apply the date filter for a table
        function applyDateFilter(tableId, startDateId, endDateId) {
            var startDateStr = $(startDateId).val();
            var endDateStr = $(endDateId).val();

            // Validate date inputs
            if (!startDateStr || !endDateStr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter both start and end dates.',
                });
                return;
            }

            var startDate = new Date(startDateStr);
            var endDate = new Date(endDateStr);

            // Set the time components to midnight (00:00:00) to compare only the date portion
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            // Loop through all table rows and hide/show them based on the date range
            $(tableId + " tr[id^='reservation_row_'], " + tableId + " tr[id^='archivedReservation_row_']").each(function () {
                var rowId = $(this).attr("id");
                var rowDateStr = $(this).find("td:eq(7)").text(); // Assuming date is in the fourth column (0-based index)

                // Parse the row's date string into a JavaScript Date object
                var rowDate = new Date(rowDateStr);

                // Set the time component to midnight for the row's date
                rowDate.setHours(0, 0, 0, 0);

                // Check if the row's date falls within the selected date range
                if (rowDate >= startDate && rowDate <= endDate) {
                    $(this).show();
                } else if (startDate.getTime() === endDate.getTime() && rowDate.getTime() === startDate.getTime()) {
                    // Show rows for the exact same date when start and end dates are the same
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Add a click event handler for the "Filter" button for the main and archive tables
        $("#filterAll").click(function () {
    // Check if the "All" tab is active
    if ($("#table-tab").hasClass("active")) {
        applyDateFilter("", "#start_date", "#end_date"); // Main table
    } else if ($("#archive-tab").hasClass("active")) {
        applyDateFilter("", "#archive_start_date", "#archive_end_date"); // Archive table
    }
});

$("#filterArchive").click(function () {
    // Check if the "Archive" tab is active
    if ($("#table-tab").hasClass("active")) {
        // Apply the filter for the main table here
        applyDateFilter("", "#start_date", "#end_date");
    } else if ($("#archive-tab").hasClass("active")) {
        // Apply the filter for the archive table here
        applyDateFilter("", "#archive_start_date", "#archive_end_date");
    }
});


        // Add a click event handler for the "Reset" button to show all rows for both tables
        $("#reset").click(function () {
            $("tr[id^='reservation_row_']").show();
            $("#start_date").val(""); // Clear the start date input fields
            $("#end_date").val(""); // Clear the end date input fields
        });
        $("#resetArchive").click(function () {
            $("tr[id^='archivedReservation_row_']").show();
            $("#archive_start_date").val(""); // Clear the start date input fields
            $("#archive_end_date").val(""); // Clear the end date input fields
        });
    });
</script>






<script>
    //TO VIEW RESERVATION
    $(document).ready(function () {

        $('.view_reservation').click(function () {

            var userId = $(this).data('userid');
            var date = $(this).data('date');
            var seatId = $(this).data('seatid');
            var startTime = $(this).data('starttime');
            var endTime = $(this).data('endtime');
            var timeSpent = $(this).data('timespent');
            var email = $(this).data('email');
            var firstName = $(this).data('firstname');
            var lastName = $(this).data('lastname');
            var rfidNo = $(this).data('rfidno');
            var contactNo = $(this).data('contactno');
            var courseCode = $(this).data('course');
            var pictureUrl = $(this).data('picture');
            var age = $(this).data('age');
            

            $('#userID_view').text("User ID: " + userId);
            $('#date_view').text(date);
            $('#stime_view').text(startTime);
            $('#etime_view').text(endTime);
            $('#timeSpent_view').text(timeSpent);
            $('#email_view').text("Email:     " + email);
            $('#name_view').text(firstName + " " + lastName);
            $('#user-picture').attr('src', pictureUrl);
            $('#rfid_view').text("RFID Number:     " + rfidNo);
            $('#course_view').text("Course:     " + courseCode);
            $('#contact_view').text("Contact No.:     " + rfidNo);
            $('#seat_view').text(seatId);
            $('#age_view').text("Age: " + age);

        });
    });
</script>

<script>
    //TO ARCHIVE
    $(document).ready(function () {
        $(".archive_btn").click(function () {
            var reservationId = $(this).data("reservation-id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: 'toArchive.php',
                        method: 'POST',
                        data: { reservation_id: reservationId },
                        success: function (response) {
                            if (response === 'success') {
                                Swal.fire('Archived!', 'The reservation has been archived.', 'success');

                                $("#reservation_row_" + reservationId).remove();
                            } else {
                                Swal.fire('Error!', 'Failed to archive the reservation.', 'error');
                            }
                        }
                    });
                }
            });
        });
    });
</script>


<script>
    //RESTORE FROM ARCHIVE
    document.addEventListener('DOMContentLoaded', function () {
        const restoreButtons = document.querySelectorAll('.restore_btn');

        restoreButtons.forEach(button => {
            button.addEventListener('click', function () {
                const reservationId = button.getAttribute('data-reservation-id');

                Swal.fire({
                    title: 'Restore Archived Reservation?',
                    text: "Are you sure you want to restore this archived reservation?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "toRestore.php",
                            type: "POST",
                            data: { reservationId: reservationId },
                            success: function (response) {
                                if (response === "success") {

                                    $("#archivedReservation_row_" + reservationId).remove();
                                }
                            },
                        });
                        Swal.fire('Restored!', 'The reservation has been restored.', 'success');
                    }
                });
            });
        });
    });
</script>



<script>
    //DELETE FROM ARCHIVE
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete_btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const reservationId = button.getAttribute('data-reservation-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "toDelete.php",
                            type: "POST",
                            data: { reservationId: reservationId },
                            success: function (response) {
                                if (response === "success") {

                                    const deletedRow = document.getElementById("archivedReservation_row_" + reservationId);
                                    if (deletedRow) {
                                        deletedRow.remove();
                                    }
                                } else {
                                    Swal.fire('Error', 'An error occurred while deleting the row.', 'error');
                                }
                            }
                        });
                        Swal.fire('Deleted!', 'The reservation has been deleted.', 'success');
                    }
                });
            });
        });
    });
</script>

<script src="reserved.js"></script>



</html>