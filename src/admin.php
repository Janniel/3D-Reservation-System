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
                <h2> <span>SOAR Admin</span></h2>
            </div>

            <div class="sidebar-menu" id="tabButton">
                <ul>
                    <li class="tabs"> <a href="admin.php" data-tabName="dashboard" class="dashboard active" id="tabButtons"><span
                                class="las la-th-large"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="tabs"> <a href="seats-info.php" ><span class="las la-check"></span>
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
                            <h4>
                                Hello, <?php echo $_SESSION["first_name"]; ?>
                            </h4>
                            
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
                        <?php
                        $status = '0'; // Status code for Occupied
                        $sqlUnoccupied = "SELECT COUNT(*) AS unoccupied_count FROM seat WHERE status = '$status'";
                        $resultUnoccupied = $conn->query($sqlUnoccupied);
                        
                        if (!$resultUnoccupied) {
                            // Handle the query error here
                            echo "Error: " . $conn->error;
                        } else {
                            $row = $resultUnoccupied->fetch_assoc();
                            $unoccupiedCount = $row['unoccupied_count'];
                        }
                        ?>
                        <div class="counter col_fourth">
                            <i class="las la-check"></i>
                            <h2 class="timer count-title count-number" data-to="<?php echo $unoccupiedCount; ?>" data-speed="1000"></h2>
                            <p class="count-text ">Unoccupied</p>
                        </div>

                        <?php
                        $status = '1'; // Status code for Occupied
                        $sqlOccupied = "SELECT COUNT(*) AS occupied_count FROM seat WHERE status = '$status'";
                        $resultOccupied = $conn->query($sqlOccupied);
                        
                        if (!$resultOccupied) {
                            // Handle the query error here
                            echo "Error: " . $conn->error;
                        } else {
                            $row = $resultOccupied->fetch_assoc();
                            $occupiedCount = $row['occupied_count'];
                        }
                        ?>

                        <div class="counter col_fourth">
                            <i class="las la-user"></i>
                            <h2 class="timer count-title count-number" data-to="<?php echo $occupiedCount; ?>" data-speed="1000"></h2>
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

                        <?php
                        $status = '404'; // Status code for Maintenance
                        $sqlMaintenance = "SELECT COUNT(*) AS maintenance_count FROM seat WHERE status = '$status'";
                        $resultMaintenance = $conn->query($sqlMaintenance);
                        
                        if (!$result) {
                            // Handle the query error here
                            echo "Error: " . $conn->error;
                        } else {
                            $row = $resultMaintenance->fetch_assoc();
                            $maintenanceCount = $row['maintenance_count'];
                        }
                        ?>
                      
                        <div class="counter col_fourth end">
                            <i class="las la-tools"></i>
                            <h2 class="timer count-title count-number" data-to="<?php echo $maintenanceCount; ?>" data-speed="1000"></h2>
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