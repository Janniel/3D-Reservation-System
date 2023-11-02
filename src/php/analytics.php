<?php
session_start();
require 'connect.php';
require 'session.php';

//ANALYTICS 1
$sqlCollege = "SELECT c.college_code, COUNT(u.user_id) AS user_count
        FROM reservation AS r
        INNER JOIN account AS a ON r.user_id = a.username
        INNER JOIN users AS u ON r.user_id = u.user_id
        LEFT JOIN course AS c ON u.course_code = c.course_code
        WHERE r.is_archived = 0
        GROUP BY c.college_code";

$resultCollege = $conn->query($sqlCollege);

$collegeCodes = [];
$userCounts = [];

while ($row = $resultCollege->fetch_assoc()) {
    $collegeCodes[] = $row['college_code'];
    $userCounts[] = $row['user_count'];
}


// ANALYTICS 2
$sql = "SELECT DATE_FORMAT(date, '%W') AS day, COUNT(*) AS reservation_count 
        FROM history 
        WHERE is_archived = 0 
        GROUP BY day 
        ORDER BY FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')";

$result = $conn->query($sql);

$daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
$reservationCounts2 = array_fill(0, 7, 0); // Use a different variable name, e.g., reservationCounts2

while ($row = $result->fetch_assoc()) {
    $dayIndex = array_search($row['day'], $daysOfWeek);
    if ($dayIndex !== false) {
        $reservationCounts2[$dayIndex] = $row['reservation_count'];
    }
}

// ANALYTICS 3
$sqlMonth = "SELECT DATE_FORMAT(date, '%c') AS month, COUNT(*) AS reservation_count 
        FROM reservation
        WHERE is_archived = 0
        GROUP BY month";
$resultMonth = $conn->query($sqlMonth);

$months = range(1, 12); // An array from 1 (January) to 12 (December)
$reservationCounts3 = array(); // Use a different variable name, e.g., reservationCounts3

// Initialize an array with zeros for all months
$monthData = [];

while ($row = $resultMonth->fetch_assoc()) {
    $month = (int)$row['month'];
    $reservationCounts3[] = $row['reservation_count'];

    // Add the data for this month
    $monthData[$month] = $row['reservation_count'];
}

// Fill in missing months with 0 counts
$finalData = [];

foreach ($months as $month) {
    if (array_key_exists($month, $monthData)) {
        $finalData[] = $monthData[$month];
    } else {
        $finalData[] = 0;
    }
}

$monthLabels = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];


//WEEKLY ANALYTICS 3
$sqlWeek = "SELECT DATE_FORMAT(date, '%U') AS week, COUNT(*) AS reservation_count
            FROM reservation
            WHERE is_archived = 0
            GROUP BY week
            ORDER BY week";

$result = $conn->query($sqlWeek);

$weeks = range(0, 51); // An array from 0 to 51 (weeks in a year)
$weekCounts = [];

// Initialize an array with zeros for all weeks
$weekData = [];

while ($row = $result->fetch_assoc()) {
    $week = (int)$row['week'];
    $weekCounts[] = $row['reservation_count'];

    // Add the data for this week
    $weekData[$week] = $row['reservation_count'];
}

// Fill in missing weeks with 0 counts
$finalWeekData = [];

foreach ($weeks as $week) {
    if (array_key_exists($week, $weekData)) {
        $finalWeekData[] = $weekData[$week];
    } else {
        $finalWeekData[] = 0;
    }
}



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
    <link rel="stylesheet" type="text/css" href="css/analytics.css" />

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                <li class="tabs"> <a href="analytics.php" class="active"><span class="las la-chart-bar"></span>
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
                Analytics
            </h2>

            <div class="dropdown">
                <button class="dropdown-toggle" class="btn btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="user-wrapper">
                        <h4>
                            Hello, <?php echo $_SESSION["first_name"]; ?>
                        </h4>
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
            <div class="graphBox">
                <div class="box">
                    <h4>Reservations per College</h4>
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

            <?php 
            $sqlUniqueYears = "SELECT DISTINCT YEAR(date) AS year FROM reservation WHERE is_archived = 0";
            $resultUniqueYears = $conn->query($sqlUniqueYears);

            $availableYears = [];

            while ($row = $resultUniqueYears->fetch_assoc()) {
                $availableYears[] = $row['year'];
            }
            ?>

            <div class="graphBox2">
                <div class="box">
                    <h4>Monthly/Anually Statistics</h4>
                    <div>

                        <div class="filters">

                            <div class="year" class="form-control">
                                <label for="year">Filter Year:</label>
                                <select class="form-control" id="yearSelect" onchange="updateChart()">
                                <?php
                                
                                foreach ($availableYears as $year) {
                                    echo "<option>{$year}</option>";
                                }
                                ?>
                                </select>
                            </div>

                            <!-- <div class="college">
                                <label for="cars">Filter College:</label>
                                <select class="form-control" id="collegeSelect">
                                    <option style="display:none">Select here</option>
                                    
                                </select>
                            </div> -->

                        </div>
                        <canvas id="myChart3"></canvas>
                        <!--<div class="print-report">
                            <a href="sample-doc.pdf" class="buttons">Print Report</a>
                        </div> -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js
"></script>


<script>
    var weeklyData = <?php echo json_encode($finalWeekData); ?>;
    var collegeCodes = <?php echo json_encode($collegeCodes); ?>;
    var userCounts = <?php echo json_encode($userCounts); ?>;
    var daysOfWeek = <?php echo json_encode($daysOfWeek); ?>;
    var reservationCounts2 = <?php echo json_encode($reservationCounts2); ?>;
    var monthLabels = <?php echo json_encode($monthLabels); ?>;
    var finalData = <?php echo json_encode($finalData); ?>;





</script>


</html>