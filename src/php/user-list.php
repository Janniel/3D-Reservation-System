<?php
session_start();
require 'connect.php';
require 'session.php';

$sql = "SELECT u.user_id, u.rfid_no, u.first_name, u.last_name, u.account_id, u.course_code, u.yearsec_id, u.age, u.contact_number, a.picture, a.email,  a.account_type, c.college_code
        FROM users AS u
        JOIN account a ON u.account_id = a.account_id
        LEFT JOIN course AS c ON u.course_code = c.course_code
        WHERE u.is_archived = 0 AND a.is_archived = 0";

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
    <link rel="stylesheet" type="text/css" href="css/user-list.css" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />



    <!------------------------ ICONS ------------------------>
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
                <li class="tabs"> <a href="../seats-info.php"><span class="las la-check"></span>
                        <span>Seats Information</span></a>
                </li>
                <li class="tabs"> <a href="reserved.php"><span class="las la-clock"></span>
                        <span>Reserved</span></a>
                </li>
                <li class="tabs"> <a href="user-list.php" class="active"><span class="las la-user-friends"></span>
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
                User List
            </h2>

            <div class="dropdown">
                <button class="dropdown-toggle" class="btn btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="user-wrapper">


                        <div id="user_admin">
                            <h4>
                                Hello,
                                <?php echo $_SESSION["first_name"]; ?>
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
        // Retrieve the username from the session
        $username = $_SESSION["username"];


        // Retrieve the user details from the database
        $sql = "SELECT * FROM ACCOUNT 
                    INNER JOIN USERS ON ACCOUNT.account_id = USERS.account_id   
                    INNER JOIN COURSE ON USERS.course_code = COURSE.course_code
                    INNER JOIN YEARSEC ON USERS.yearsec_id = YEARSEC.yearsec_id
                    INNER JOIN COLLEGE ON COURSE.college_code = COLLEGE.college_code
                    WHERE ACCOUNT.username = '$username'";
        ?>
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
            <div class="tab-content" id="myTabsContent" >
                <!-- Table Tab Content -->
                <div class="tab-pane fade show active" id="table-content" role="tabpanel" aria-labelledby="table-tab" >

                    <div class="recent-grid" >
                        <div class="history">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tableresponsive">

                                        <section class="table__header">
                                            <h1>Users</h1>
                                            <div class="input-group">
                                                <div class="search-icon">
                                                    <img src="../img/search.png" alt="Search">
                                                </div>
                                                <input type="search" placeholder="Search Data...">
                                            </div>

                                            <div class="export__file">
                                                <label for="export-file" class="export__file-btn" title="Export File">
                                                    <!-- <img src="../img/export1.png" alt="Export" class="export_ic"> -->
                                                </label>
                                                <input type="checkbox" id="export-file">
                                                <div class="export__file-options">
                                                    <label>Export As &nbsp; &#10140;</label>
                                                    <label for="export-file" id="toPDF">PDF <img src="../img/pdf.png"
                                                            alt=""></label>
                                                    <label for="export-file" id="toJSON">JSON <img src="../img/json.png"
                                                            alt=""></label>
                                                    <label for="export-file" id="toCSV">CSV <img src="../img/csv.png"
                                                            alt=""></label>
                                                    <label for="export-file" id="toEXCEL">EXCEL <img
                                                            src="../img/excel.png" alt=""></label>
                                                </div>
                                            </div>
                                        </section>


                                        <div class="filter">
                                            <form action="brw_history.php" method="GET">
                                                <div class="row">
                                                    <div class="floor" class="form-control">
                                                        <label for="cars">User Type</label>
                                                        <select class="form-control" name="user-type-filter"
                                                            id="user-type-filter">
                                                            <option value="All" selected>All</option>
                                                            <option value="student">student</option>
                                                            <option value="faculty">faculty</option>
                                                            <option value="alumni">alumni</option>
                                                        </select>
                                                    </div>
                                                    <div class="college">
                                                        <label for="college-filter">College</label>
                                                        <select class="form-control" name="college-filter"
                                                            id="college-filter">
                                                            <option value="" selected>All</option>
                                                            <?php
                                                            // Replace with your database connection code
                                                            require 'connect.php';

                                                            // Query to fetch colleges from the database
                                                            $collegeQuery = "SELECT college_code, college_name FROM college";

                                                            $collegeResult = $conn->query($collegeQuery);

                                                            if ($collegeResult->num_rows > 0) {
                                                                while ($row = $collegeResult->fetch_assoc()) {
                                                                    echo "<option value='" . $row['college_code'] . "'>" . $row['college_code'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="course">
                                                        <label for="course-filter">Course</label>
                                                        <select class="form-control" name="course-filter"
                                                            id="course-filter">
                                                            <option value="" selected>All</option>
                                                            <?php
                                                            // Replace with your database connection code
                                                            require 'connect.php';

                                                            // Query to fetch courses from the database
                                                            $courseQuery = "SELECT course_code, course_name FROM course";

                                                            $courseResult = $conn->query($courseQuery);

                                                            if ($courseResult->num_rows > 0) {
                                                                while ($row = $courseResult->fetch_assoc()) {
                                                                    echo "<option value='" . $row['course_code'] . "'>" . $row['course_name'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" id="clear-filter-all"
                                                            class="buttons">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>



                                        <section class="table__body">
                                            <table id="users_table">
                                                <thead>
                                                    <tr>
                                                        <th id="all-users-id"> User ID <span
                                                                class="icon-arrow">&UpArrow;</span></th>
                                                        <th> RFID No. <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th></th>
                                                        <th> First Name <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Last Name <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Course Code <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> College Code <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> User Type <span class="icon-arrow">&UpArrow;</span></th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <tr id="user_row_<?php echo $row['user_id']; ?>">
                                                            <td class="studno">
                                                                <?php echo $row['user_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['rfid_no']; ?>
                                                            </td>
                                                            <td><img src="<?php echo $row['picture']; ?>" alt=""></td>
                                                            <td>
                                                                <?php echo $row['first_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['last_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['email']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['course_code']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['college_code']; ?>
                                                            </td>

                                                            <td>
                                                                <p
                                                                    class="user-type <?php echo strtolower($row['account_type']); ?>">
                                                                    <?php echo $row['account_type']; ?>
                                                                </p>
                                                            </td>


                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon view_user"
                                                                    data-toggle="modal" data-target="#modalView"
                                                                    data-userid="<?php echo $row['user_id']; ?>"
                                                                    data-firstname="<?php echo $row['first_name']; ?>"
                                                                    data-lastname="<?php echo $row['last_name']; ?>"
                                                                    data-picture="<?php echo $row['picture']; ?>"
                                                                    data-email="<?php echo $row['email']; ?> "
                                                                    data-rfidno="<?php echo $row['rfid_no']; ?> "
                                                                    data-course="<?php echo $row['course_code']; ?> "
                                                                    data-age="<?php echo $row['age']; ?> ">

                                                                    <i class="bi bi-eye-fill text-primary"
                                                                        style="font-size: 1.2em;"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon edit_user"
                                                                    data-toggle="modal" data-target="#editUser"
                                                                    data-userid="<?php echo $row['user_id']; ?>"
                                                                    data-firstname="<?php echo $row['first_name']; ?>"
                                                                    data-lastname="<?php echo $row['last_name']; ?>"
                                                                    data-picture="<?php echo $row['picture']; ?>"
                                                                    data-email="<?php echo $row['email']; ?> "
                                                                    data-rfidno="<?php echo $row['rfid_no']; ?> "
                                                                    data-course="<?php echo $row['course_code']; ?> "
                                                                    data-college="<?php echo $row['college_code']; ?> "
                                                                    data-type="<?php echo $row['account_type']; ?>"
                                                                    data-age="<?php echo $row['age']; ?> ">
                                                                    <i class="bi bi-pencil-square text-warning"
                                                                        style="font-size: 1.2em;"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-light btn-rounded btn-icon archive_btn"
                                                                    data-user-id="<?php echo $row['user_id']; ?>">
                                                                    <i class="bi bi-trash-fill text-danger"
                                                                        style="font-size: 1.2em;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No users found.</td></tr>";
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
                    <div id="archive-user-container">
                        <div class="recent-grid">
                            <div class="archived_reservation">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tableresponsive">

                                            <section class="table__header">
                                                <h1>Archived Users</h1>
                                                <div class="input-group">
                                                    <div class="search-icon">
                                                        <img src="../img/search.png" alt="Search">
                                                    </div>
                                                    <input type="search" placeholder="Search Data...">
                                                </div>

                                                <div class="export__file">
                                                    <label for="export-file-archive" class="export__file-btn"
                                                        title="Export File">
                                                        <!-- <img src="../img/export1.png" alt="Export" class="export_ic"> -->
                                                    </label>
                                                    <input type="checkbox" id="export-file-archive">
                                                    <div class="export__file-options">
                                                        <label>Export As &nbsp; &#10140;</label>
                                                        <label for="export-file-archive" id="toPDFArchive">PDF <img
                                                                src="../img/pdf.png" alt=""></label>
                                                        <label for="export-file-archive" id="toJSONArchive">JSON <img
                                                                src="../img/json.png" alt=""></label>
                                                        <label for="export-file-archive" id="toCSVArchive">CSV <img
                                                                src="../img/csv.png" alt=""></label>
                                                        <label for="export-file-archive" id="toEXCELArchive">EXCEL <img
                                                                src="../img/excel.png" alt=""></label>
                                                    </div>
                                                </div>
                                            </section>



                                            <div class="filter">
                                                <form action="brw_history.php" method="GET">
                                                    <div class="row">
                                                        <div class="floor" class="form-control">
                                                            <label for="cars">User Type</label>
                                                            <select class="form-control"
                                                                name="user-type-archived-filter"
                                                                id="archive-user-type-archived-filter">
                                                                <option value="All" selected>All</option>
                                                                <option value="student">student</option>
                                                                <option value="faculty">faculty</option>
                                                                <option value="alumni">alumni</option>
                                                            </select>
                                                        </div>
                                                        <div class="college">
                                                            <label for="college-archived-filter">College</label>
                                                            <select class="form-control" name="college-archived-filter"
                                                                id="archive-college-archived-filter">
                                                                <option value="" selected>All</option>
                                                                <?php
                                                                // Replace with your database connection code
                                                                require 'connect.php';

                                                                // Query to fetch colleges from the database
                                                                $collegeQuery = "SELECT college_code, college_name FROM college";

                                                                $collegeResult = $conn->query($collegeQuery);

                                                                if ($collegeResult->num_rows > 0) {
                                                                    while ($row = $collegeResult->fetch_assoc()) {
                                                                        echo "<option value='" . $row['college_code'] . "'>" . $row['college_code'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="course">
                                                            <label for="course-filter">Course</label>
                                                            <select class="form-control" name="course-archived-filter"
                                                                id="archive-course-archived-filter">
                                                                <option value="" selected>All</option>
                                                                <?php
                                                                // Replace with your database connection code
                                                                require 'connect.php';

                                                                // Query to fetch courses from the database
                                                                $courseQuery = "SELECT course_code, course_name FROM course";

                                                                $courseResult = $conn->query($courseQuery);

                                                                if ($courseResult->num_rows > 0) {
                                                                    while ($row = $courseResult->fetch_assoc()) {
                                                                        echo "<option value='" . $row['course_code'] . "'>" . $row['course_name'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" id="clear-filter-archived"
                                                                class="buttons">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>




                                            <section class="table__body">
                                                <table id="archivedUsers_table">
                                                    <thead>
                                                        <tr>
                                                            <th> User ID <span class="icon-arrow">&UpArrow;</span></th>
                                                            <th> RFID No. <span class="icon-arrow">&UpArrow;</span></th>
                                                            <th></th>
                                                            <th> First Name <span class="icon-arrow">&UpArrow;</span>
                                                            </th>
                                                            <th> Last Name <span class="icon-arrow">&UpArrow;</span>
                                                            </th>
                                                            <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                                                            <th> Course Code <span class="icon-arrow">&UpArrow;</span>
                                                            </th>
                                                            <th> College Code <span class="icon-arrow">&UpArrow;</span>
                                                            </th>
                                                            <th> User Type <span class="icon-arrow">&UpArrow;</span>
                                                            </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $archiveSql = "SELECT u.user_id, u.rfid_no, u.first_name, u.last_name, u.account_id, u.course_code, u.yearsec_id, u.age, u.contact_number, a.picture, a.email,  a.account_type, c.college_code
                                                    FROM users AS u
                                                    JOIN account a ON u.account_id = a.account_id
                                                    LEFT JOIN course AS c ON u.course_code = c.course_code
                                                    WHERE u.is_archived = 1";

                                                    $archiveResult = $conn->query($archiveSql);

                                                    if ($archiveResult->num_rows > 0) {
                                                        while ($row = $archiveResult->fetch_assoc()) {
                                                            ?>
                                                            <tr id="archivedUser_row_<?php echo $row['user_id']; ?>">
                                                                <td class="studno">
                                                                    <?php echo $row['user_id']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['rfid_no']; ?>
                                                                </td>
                                                                <td><img src="<?php echo $row['picture']; ?>" alt=""></td>
                                                                <td>
                                                                    <?php echo $row['first_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['last_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['email']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['course_code']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['college_code']; ?>
                                                                </td>

                                                                <td>
                                                                    <p
                                                                        class="user-type <?php echo strtolower($row['account_type']); ?>">
                                                                        <?php echo $row['account_type']; ?>
                                                                    </p>
                                                                </td>


                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-rounded btn-icon view_user"
                                                                        data-toggle="modal" data-target="#modalView"
                                                                        data-userid="<?php echo $row['user_id']; ?>"
                                                                        data-firstname="<?php echo $row['first_name']; ?>"
                                                                        data-lastname="<?php echo $row['last_name']; ?>"
                                                                        data-picture="<?php echo $row['picture']; ?>"
                                                                        data-email="<?php echo $row['email']; ?> "
                                                                        data-rfidno="<?php echo $row['rfid_no']; ?> "
                                                                        data-course="<?php echo $row['course_code']; ?> "
                                                                        data-age="<?php echo $row['age']; ?> ">

                                                                        <i class="bi bi-eye-fill text-primary"
                                                                            style="font-size: 1.2em;"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-rounded btn-icon restore_btn"
                                                                        data-user-id="<?php echo $row['user_id']; ?>"
                                                                        onclick="restoreUser(<?php echo $row['user_id']; ?>)">
                                                                        <i class="bi bi-arrow-counterclockwise text-warning"
                                                                            style="font-size: 1.2em;"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-rounded btn-icon delete_btn"
                                                                        data-user-id="<?php echo $row['user_id']; ?>">
                                                                        <i class="bi bi-trash-fill text-danger"
                                                                            style="font-size: 1.2em;"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='7'>No users found.</td></tr>";
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

            </div>
            <!-- Modal for edit -->
            <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAccountLabel">Edit User Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-body" style="padding:10px 40px;">
                                <div class="form-group text-center pb-2">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="name">User ID</label>
                                        <input type="text" id="userId-input" class="form-control" placeholder="Jhon"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="name">RFID</label>
                                        <input type="text" id="rfid-input" class="form-control" placeholder="Doe"
                                            required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="name">First Name</label>
                                        <input type="text" id="firstname-input" class="form-control" placeholder="Jhon"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="name">Last Name</label>
                                        <input type="text" id="lastname-input" class="form-control" placeholder="Doe"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group" style="position:relative;">
                                    <label for="email">Email</label>
                                    <input type="email" id="email-input" class="form-control mb-1"
                                        placeholder="example@gmail.com" required>

                                </div>


                                <form id="profile-picture-form" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="picture">Profile Picture</label>
                                        </div>
                                        <div class="col-sm-9 text-secondary">

                                            <input type="file" class="form-control" id="inputGroupFile01"
                                                name="profile_picture">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group" style="position:relative;">
                                        <label for="user-type">User Type</label>
                                        <select class="form-control" id="type-input">
                                            <option value='student'>student</option>
                                            <option value='faculty'>faculty</option>
                                            <option value='alumni'>alumni</option>
                                        </select>
                                    </div>



                                    <div class="form-group" style="position:relative;">
                                        <label for="course">Course</label>
                                        <select class="form-control" id="course-input">
                                            <option hidden disabled selected value> -- select an option -- </option>
                                            <?php
                                            // Replace with your database connection code
                                            require 'connect.php';

                                            // Query to fetch course codes from the database while excluding Alumni and Faculty
                                            $courseQuery = "SELECT course_code FROM course";

                                            $courseResult = $conn->query($courseQuery);

                                            if ($courseResult->num_rows > 0) {
                                                while ($row = $courseResult->fetch_assoc()) {
                                                    echo "<option value='" . $row['course_code'] . "'>" . $row['course_code'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>



                                    <hr>




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                                <a id="save_btn" class="btn btn-danger" type="submit" form="a-form">Save</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




            <!--- modal for view--->
            <div class="modal fade" id="modalView" data-backdrop="true" data-keyboard="false" tabindex="-1"
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
                                    <small id="">College</small>
                                    <small id="age_view">Age: </small>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <small id="email_view"></small>
                                    <small> </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



        </main>

        <!--- modal for view--->
        <div class="modal fade" id="modalView" data-backdrop="true" data-keyboard="false" tabindex="-1"
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
                                <small id="">College</small>
                                <small id="age_view">Age: </small>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <small id="email_view"></small>
                                <small> </small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
                crossorigin="anonymous"></script>


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
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous">
                </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                crossorigin="anonymous">
                </script>
            <!-- Font Awesome -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>


            <script src="js/users.js"></script>

            <script>
                $(document).ready(function () {

                    $('.view_user').click(function () {
                        // Get the data attributes from the clicked button
                        var userId = $(this).data('userid');
                        var email = $(this).data('email');
                        var firstName = $(this).data('firstname');
                        var lastName = $(this).data('lastname');
                        var rfidNo = $(this).data('rfidno');

                        var courseCode = $(this).data('course');
                        var pictureUrl = $(this).data('picture');
                        var age = $(this).data('age');

                        // Set the retrieved values in the modal
                        $('#userID_view').text("User ID: " + userId);
                        $('#email_view').text("Email:     " + email);
                        $('#name_view').text(firstName + " " + lastName);
                        $('#user-picture').attr('src', pictureUrl);
                        $('#rfid_view').text("RFID Number:     " + rfidNo);
                        $('#course_view').text("Course:     " + courseCode);

                        $('#age_view').text("Age:     " + age);
                        $('#seat_view').text(seatId);

                    });
                });

            </script>






            <script>


                document.addEventListener("DOMContentLoaded", function () {
                    // Attach a click event listener to all archive buttons
                    const archiveButtons = document.querySelectorAll(".archive_btn");
                    archiveButtons.forEach(function (button) {
                        button.addEventListener("click", function () {
                            const userId = this.getAttribute("data-user-id");

                            // Show a SweetAlert confirmation dialog
                            Swal.fire({
                                title: "Archive User",
                                text: "Are you sure you want to archive this user?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Archive",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If the user confirms, set is_archive to 1 using an AJAX request
                                    archiveUser(userId);
                                }
                            });
                        });
                    });

                    // Function to archive the user using AJAX
                    function archiveUser(userId) {
                        // Send an AJAX request to update the is_archive field in the database
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "toArchiveUser.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    Swal.fire("User Archived!", "The user has been archived.", "success");

                                    const userRow = document.getElementById("user_row_" + userId);
                                    if (userRow) {
                                        userRow.remove();
                                    }
                                } else {
                                    Swal.fire("Error", "Failed to archive the user.", "error");
                                }
                            }
                        };
                        xhr.send("userId=" + userId);
                    }
                });

            </script>

            <script>
                //RESTORE FROM ARCHIVE

                function restoreUser(userId) {

                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "toRestoreUser.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                Swal.fire("User Restored!", "The user has been restored.", "success");


                                const userRow = document.getElementById("archivedUser_row_" + userId);
                                if (userRow) {
                                    userRow.remove();
                                }
                            } else {
                                Swal.fire("Error", "Failed to restore the user.", "error");
                            }
                        }
                    };
                    xhr.send("userId=" + userId);
                }

            </script>

            <script>
                if (typeof jQuery !== 'undefined') {
                    // jQuery is loaded
                    $(document).ready(function () {
                        // Your code that uses jQuery
                        const deleteButtons = document.querySelectorAll('.delete_btn');

                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                console.log('Delete button clicked');
                                const userId = button.getAttribute('data-user-id');

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
                                        console.log('Sending DELETE request...'); // Add this line for debugging
                                        $.ajax({
                                            url: "toDeleteUser.php",
                                            type: "DELETE",
                                            data: { userId: userId },
                                            success: function (response) {
                                                console.log('DELETE request successful'); // Add this line for debugging
                                                if (response.success) {
                                                    // User deletion was successful
                                                    const deletedRow = document.getElementById("archivedUser_row_" + userId);
                                                    if (deletedRow) {
                                                        deletedRow.remove();
                                                    }
                                                    Swal.fire('Deleted!', 'The user has been deleted.', 'success');
                                                } else {
                                                    // User deletion failed
                                                    Swal.fire('Error', 'An error occurred while deleting the user.', 'error');
                                                }
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                console.log('DELETE request failed:', textStatus, errorThrown); // Add this line for debugging
                                                Swal.fire('Error', 'An error occurred while making the DELETE request.', 'error');
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    });
                } else {
                    // jQuery is not loaded
                    console.log('jQuery is not loaded. Please make sure jQuery is included.');
                }


            </script>

            <script>
                //Filter user type, college, and course /  ALL TAB
                $(document).ready(function () {
                    $("#user-type-filter, #college-filter, #course-filter").on("change", function () {
                        var selectedUserType = $("#user-type-filter").val();
                        var selectedCollegeCode = $("#college-filter").val();
                        var selectedCourseCode = $("#course-filter").val();
                        filterTable(selectedUserType, selectedCollegeCode, selectedCourseCode);
                    });

                    function filterTable(userType, collegeCode, courseCode) {
                        $("table#users_table tbody tr").each(function () {
                            var userRow = $(this);
                            var userTypeCell = userRow.find(".user-type");
                            var collegeCodeCell = userRow.find("td:eq(7)"); // 8th column (index 7) for college code
                            var courseCodeCell = userRow.find("td:eq(6)"); // 7th column (index 6) for course code

                            var accountType = userTypeCell.text().trim().toLowerCase();
                            var rowCollegeCode = collegeCodeCell.text().trim();
                            var rowCourseCode = courseCodeCell.text().trim();

                            if ((userType === "All" || accountType === userType) &&
                                (collegeCode === "" || rowCollegeCode === collegeCode) &&
                                (courseCode === "" || rowCourseCode === courseCode)) {
                                userRow.show();
                            } else {
                                userRow.hide();
                            }
                        });
                    }
                    // Add a click event handler for the "Clear" button
                    $("#clear-filter-all").click(function () {
                        // Reload the page when the "Clear" button is clicked
                        location.reload();
                    });
                });

            </script>

            <script>
                $(document).ready(function () {
                    $("#archive-user-type-archived-filter, #archive-college-archived-filter, #archive-course-archived-filter").on("change", function () {
                        var selectedUserTypeArchived = $("#archive-user-type-archived-filter").val();
                        var selectedCollegeCodeArchived = $("#archive-college-archived-filter").val();
                        var selectedCourseCodeArchived = $("#archive-course-archived-filter").val();
                        filterTableArchived(selectedUserTypeArchived, selectedCollegeCodeArchived, selectedCourseCodeArchived);
                    });

                    function filterTableArchived(userTypeArchived, collegeCodeArchived, courseCodeArchived) {
                        $("table#archivedUsers_table tbody tr").each(function () {
                            var userRowArchived = $(this);
                            var userTypeCellArchived = userRowArchived.find(".user-type");
                            var collegeCodeCellArchived = userRowArchived.find("td:eq(7)"); // 8th column (index 7) for college code
                            var courseCodeCellArchived = userRowArchived.find("td:eq(6)"); // 7th column (index 6) for course code

                            var accountTypeArchived = userTypeCellArchived.text().trim().toLowerCase();
                            var rowCollegeCodeArchived = collegeCodeCellArchived.text().trim();
                            var rowCourseCodeArchived = courseCodeCellArchived.text().trim();

                            if ((userTypeArchived === "All" || accountTypeArchived === userTypeArchived) &&
                                (collegeCodeArchived === "" || rowCollegeCodeArchived === collegeCodeArchived) &&
                                (courseCodeArchived === "" || rowCourseCodeArchived === courseCodeArchived)) {
                                userRowArchived.show();
                            } else {
                                userRowArchived.hide();
                            }
                        });
                    }

                    // Add a click event handler for the "Clear" button
                    $("#clear-filter-archived").click(function () {
                        // Reload the page when the "Clear" button is clicked
                        location.reload();
                    });



                });




            </script>
            <script>
                $(document).ready(function () {
                    // Add a click event listener to the "Edit" button in your table rows
                    $(".edit_user").on("click", function () {
                        // Capture the data attributes from the clicked row
                        var userId = $(this).data('userid');
                        var rfidNo = $(this).data('rfidno');
                        var Email = $(this).data('email');
                        var firstName = $(this).data('firstname');
                        var lastName = $(this).data('lastname');
                        var accountType = $(this).data('type');
                        var collegeCode = $(this).data('college');
                        var courseCode = $(this).data('course');
                        var profilePicture = $(this).data('picture');

                        // Set the captured data in the modal input fields
                        $("#userId-input").val(userId);
                        $("#rfid-input").val(rfidNo);
                        $('#email-input').val(Email);
                        $("#firstname-input").val(firstName);
                        $("#lastname-input").val(lastName);

                        // Set the selected option in the "User Type" dropdown
                        $("#type-input").val(accountType);
                        $("#college-input").val(collegeCode);
                        $("#course-input").val(courseCode);
                        $("#inputGroupFile01").val(profilePicture);

                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    // Add a change event listener to the user type dropdown
                    $("#type-input").on("change", function () {
                        var userType = $(this).val();
                        var courseInput = $("#course-input");
                        var collegeInput = $("#college-input");

                        if (userType === 'alumni') {
                            // Set the course dropdown to 'Alumni' and disable it
                            courseInput.val('Alumni').prop('disabled', true);
                            collegeInput.val('').prop('disabled', true);
                        }
                        else if (userType === 'faculty') {
                            courseInput.val('Faculty').prop('disabled', true);
                            collegeInput.val('').prop('disabled', true);
                        }
                        else {
                            // Enable the course dropdown and reset its selection
                            courseInput.prop('disabled', false).val('-- select an option --');
                            collegeInput.html('<option hidden disabled selected value> -- select an option -- </option>').prop('disabled', true);
                        }
                    });



                    // Add a click event listener to the "Edit" button in your table rows
                    $(".edit_user").on("click", function () {
                        // Capture the data attributes from the clicked row
                        var userId = $(this).data('userid');
                        var rfidNo = $(this).data('rfidno');
                        var email = $(this).data('email');
                        var firstName = $(this).data('firstname');
                        var lastName = $(this).data('lastname');
                        var accountType = $(this).data('type');
                        var courseCode = $(this).data('course');
                        var profilePicture = $(this).data('picture');



                        // Set the captured data in the modal input fields
                        $("#userId-input").val(userId);
                        $("#rfid-input").val(rfidNo);
                        $('#email-input').val(email);
                        $("#firstname-input").val(firstName);
                        $("#lastname-input").val(lastName);
                        $("#type-input").val(accountType);
                        $("#course-input").val(courseCode);
                        $("#inputGroupFile01").val(profilePicture);


                        // Automatically set the college code based on the selected course code
                        setCollegeBasedOnCourse(courseCode);
                    });



                    function setCollegeBasedOnCourse(courseCode) {
                        var collegeInput = $("#college-input");

                        // If there's a course code, find the corresponding college code
                        if (courseCode) {
                            var selectedCourseOption = $("#course-input option[value='" + courseCode + "']");
                            var collegeCode = selectedCourseOption.data('college-code');

                            if (collegeCode) {
                                collegeInput.val(collegeCode);
                            }
                        }
                    }

                    // When the "Save" button is clicked in the modal
                    $("#save_btn").on("click", function () {
                        // Gather data from the modal form
                        var userId = $("#userId-input").val();
                        var rfidNo = $("#rfid-input").val();
                        var email = $('#email-input').val();
                        var firstName = $("#firstname-input").val();
                        var lastName = $("#lastname-input").val();
                        var courseCode = $("#course-input").val();
                        var accountType = $("#type-input").val();

                        // Check if required fields are empty
                        if (
                            userId === '' ||
                            rfidNo === '' ||
                            email === '' ||
                            firstName === '' ||
                            lastName === '' ||
                            courseCode === '' ||
                            accountType === ''
                        ) {
                            Swal.fire('Error', 'All fields are required.', 'error');
                            return; // Prevent form submission
                        }

                        // Capture the selected picture file
                        var pictureFile = $("#inputGroupFile01")[0].files[0];

                        // Create a FormData object to send the data and the picture file
                        var formData = new FormData();
                        formData.append('userId', userId);
                        formData.append('rfidNo', rfidNo);
                        formData.append('email', email);
                        formData.append('firstName', firstName);
                        formData.append('lastName', lastName);
                        formData.append('courseCode', courseCode);
                        formData.append('accountType', accountType);

                        formData.append('profile_picture', pictureFile); // Append the picture file

                        // Send an AJAX request to toUpdateAcc.php to update the user's information
                        $.ajax({
                            url: 'toUpdateUserList.php',
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                var parsedResponse = JSON.parse(response);

                                if (parsedResponse.status === 'success') {
                                    // Show a success SweetAlert
                                    Swal.fire('Success', 'User information updated successfully.', 'success');

                                    // Refresh the page after a short delay (e.g., 2 seconds)
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    // Show an error SweetAlert
                                    Swal.fire('Error', 'Error updating user information.', 'error');
                                }
                            }
                        });
                    });
                });
            </script>




</html>