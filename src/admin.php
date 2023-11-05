<?php
session_start();
require 'php/connect.php';

// if the user was not logged in
if (
    !isset($_SESSION["user_id"]) && !isset($_SESSION["password"]) && !isset($_SESSION["first_name"])
    && !isset($_SESSION["last_name"]) && !isset($_SESSION["reservation_count"])
) {

    header('Location: loginAdmin.php');
    exit();

}

$sql = "SELECT r.reservation_id, r.user_id, r.date, r.start_time, r.end_time, a.username, u.user_id, r.seat_id, u.first_name, u.last_name, u.rfid_no, u.contact_number, u.course_code, a.email, a.picture
        FROM reservation AS r
        INNER JOIN account AS a ON r.user_id = a.username
        INNER JOIN users AS u ON r.user_id = u.user_id
        WHERE r.is_archived = 0 AND r.isDone = 0";

$result = $conn->query($sql);

?>


<!DOCTYPE HTML>
<html>


<!-- Popup for superadmin permission -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Super Admin Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-user"></span>
                                Super Admin Username</label>
                            <input type="text" class="form-control" id="usrname">
                        </div>
                        <div class="form-group">
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>
                                Super Admin Key</label>
                            <input type="text" class="form-control" id="psw">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="php/manageAdmin.php" class="btn btn-danger">Proceed</a>
                </div>
            </div>
        </div>
    </div>
</div>


<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!------------------------ Bootstrap 4 ------------------------>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="css/admin.css" />

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    

</head>


<body>
<!-- Hides manage admin button when regular admin is logged in -->
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
                <h2> <span>SOAR</span></h2>
            </div>

            <div class="sidebar-menu" id="tabButton">
                <ul>
                    <li class="tabs"> <a href="admin.php" data-tabName="dashboard" class="dashboard active" id="tabButtons"><span
                                class="las la-th-large"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="tabs"> <a href="php/seats-info.php" ><span class="las la-check"></span>
                            <span>Seats Information</span></a>
                    </li>
                    <li class="tabs"> <a href="php/reserved.php"><span class="las la-clock"></span>
                            <span>Reserved</span></a>
                    </li>
                    <li class="tabs"> <a href="php/user-list.php"><span
                                class="las la-user-friends"></span>
                            <span>User List</span></a>
                    </li>
                    <li class="tabs"> <a href="php/history.php"><span class="las la-history"></span>
                            <span>History</span></a>
                    </li>
                    <li class="tabs"> <a href="php/adminReviews.php"><span class="las la-star"></span>
                            <span>Reviews</span></a>
                    </li>
                    <li class="tabs"> <a href="php/analytics.php"><span
                                class="las la-chart-bar"></span>
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
                    Dashboard
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
                        <li><a class="dropdown-item" href="php/adminProfile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="toLogout.php">Logout</a></li>
                    </div>
                </div>
            </header>
        </div>
        <!------------------------ END OF HEADER ------------------------>


    <div class="main-content" style="overflow:hidden;">
        <main >
            <div id="tabContainer">
                <!--- Dashboard Code --->
                <div class="tab active" id="dashboard">
                    <!------------------------ SEAT INFO ------------------------>
                    <div class="cards">
                        <div class="counter col_fourth">
                            <i class="las la-check"></i>
                            <h2 class="timer count-title count-number" data-to="206" data-speed="1000"></h2>
                            <p class="count-text ">Unoccupied</p>
                        </div>

                        <div class="counter col_fourth">
                            <i class="las la-user"></i>
                            <h2 class="timer count-title count-number" data-to="156" data-speed="1000"></h2>
                            <p class="count-text ">Occupied</p>
                        </div>

                        <?php
                        if ($result) {
                            $rowCount = mysqli_num_rows($result); // Get the number of rows
                        
                            echo '<div class="counter col_fourth">
                                    <i class="las la-clock"></i>
                                    <h2 class="timer count-title count-number" data-to="' . $rowCount . '" data-speed="1000">' . $rowCount . '</h2>
                                    <p class="count-text">Pending</p>
                                  </div>';
                        } else {
                            // Handle the query error here
                            echo "Error: " . $conn->error;
                        }



                        ?>
                      
                        <div class="counter col_fourth end">
                            <i class="las la-tools"></i>
                            <h2 class="timer count-title count-number" data-to="10" data-speed="1000"></h2>
                            <p class="count-text ">Maintenance</p>
                        </div>
                    </div>
                    <!------------------------ END OF SEAT INFO ------------------------>

                    <div class="recent-grid">
                        <!------------------------ PENDING RESERVATION ------------------------>
                        <div class="pending">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Pending Reservation</h3>
                                    <a href="php/reserved.php" class="button" id="tabButtons">See all <span
                                            class="las la-arrow-right"></span></a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table width="100%">
                                            <thead>
                                                <tr>
                                                    <td>Reservation ID</td>
                                                    <td>User ID</td>
                                                    <td>Name</td>
                                                    <td>Seat ID</td>
                                                    <td>Date</td>
                                                    <td>Start Time</td>
                                                    <td>End Time</td>
                                                    <td></td>
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
                                                                                                        <?php echo $row['first_name']; ?>
                                                                                                        <?php echo $row['last_name']; ?>
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
                                                                                                    <button type="button" class="btn btn-light btn-rounded btn-icon view_reservation"
                                                                                                    data-toggle="modal" data-target="#staticBackdrop"
                                                                                                            data-userid="<?php echo $row['user_id']; ?>"
                                                                                                            data-date="<?php echo $row['date']; ?>"
                                                                                                            data-starttime="<?php echo date("h:i A", strtotime($row['start_time'])); ?>"
                                                                                                            data-endtime="<?php echo date("h:i A", strtotime($row['end_time'])); ?>"
                                                            
                                                                                                            data-firstname="<?php echo $row['first_name']; ?>"
                                                                                                            data-lastname="<?php echo $row['last_name']; ?>"
                                                                                                            data-picture="<?php echo $row['picture']; ?>"
                                                                                                            data-email="<?php echo $row['email']; ?> "
                                                                                                            data-rfidno="<?php echo $row['rfid_no']; ?> "
                                                                                                            data-course="<?php echo $row['course_code']; ?> "
                                                                                                            data-contactno="<?php echo $row['contact_number']; ?> "
                                                                                                            data-seatid="<?php echo $row['seat_id']; ?> "
                                                                                                            >
                                                                                                        <i class="bi bi-eye-fill text-danger" style="font-size: 1.2em;"></i>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!------------------------ END OF PENDING RESERVATION ------------------------>

                        <!------------------------ RECENT HISTORY ------------------------>
                        <div class="recent-history">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Recent History</h3>
                                    <a href="php/history.php" class="button">See all <span class="las la-arrow-right"></span></a>
                                </div>
                                <div class="card-body">

                                    <?php
                                    $historySql = "SELECT h.history_id, h.reservation_id, h.user_id, h.date, h.start_time, h.end_time, a.username, u.user_id, h.seat_id, u.first_name, u.last_name, u.rfid_no, u.contact_number, u.course_code, a.email, a.picture
                                    FROM history AS h
                                    INNER JOIN account AS a ON h.user_id = a.username
                                    INNER JOIN users AS u ON h.user_id = u.user_id
                                    WHERE h.is_archived = 0
                                    ORDER BY h.date DESC
                                    LIMIT 5"; // Retrieve the first 5 rows from the history table ordered by date in descending order
                                    
                                    $historyResult = $conn->query($historySql);

                                    if ($historyResult->num_rows > 0) {
                                        while ($row = $historyResult->fetch_assoc()) {
                                            ?>

                                                                                            <div class="customer">
                                                                                                <div class="info">
                                                                                                    <img src="<?php echo $row['picture']; ?>" width="40px" height="40px" alt="">
                                                                                                    <div>
                                                                                                        <h5><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                                                                                                        <small><?php echo $row['course_code']; ?></small>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="see-details">
                                                                                                    <a href="history-details.php?history_id=<?php echo $row['history_id']; ?>">See details</a>
                                                                                                </div>
                                                                                            </div>

                                                                                            <?php
                                        }
                                    } else {
                                        // No recent history message
                                        echo "<p>No recent history.</p>";
                                    }
                                    // Close the database connection after fetching the data
                                    $conn->close();
                                    ?>

                                </div>
                            </div>
                        </div>
                        <!------------------------ END OF RECENT HISTORY ------------------------>



                        <!-- Popup for superadmin permission -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Super Admin Permission</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body" style="padding:40px 50px;">
                                            <form role="form">
                                                <div class="form-group">
                                                    <label for="usrname"><span class="glyphicon glyphicon-user"></span>
                                                        Super Admin Username</label>
                                                    <input type="text" class="form-control" id="usrname">
                                                </div>
                                                <div class="form-group">
                                                    <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>
                                                        Super Admin Key</label>
                                                    <input type="text" class="form-control" id="psw">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <a href="manage.php" class="btn btn-danger">Proceed</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--- Seats Information Code --->
                <div class="tab" id="seats-info">
                    <div class="filter">

                        <div class="row">

                            <div class="date">
                                <label>Date seated </label>
                                <input type="date" name="claimed_date" value="2023-04-17" class="form-control"
                                    required="required"></input>
                            </div>

                            <div class="college">
                                <label for="cars">Table No.</label>
                                <select class="form-control">
                                    <option style="display:none">Select here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option selected="selected">8</option>
                                    <option>9</option>
                                </select>
                            </div>

                            <div class="floor" class="form-control">
                                <label for="cars">Floor</label>
                                <select class="form-control">
                                    <option style="display:none">Select here</option>
                                    <option disabled>1</option>
                                    <option disabled>2</option>
                                    <option disabled>3</option>
                                    <option disabled>4</option>
                                    <option disabled>5</option>
                                    <option selected="selected">6</option>
                                    <option disabled>7</option>
                                </select>
                            </div>


                            <div class="col-md-2">
                                <button type="submit" class="buttons">Filter</button>
                            </div>

                            <div class="table">

                                <!-- Non-responsive (yet); Just a small sample of what's possible with CSS Grid. -->
                                <ul class="calendar weekly-byhour">
                                    <!--  EVENT NODES  -->
                                    <!--  DATA:      CATEGORY                         DAY              START  /  END     EVENT DETAILS  -->


                                    <li class="event personal" style="grid-column:   tue;   grid-row:  h05   /  h07;  ">
                                        2020104776</li>
                                    <li class="event personal" style="grid-column:   mon;   grid-row:  h11   /  h12;  ">
                                        2020103123</li>
                                    <li class="event personal" style="grid-column:   mon;   grid-row:  h08   /  h10;  ">
                                        2020104124</li>
                                    <li class="event personal" style="grid-column:   mon;   grid-row:  h16  /  h17;  ">
                                        2020104214</li>
                                    <li class="event personal" style="grid-column:   sun;   grid-row:  h13  /  h15;  ">
                                        2020107547</li>
                                    <li class="event personal" style="grid-column:   wed;   grid-row:  h10   /  h12;  ">
                                        2020107476</li>




                                    <!--  DAYS OF THE WEEK  -->
                                    <li class="day sun">Seat 40</li>
                                    <li class="day mon">Seat 41</li>
                                    <li class="day tue">Seat 42</li>
                                    <li class="day wed">Seat 43</li>
                                    <li class="day thu">Seat 44</li>


                                    <!--  TIMES OF THE DAY  -->
                                    <li class="time h05">9:00 am</li>
                                    <li class="time h06">10:00 am</li>
                                    <li class="time h07">11:00 am</li>
                                    <li class="time h08">12:00 am</li>
                                    <li class="time h09">1:00 pm</li>
                                    <li class="time h10">2:00 pm</li>
                                    <li class="time h11">3:00 pm</li>
                                    <li class="time h12">4:00 pm</li>
                                    <li class="time h13">5:00 pm</li>
                                    <li class="time h14">6:00 pm</li>
                                    <li class="time h15">7:00 pm</li>
                                    <li class="time h16">8:00 pm</li>
                                    <li class="time h17">9:00 pm</li>

                                    <!--  TOP LEFT CORNER FILLER  -->
                                    <li class="corner"></li>

                                    <!--  EMPTY HOURLY FILLERS: -->
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>

                                </ul>
                            </div>

                        </div>

                    </div>
                </div>

                <!--- Reserved Code --->
                <div class="tab" id="reserved">

                    <form action="brw_history.php" method="GET">

                        <div class="filter">
                            <form action="brw_history.php" method="GET">

                                <div class="row">

                                    <div class="date">
                                        <label>Date seated </label>
                                        <input type="date" name="claimed_date" value="" class="form-control"
                                            required="required"></input>
                                    </div>

                                    <div class="college">
                                        <label for="cars">College</label>
                                        <select class="form-control">
                                            <option style="display:none">Select here</option>
                                            <option>College of Architecture and Fine Arts (CAFA)</option>
                                            <option>College of Arts and Letters (CAL)</option>
                                            <option>College of Business Administration (CBA)</option>
                                            <option>College of Criminal Justice Education (CCJE)</option>
                                            <option>College of Hospitaity and Tourism Management (CHTM)</option>
                                            <option>College of Information and Communications Technology (CICT)</option>
                                            <option>College of Industrial Technology (CIT)</option>
                                            <option>College of Law (CLaw)</option>
                                            <option>College of Nursing (CN)</option>
                                            <option>College of Engineering (COE)</option>
                                            <option>College of Education (COED)</option>
                                            <option>College of Science (CS)</option>
                                            <option>College of Exercise and Recreation (CSER)</option>
                                            <option>College of Social Sciences and Philosophy (CSSP)</option>
                                            <option>Graduate School (GS)</option>
                                        </select>
                                    </div>

                                    <div class="course">
                                        <label for="cars">Course</label>
                                        <select class="form-control">
                                            <option style="display:none">Select here</option>
                                            <optgroup label="CAFA">
                                                <option>Bachelor of Science in Architecture</option>
                                                <option>Bachelor of Landscape Architecture</option>
                                                <option>Bachelor of Fine Arts Major in Visual Communication</option>
                                            <optgroup label="CAL">
                                                <option>Bachelor of Arts in Broadcasting</option>
                                                <option>Bachelor of Arts in Journalism</option>
                                                <option>Bachelor of Performing Arts (Theater Track)</option>
                                                <option>Batsilyer ng Sining sa Malikhaing Pagsulat</option>
                                            <optgroup label="CBA">
                                                <option>Bachelor of Science in Business Administration Major in Business
                                                    Economics
                                                </option>
                                                <option>Bachelor of Science in Business Administration Major in
                                                    Financial
                                                    Management
                                                </option>
                                                <option>Bachelor of Science in Business Administration Major in
                                                    Marketing
                                                    Management
                                                </option>
                                                <option>Bachelor of Science in Entrepreneurship</option>
                                                <option>Bachelor of Science in Accountancy</option>
                                            <optgroup label="CCJE">
                                                <option>Bachelor of Arts in Legal Management</option>
                                                <option>Bachelor of Science in Criminology</option>
                                            <optgroup label="CHTM">
                                                <option>Bachelor of Science in Hospitality Management</option>
                                                <option>Bachelor of Science in Tourism Management</option>
                                            <optgroup label="CICT">
                                                <option>Bachelor of Science in Information Technology</option>
                                                <option>Bachelor of Library and Information Science</option>
                                                <option>Bachelor of Science in Information System</option>
                                            <optgroup label="CIT">
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Automotive
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Computer
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Drafting
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Electrical
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Electronics
                                                    &
                                                    Communication Technology</option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Electronics
                                                    Technology</option>
                                                <option>Bachelor of Industrial Technology with specialization in Food
                                                    Processing
                                                    Technology</option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Mechanical
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Heating,
                                                    Ventilation, Air Conditioning and Refrigeration Technology (HVACR)
                                                </option>
                                                <option>Bachelor of Industrial Technology with specialization in
                                                    Mechatronics
                                                    Technology</option>
                                                <option>Bachelor of Industrial Technology with specialization in Welding
                                                    Technology
                                                </option>
                                            <optgroup label="CLaw">
                                                <option>Bachelor of Laws</option>
                                                <option>Juris Doctor</option>
                                            <optgroup label="CN">
                                                <option>Bachelor of Science in Nursing</option>
                                            <optgroup label="COE">
                                                <option>Bachelor of Science in Civil Engineering</option>
                                                <option>Bachelor of Science in Computer Engineering</option>
                                                <option>Bachelor of Science in Electrical Engineering</option>
                                                <option>Bachelor of Science in Electronics Engineering</option>
                                                <option>Bachelor of Science in Industrial Engineering</option>
                                                <option>Bachelor of Science in Manufacturing Engineering</option>
                                                <option>Bachelor of Science in Mechanical Engineering</option>
                                                <option>Bachelor of Science in Mechatronics Engineering</option>
                                            <optgroup label="COED">
                                                <option>Bachelor of Elementary Education</option>
                                                <option>Bachelor of Early Childhood Education</option>
                                                <option>Bachelor of Secondary Education Major in English minor in
                                                    Mandarin
                                                </option>
                                                <option>Bachelor of Secondary Education Major in English minor in
                                                    Mandarin
                                                </option>
                                                <option>Bachelor of Secondary Education Major in Sciences</option>
                                                <option>Bachelor of Secondary Education Major in Mathematics</option>
                                                <option>Bachelor of Secondary Education Major in Social Studies</option>
                                                <option>Bachelor of Secondary Education Major in Values Education
                                                </option>
                                                <option>Bachelor of Physical Education</option>
                                                <option>Bachelor of Technology and Livelihood Education Major in
                                                    Industrial
                                                    Arts
                                                </option>
                                                <option>Bachelor of Technology and Livelihood Education Major in
                                                    Information
                                                    and
                                                    Communication Technology</option>
                                                <option>Bachelor of Technology and Livelihood Education Major in Home
                                                    Economics
                                                </option>
                                            <optgroup label="CS">
                                                <option>Bachelor of Science in Biology</option>
                                                <option>Bachelor of Science in Environmental Science</option>
                                                <option>Bachelor of Science in Food Technology</option>
                                                <option>Bachelor of Science in Math with Specialization in Computer
                                                    Science
                                                </option>
                                                <option>Bachelor of Science in Math with Specialization in Applied
                                                    Statistics
                                                </option>
                                                <option>Bachelor of Science in Math with Specialization in Business
                                                    Applications
                                                </option>
                                            <optgroup label="CSER">
                                                <option>Bachelor of Science in Exercise and Sports Sciences with
                                                    specialization in
                                                    Fitness and Sports Coaching</option>
                                                <option>Bachelor of Science in Exercise and Sports Sciences with
                                                    specialization in
                                                    Fitness and Sports Management</option>
                                                <option>Certificate of Physical Education</option>
                                            <optgroup label="CSSP">
                                                <option>Bachelor of Public Administration</option>
                                                <option>Bachelor of Science in Social Work</option>
                                                <option>Bachelor of Science in Psychology</option>
                                            <optgroup label="GS">
                                                <option>Doctor of Education</option>
                                                <option>Doctor of Philosophy</option>
                                                <option>Doctor of Public Administration</option>
                                                <option>Master in Physical Education</option>
                                                <option>Master in Business Administration</option>
                                                <option>Master in Public Administration</option>
                                                <option>Master of Arts in Education</option>
                                                <option>Master of Engineering Program</option>
                                                <option>Master of Industrial Technology Management</option>
                                                <option>Master of Science in Civil Engineering</option>
                                                <option>Master of Science in Computer Engineering</option>
                                                <option>Master of Science in Electronics and Communications Engineering
                                                </option>
                                                <option>Master of Information Technology</option>
                                                <option>Master of Manufacturing Engineering</option>
                                        </select>
                                    </div>

                                    <div class="floor" class="form-control">
                                        <label for="cars">Floor</label>
                                        <select class="form-control">
                                            <option style="display:none">Select here</option>
                                            <option disabled>1</option>
                                            <option disabled>2</option>
                                            <option disabled>3</option>
                                            <option disabled>4</option>
                                            <option disabled>5</option>
                                            <option>6</option>
                                            <option disabled>7</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="buttons">Filter</button>
                                    </div>
                                </div>

                                <div class="recent-grid">
                                    <div class="history">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3>Reserved Users</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">

                                                    <table width="100%">
                                                        <div class="head">
                                                            <thead>
                                                                <tr>
                                                                    <td>Student No.</td>
                                                                    <td>College</td>
                                                                    <td>Time-in</td>
                                                                    <td>Time-out</td>
                                                                    <td>Date</td>
                                                                    <td>Seat No.</td>
                                                                    <td>Floor No.</td>
                                                                    <td style="display:hidden"></td>
                                                                </tr>
                                                            </thead>
                                                        </div>
                                                        <div class='fill'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="studno">2020106234</td>
                                                                    <td>CICT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>53</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020103646</td>
                                                                    <td>CLaw</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>65</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CAL</td>
                                                                    <td>1:00PM</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>24</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CIT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>12</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CN</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020104122</td>
                                                                    <td>CAFA</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106234</td>
                                                                    <td>CICT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>53</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020103646</td>
                                                                    <td>CLaw</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>65</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CAL</td>
                                                                    <td>1:00PM</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>24</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CIT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>12</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CN</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020104122</td>
                                                                    <td>CAFA</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106234</td>
                                                                    <td>CICT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>53</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020103646</td>
                                                                    <td>CLaw</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>65</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CAL</td>
                                                                    <td>1:00PM</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>24</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CIT</td>
                                                                    <td>09:30AM</td>
                                                                    <td>10:00AM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>12</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020106434</td>
                                                                    <td>CN</td>
                                                                    <td>10:00AM</td>
                                                                    <td>12:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="studno">2020104122</td>
                                                                    <td>CAFA</td>
                                                                    <td>3:00PM</td>
                                                                    <td>4:00PM</td>
                                                                    <td>4/17/23</td>
                                                                    <td>52</td>
                                                                    <td>6</td>
                                                                    <td><button class="cancel">Cancel</button></td>
                                                                </tr>
                                                            </tbody>

                                                        </div><!-- fill -->

                                                    </table>

                                                </div><!-- responsive -->


                                            </div> <!-- card body -->
                                        </div> <!-- card -->
                                    </div> <!-- history -->
                                </div> <!-- recent grid -->


                            </form>
                        </div>

                    </form>


                </div>

                <!--- User List Code --->
                <div class="tab" id="userList">
                    <div class="filter">
                        <form action="brw_history.php" method="GET">

                            <div class="row">

                                <div class="college">
                                    <label for="cars">College</label>
                                    <select class="form-control">
                                        <option style="display:none">Select here</option>
                                        <option>College of Architecture and Fine Arts (CAFA)</option>
                                        <option>College of Arts and Letters (CAL)</option>
                                        <option>College of Business Administration (CBA)</option>
                                        <option>College of Criminal Justice Education (CCJE)</option>
                                        <option>College of Hospitaity and Tourism Management (CHTM)</option>
                                        <option>College of Information and Communications Technology (CICT)</option>
                                        <option>College of Industrial Technology (CIT)</option>
                                        <option>College of Law (CLaw)</option>
                                        <option>College of Nursing (CN)</option>
                                        <option>College of Engineering (COE)</option>
                                        <option>College of Education (COED)</option>
                                        <option>College of Science (CS)</option>
                                        <option>College of Exercise and Recreation (CSER)</option>
                                        <option>College of Social Sciences and Philosophy (CSSP)</option>
                                        <option>Graduate School (GS)</option>
                                    </select>
                                </div>

                                <div class="course">
                                    <label for="cars">Course</label>
                                    <select class="form-control">
                                        <option style="display:none">Select here</option>
                                        <optgroup label="CAFA">
                                            <option>Bachelor of Science in Architecture</option>
                                            <option>Bachelor of Landscape Architecture</option>
                                            <option>Bachelor of Fine Arts Major in Visual Communication</option>
                                        <optgroup label="CAL">
                                            <option>Bachelor of Arts in Broadcasting</option>
                                            <option>Bachelor of Arts in Journalism</option>
                                            <option>Bachelor of Performing Arts (Theater Track)</option>
                                            <option>Batsilyer ng Sining sa Malikhaing Pagsulat</option>
                                        <optgroup label="CBA">
                                            <option>Bachelor of Science in Business Administration Major in Business
                                                Economics
                                            </option>
                                            <option>Bachelor of Science in Business Administration Major in Financial
                                                Management
                                            </option>
                                            <option>Bachelor of Science in Business Administration Major in Marketing
                                                Management
                                            </option>
                                            <option>Bachelor of Science in Entrepreneurship</option>
                                            <option>Bachelor of Science in Accountancy</option>
                                        <optgroup label="CCJE">
                                            <option>Bachelor of Arts in Legal Management</option>
                                            <option>Bachelor of Science in Criminology</option>
                                        <optgroup label="CHTM">
                                            <option>Bachelor of Science in Hospitality Management</option>
                                            <option>Bachelor of Science in Tourism Management</option>
                                        <optgroup label="CICT">
                                            <option>Bachelor of Science in Information Technology</option>
                                            <option>Bachelor of Library and Information Science</option>
                                            <option>Bachelor of Science in Information System</option>
                                        <optgroup label="CIT">
                                            <option>Bachelor of Industrial Technology with specialization in Automotive
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in Computer
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in Drafting
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in Electrical
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in Electronics
                                                &
                                                Communication Technology</option>
                                            <option>Bachelor of Industrial Technology with specialization in Electronics
                                                Technology</option>
                                            <option>Bachelor of Industrial Technology with specialization in Food
                                                Processing
                                                Technology</option>
                                            <option>Bachelor of Industrial Technology with specialization in Mechanical
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in Heating,
                                                Ventilation, Air Conditioning and Refrigeration Technology (HVACR)
                                            </option>
                                            <option>Bachelor of Industrial Technology with specialization in
                                                Mechatronics
                                                Technology</option>
                                            <option>Bachelor of Industrial Technology with specialization in Welding
                                                Technology
                                            </option>
                                        <optgroup label="CLaw">
                                            <option>Bachelor of Laws</option>
                                            <option>Juris Doctor</option>
                                        <optgroup label="CN">
                                            <option>Bachelor of Science in Nursing</option>
                                        <optgroup label="COE">
                                            <option>Bachelor of Science in Civil Engineering</option>
                                            <option>Bachelor of Science in Computer Engineering</option>
                                            <option>Bachelor of Science in Electrical Engineering</option>
                                            <option>Bachelor of Science in Electronics Engineering</option>
                                            <option>Bachelor of Science in Industrial Engineering</option>
                                            <option>Bachelor of Science in Manufacturing Engineering</option>
                                            <option>Bachelor of Science in Mechanical Engineering</option>
                                            <option>Bachelor of Science in Mechatronics Engineering</option>
                                        <optgroup label="COED">
                                            <option>Bachelor of Elementary Education</option>
                                            <option>Bachelor of Early Childhood Education</option>
                                            <option>Bachelor of Secondary Education Major in English minor in Mandarin
                                            </option>
                                            <option>Bachelor of Secondary Education Major in English minor in Mandarin
                                            </option>
                                            <option>Bachelor of Secondary Education Major in Sciences</option>
                                            <option>Bachelor of Secondary Education Major in Mathematics</option>
                                            <option>Bachelor of Secondary Education Major in Social Studies</option>
                                            <option>Bachelor of Secondary Education Major in Values Education</option>
                                            <option>Bachelor of Physical Education</option>
                                            <option>Bachelor of Technology and Livelihood Education Major in Industrial
                                                Arts
                                            </option>
                                            <option>Bachelor of Technology and Livelihood Education Major in Information
                                                and
                                                Communication Technology</option>
                                            <option>Bachelor of Technology and Livelihood Education Major in Home
                                                Economics
                                            </option>
                                        <optgroup label="CS">
                                            <option>Bachelor of Science in Biology</option>
                                            <option>Bachelor of Science in Environmental Science</option>
                                            <option>Bachelor of Science in Food Technology</option>
                                            <option>Bachelor of Science in Math with Specialization in Computer Science
                                            </option>
                                            <option>Bachelor of Science in Math with Specialization in Applied
                                                Statistics
                                            </option>
                                            <option>Bachelor of Science in Math with Specialization in Business
                                                Applications
                                            </option>
                                        <optgroup label="CSER">
                                            <option>Bachelor of Science in Exercise and Sports Sciences with
                                                specialization in
                                                Fitness and Sports Coaching</option>
                                            <option>Bachelor of Science in Exercise and Sports Sciences with
                                                specialization in
                                                Fitness and Sports Management</option>
                                            <option>Certificate of Physical Education</option>
                                        <optgroup label="CSSP">
                                            <option>Bachelor of Public Administration</option>
                                            <option>Bachelor of Science in Social Work</option>
                                            <option>Bachelor of Science in Psychology</option>
                                        <optgroup label="GS">
                                            <option>Doctor of Education</option>
                                            <option>Doctor of Philosophy</option>
                                            <option>Doctor of Public Administration</option>
                                            <option>Master in Physical Education</option>
                                            <option>Master in Business Administration</option>
                                            <option>Master in Public Administration</option>
                                            <option>Master of Arts in Education</option>
                                            <option>Master of Engineering Program</option>
                                            <option>Master of Industrial Technology Management</option>
                                            <option>Master of Science in Civil Engineering</option>
                                            <option>Master of Science in Computer Engineering</option>
                                            <option>Master of Science in Electronics and Communications Engineering
                                            </option>
                                            <option>Master of Information Technology</option>
                                            <option>Master of Manufacturing Engineering</option>
                                    </select>
                                </div>

                                <div class="floor" class="form-control">
                                    <label for="cars">User Type</label>
                                    <select class="form-control">
                                        <option style="display:none">Select here</option>
                                        <option>Student</option>
                                        <option>Faculty</option>
                                        <option>Alumni</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="buttons">Filter</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="recent-grid">
                        <div class="history">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <section class="table__header">
                                            <h1>Users</h1>
                                            <div class="input-group">
                                                <input type="search" placeholder="Search Data...">
                                                <div class="search-icon">
                                                    <img src="img/search.png" alt="Search">
                                                </div>
                                            </div>
                                            <div class="export__file">
                                                <label for="export-file" class="export__file-btn" title="Export File">
                                                    <img src="img/export_ic.png" alt="Export" class="export_ic">
                                                </label>
                                                <input type="checkbox" id="export-file">
                                                <div class="export__file-options">
                                                    <label>Export As &nbsp; &#10140;</label>
                                                    <label for="export-file" id="toPDF">PDF <img
                                                            src="img/pdf.png" alt=""></label>
                                                    <label for="export-file" id="toJSON">JSON <img
                                                            src="img/json.png" alt=""></label>
                                                    <label for="export-file" id="toCSV">CSV <img
                                                            src="img/csv.png" alt=""></label>
                                                    <label for="export-file" id="toEXCEL">EXCEL <img
                                                            src="img/excel.png" alt=""></label>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="table__body">
                                            <table id="customers_table">
                                                <thead>
                                                    <tr>
                                                        <th> User ID <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> RFID No. <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> First Name <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Last Name <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Course Code <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Year <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Type <span class="icon-arrow">&UpArrow;</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="studno">2020104276</td>
                                                        <td>47192</td>
                                                        <td>Killua</td>
                                                        <td>Zoldyck</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2020604776</td>
                                                        <td>47192</td>
                                                        <td>Kei</td>
                                                        <td>Tsukishima</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2024104776</td>
                                                        <td>47192</td>
                                                        <td>Safer</td>
                                                        <td>Sephiroth</td>
                                                        <td>CAFA</td>
                                                        <td>BSARC</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2020604776</td>
                                                        <td>47192</td>
                                                        <td>Rinoa</td>
                                                        <td>Heartily</td>
                                                        <td>CICT</td>
                                                        <td>BLIS</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2020504776</td>
                                                        <td>47192</td>
                                                        <td>Lightning</td>
                                                        <td>Farron</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2023104776</td>
                                                        <td>47192</td>
                                                        <td>Aerith</td>
                                                        <td>Gainborough</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2030104776</td>
                                                        <td>47192</td>
                                                        <td>Tifa</td>
                                                        <td>Lockhart</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2021104776</td>
                                                        <td>47192</td>
                                                        <td>Cloud</td>
                                                        <td>Strife</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2022104776</td>
                                                        <td>47192</td>
                                                        <td>Zack</td>
                                                        <td>Fair</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="studno">2023104776</td>
                                                        <td>47192</td>
                                                        <td>Loyd</td>
                                                        <td>Cruz</td>
                                                        <td>CICT</td>
                                                        <td>BSIT</td>
                                                        <td>Student</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--- History Code --->
                <div class="tab" id="history">
                    <div class="filter">
                        <form action="brw_history.php" method="GET">

                          <div class="row">

                            <div class="college">
                               <label for="cars">College</label>
                               <select class="form-control">
                                <option style="display:none">Select here</option>
                                <option>College of Architecture and Fine Arts (CAFA)</option>
                                <option>College of Arts and Letters (CAL)</option>
                                <option>College of Business Administration (CBA)</option>
                                <option>College of Criminal Justice Education (CCJE)</option>
                                <option>College of Hospitaity and Tourism Management (CHTM)</option>
                                <option>College of Information and Communications Technology (CICT)</option>
                                <option>College of Industrial Technology (CIT)</option>
                                <option>College of Law (CLaw)</option>
                                <option>College of Nursing (CN)</option>
                                <option>College of Engineering (COE)</option>
                                <option>College of Education (COED)</option>
                                <option>College of Science (CS)</option>
                                <option>College of Exercise and Recreation (CSER)</option>
                                <option>College of Social Sciences and Philosophy (CSSP)</option>
                                <option>Graduate School (GS)</option>
                               </select>
                            </div>

                            <div class="course">
                             <label for="cars">Course</label>
                             <select class="form-control">
                                <option style="display:none">Select here</option>
                                <optgroup label="CAFA">
                                    <option>Bachelor of Science in Architecture</option>
                                    <option>Bachelor of Landscape Architecture</option>
                                    <option>Bachelor of Fine Arts Major in Visual Communication</option>
                                <optgroup label="CAL">
                                    <option>Bachelor of Arts in Broadcasting</option>
                                    <option>Bachelor of Arts in Journalism</option>
                                    <option>Bachelor of Performing Arts (Theater Track)</option>
                                    <option>Batsilyer ng Sining sa Malikhaing Pagsulat</option>
                                <optgroup label="CBA">
                                    <option>Bachelor of Science in Business Administration Major in Business Economics
                                    </option>
                                    <option>Bachelor of Science in Business Administration Major in Financial Management
                                    </option>
                                    <option>Bachelor of Science in Business Administration Major in Marketing Management
                                    </option>
                                    <option>Bachelor of Science in Entrepreneurship</option>
                                    <option>Bachelor of Science in Accountancy</option>
                                <optgroup label="CCJE">
                                    <option>Bachelor of Arts in Legal Management</option>
                                    <option>Bachelor of Science in Criminology</option>
                                <optgroup label="CHTM">
                                    <option>Bachelor of Science in Hospitality Management</option>
                                    <option>Bachelor of Science in Tourism Management</option>
                                <optgroup label="CICT">
                                    <option>Bachelor of Science in Information Technology</option>
                                    <option>Bachelor of Library and Information Science</option>
                                    <option>Bachelor of Science in Information System</option>
                                <optgroup label="CIT">
                                    <option>Bachelor of Industrial Technology with specialization in Automotive</option>
                                    <option>Bachelor of Industrial Technology with specialization in Computer</option>
                                    <option>Bachelor of Industrial Technology with specialization in Drafting</option>
                                    <option>Bachelor of Industrial Technology with specialization in Electrical</option>
                                    <option>Bachelor of Industrial Technology with specialization in Electronics &
                                        Communication Technology</option>
                                    <option>Bachelor of Industrial Technology with specialization in Electronics
                                        Technology</option>
                                    <option>Bachelor of Industrial Technology with specialization in Food Processing
                                        Technology</option>
                                    <option>Bachelor of Industrial Technology with specialization in Mechanical</option>
                                    <option>Bachelor of Industrial Technology with specialization in Heating,
                                        Ventilation, Air Conditioning and Refrigeration Technology (HVACR)</option>
                                    <option>Bachelor of Industrial Technology with specialization in Mechatronics
                                        Technology</option>
                                    <option>Bachelor of Industrial Technology with specialization in Welding Technology
                                    </option>
                                <optgroup label="CLaw">
                                    <option>Bachelor of Laws</option>
                                    <option>Juris Doctor</option>
                                <optgroup label="CN">
                                    <option>Bachelor of Science in Nursing</option>
                                <optgroup label="COE">
                                    <option>Bachelor of Science in Civil Engineering</option>
                                    <option>Bachelor of Science in Computer Engineering</option>
                                    <option>Bachelor of Science in Electrical Engineering</option>
                                    <option>Bachelor of Science in Electronics Engineering</option>
                                    <option>Bachelor of Science in Industrial Engineering</option>
                                    <option>Bachelor of Science in Manufacturing Engineering</option>
                                    <option>Bachelor of Science in Mechanical Engineering</option>
                                    <option>Bachelor of Science in Mechatronics Engineering</option>
                                <optgroup label="COED">
                                    <option>Bachelor of Elementary Education</option>
                                    <option>Bachelor of Early Childhood Education</option>
                                    <option>Bachelor of Secondary Education Major in English minor in Mandarin</option>
                                    <option>Bachelor of Secondary Education Major in English minor in Mandarin</option>
                                    <option>Bachelor of Secondary Education Major in Sciences</option>
                                    <option>Bachelor of Secondary Education Major in Mathematics</option>
                                    <option>Bachelor of Secondary Education Major in Social Studies</option>
                                    <option>Bachelor of Secondary Education Major in Values Education</option>
                                    <option>Bachelor of Physical Education</option>
                                    <option>Bachelor of Technology and Livelihood Education Major in Industrial Arts
                                    </option>
                                    <option>Bachelor of Technology and Livelihood Education Major in Information and
                                        Communication Technology</option>
                                    <option>Bachelor of Technology and Livelihood Education Major in Home Economics
                                    </option>
                                <optgroup label="CS">
                                    <option>Bachelor of Science in Biology</option>
                                    <option>Bachelor of Science in Environmental Science</option>
                                    <option>Bachelor of Science in Food Technology</option>
                                    <option>Bachelor of Science in Math with Specialization in Computer Science</option>
                                    <option>Bachelor of Science in Math with Specialization in Applied Statistics
                                    </option>
                                    <option>Bachelor of Science in Math with Specialization in Business Applications
                                    </option>
                                <optgroup label="CSER">
                                    <option>Bachelor of Science in Exercise and Sports Sciences with specialization in
                                        Fitness and Sports Coaching</option>
                                    <option>Bachelor of Science in Exercise and Sports Sciences with specialization in
                                        Fitness and Sports Management</option>
                                    <option>Certificate of Physical Education</option>
                                <optgroup label="CSSP">
                                    <option>Bachelor of Public Administration</option>
                                    <option>Bachelor of Science in Social Work</option>
                                    <option>Bachelor of Science in Psychology</option>
                                <optgroup label="GS">
                                    <option>Doctor of Education</option>
                                    <option>Doctor of Philosophy</option>
                                    <option>Doctor of Public Administration</option>
                                    <option>Master in Physical Education</option>
                                    <option>Master in Business Administration</option>
                                    <option>Master in Public Administration</option>
                                    <option>Master of Arts in Education</option>
                                    <option>Master of Engineering Program</option>
                                    <option>Master of Industrial Technology Management</option>
                                    <option>Master of Science in Civil Engineering</option>
                                    <option>Master of Science in Computer Engineering</option>
                                    <option>Master of Science in Electronics and Communications Engineering</option>
                                    <option>Master of Information Technology</option>
                                    <option>Master of Manufacturing Engineering</option>
                             </select>
                            </div>

                            <div class="col-md-2">
                             <button type="submit" class="buttons">Filter</button>
                            </div>

                          </div>
                        </form>
                    </div>
                    <div class="recent-grid">
                      <div class="history">
                         <div class="card">
                           <div class="card-body">
                              <div class="table-responsive">
                                <section class="table__body">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th> Student No. <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> College <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Date <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Time-in <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Time-out <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Table No. <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Seat No. <span class="icon-arrow">&UpArrow;</span></th>
                                                <th> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="studno">2020104276</td>
                                                <td>COE</td>
                                                <td>4/24/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>4</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020104776</td>
                                                <td>CICT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104786</td>
                                                <td>CHTM</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>4/7/23</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020105771</td>
                                                <td>CICT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104974</td>
                                                <td>CICT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104226</td>
                                                <td>CLaw</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104717</td>
                                                <td>CIT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104724</td>
                                                <td>CICT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104778</td>
                                                <td>CLaw</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104798</td>
                                                <td>COE</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="studno">2020104732</td>
                                                <td>CSSP</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020103779</td>
                                                <td>CHTM</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020102770</td>
                                                <td>COE</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020109774</td>
                                                <td>COE</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020103736</td>
                                                <td>CIT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020101771</td>
                                                <td>COE</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020105276</td>
                                                <td>CIT</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020109777</td>
                                                <td>COE</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="studno">2020103779</td>
                                                <td>CSSP</td>
                                                <td>4/17/23</td>
                                                <td>10:30AM</td>
                                                <td>12:00PM</td>
                                                <td>42</td>
                                                <td>6</td>
                                                <td>
                                                    <p class="status pending"><a>See More</a></p>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </section>
                              </div>
                           </div>
                         </div>
                       </div>
                    </div>    
                </div>

                <!--- Analytics Code --->
                <div class="tab" id="analytics">
                   <div class="graphBox">
                      <div class="box">
                         <h4>Weekly Statistics</h4>
                         <div>
                           <canvas id="myChart"></canvas>
                         </div>
                       </div>
                       <div class="box">
                          <div>
                             <canvas id="myChart2"></canvas>
                          </div>
                       </div>
                   </div>

                   <div class="graphBox2">
                         <div class="box">
                           <h4>Monthly/Annual Statistics</h4>
                           <div>
                              <div class="filters">
                                 <div class="year" class="form-control">
                                     <label for="cars">Filter Year:</label>
                                     <select class="form-control">
                                        <option>2022</option>
                                        <option>2023</option>
                                     </select>
                                 </div>
 
                                  <div class="year-level" class="form-control">
                                       <label for="cars">Filter Year Level:</label>
                                       <select class="form-control">
                                         <option style="display:none">Select here</option>
                                         <option>1</option>
                                         <option>2</option>
                                         <option>3</option>
                                         <option>4</option>
                                     </select>
                                 </div>

                            <div class="college">
                                <label for="cars">Filter College:</label>
                                <select class="form-control">
                                    <option style="display:none">Select here</option>
                                    <option>CAFA</option>
                                    <option>CAL</option>
                                    <option>CBA</option>
                                    <option>CCJE</option>
                                    <option>CHTM</option>
                                    <option>CICT</option>
                                    <option>CIT</option>
                                    <option>CLaw</option>
                                    <option>CN</option>
                                    <option>COE</option>
                                    <option>COED</option>
                                    <option>CS</option>
                                    <option>CSER</option>
                                    <option>CSSP</option>
                                    <option>GS</option>
                                </select>
                            </div>

                        </div>
                        <canvas id="myChart3"></canvas>
                        <div class="print-report">
                            <a href="sample-doc.pdf" class="buttons">Print Report</a>
                        </div>
                    </div>
                 </div>
                </div>


            </div>
        </main>
    </div>








    <!--- modal view for pending reservation--->
    <div class="modal fade" id="staticBackdrop" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <div class="text-right"> <i class="bi bi-x-lg close" data-dismiss="modal"></i></div>
                                
                                    <div class="px-4 py-5">
                                        <img src="" id="user-picture" alt="user picture" class="rounded-circle p-1 bg-secondary mb-3" width="10" style="width: 100px; height: 100px;">
                                        
                                        <h5 class="text-uppercase" id="name_view"></h5>

                                    <h6 class="mt-2 theme-color mb-5" id="userID_view"></h6>

                                    <span class="font-weight-bold theme-color">User Information</span>
                                    <div class="mb-3">
                                        <hr class="new1">
                                    </div>

                                    

                                    <div class="d-flex justify-content-between">
                                        <small id="rfid_view">RFID No.:  </small>
                                        <small id="contact_view"></small>
                                    </div>
                                    

                                    <div class="d-flex justify-content-between">
                                        <small id="course_view">Course: </small>
                                        <small >Year and Section: </small>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <small id="">College</small>
                                        <small >Age: </small>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <small id="email_view"></small>
                                        <small > </small>
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

</body>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js
"></script>

<script src="js/admin.js"></script>
<script src="js/analytics.js"></script>

<script>
    //TO VIEW PENDING RESERVATION
$(document).ready(function() {
    
    $('.view_reservation').click(function() {
        
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
        
        $('#userID_view').text("User ID: " + userId);
        $('#date_view').text(date);
        $('#stime_view').text(startTime);
        $('#etime_view').text(endTime);
        $('#timeSpent_view').text(timeSpent);
        $('#email_view').text("Email:     " + email);
        $('#name_view').text(firstName + " " +  lastName);
        $('#user-picture').attr('src', pictureUrl);
        $('#rfid_view').text("RFID Number:     " + rfidNo);
        $('#course_view').text("Course:     " + courseCode);
        $('#contact_view').text("Contact No.:     " + rfidNo);
        $('#seat_view').text(seatId);
        
    });
});
</script>

</html>