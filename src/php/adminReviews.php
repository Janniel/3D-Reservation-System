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
    <link rel="stylesheet" type="text/css" href="css/adminReviews.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

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
                <li class="tabs"> <a href="user-list.php"><span class="las la-user-friends"></span>
                        <span>User List</span></a>
                </li>
                <li class="tabs"> <a href="history.php"><span class="las la-history"></span>
                        <span>History</span></a>
                </li>
                <li class="tabs"> <a href="adminReviews.php" class="active"><span class="las la-star"></span>
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
                User Reviews
            </h2>

            <div class="dropdown">
                <button class="dropdown-toggle" class="btn btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="user-wrapper">
                        <h4>
                            Hello,
                            <?php echo $_SESSION["first_name"]; ?>
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

    <div class="main-content">

        <main>
            <div class="dashboard">
                <?php
                $query = "SELECT rating, COUNT(*) AS count FROM rating GROUP BY rating";

                $result = $conn->query($query);

                $ratings = [];
                while ($row = $result->fetch_assoc()) {
                    $ratings[$row['rating']] = $row['count'];
                }

                $totalRatings = array_sum($ratings);

                $percentageRatings = [];
                foreach ($ratings as $rating => $count) {
                    $percentage = ($count / $totalRatings) * 100;
                    $percentageRatings[$rating] = $percentage;
                }
                ?>

                <div class="reviews-container">
                    <h2>Reviews Summary</h2>
                    <?php
                    for ($rating = 5; $rating >= 1; $rating--) {
                        $count = isset($ratings[$rating]) ? $ratings[$rating] : 0;
                        echo '<div class="review">';
                        echo '<span class="icon-container">' . $rating . ' <i class="fas fa-star"></i></span>';
                        echo '<div class="progress">';
                        echo '<div class="progress-done" data-done="' . $count . '"></div>';
                        echo '</div>';
                        echo '<span class="percent">' . $count . '</span>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="box-container">
                    <div class="box">
                        <h4>Reviews and Feedback</h4>
                        <div>

                            <div class="filters">

                                <div class="year" class="form-control">
                                    <label for="cars">Filter Year:</label>
                                    <select class="form-control">
                                        <option>2022</option>
                                        <option>2023</option>
                                    </select>
                                </div>

                                <div class="college">
                                    <label for="months">Filter by Month:</label>
                                    <select class="form-control" id="months">
                                        <option style="display:none">Select here</option>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>
                                </div>

                                <div class="year-level" class="form-control">
                                    <label for="yearlevel">Filter by Stars:</label>
                                    <select class="form-control">
                                        <option style="display:none">Select here</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>

                            </div>

                            <?php
                            if (isset($_GET['search'])) {
                                $valueToSearch = $_GET['search'];
                                // search in all table columns
                                // using concat mysql function
                                $querySearch = "SELECT * FROM rating  WHERE rating_id >= 0";
                                $search_result = filterTable($querySearch);

                            } else {
                                // display students existing on databse. exclude the admins/librarians
                                $querySearch = "SELECT * FROM rating  WHERE rating_id >= 0";
                                $search_result = filterTable($querySearch);
                            }

                            // function to connect and execute the query
                            function filterTable($querySearch)
                            {
                                require 'connect.php';
                                $filter_Result = mysqli_query($conn, $querySearch);
                                return $filter_Result;
                            }
                            ?>

                            <div class="review-list-container">
                                <div class="review-list">
                                    <?php
                                    if ($count = mysqli_num_rows($search_result) > 0) {

                                        while ($row2 = mysqli_fetch_array($search_result)) {

                                            ?>
                                            <!-- Review 1 -->
                                            <div class="reviews">
                                                <div class="review-header">
                                                    <div class="review-info">
                                                        <span class="name">
                                                            <?php echo $row2['user_id']; ?>
                                                        </span>
                                                        <span class="date">
                                                            <?php echo $row2['date']; ?>
                                                        </span>
                                                    </div>
                                                    <div class="star-rating">
                                                        <span>
                                                            <?php if ($row2['rating'] == "1") {
                                                                echo "⭐";
                                                            } elseif ($row2['rating'] == "2") {
                                                                echo "⭐⭐";
                                                            } elseif ($row2['rating'] == "3") {
                                                                echo "⭐⭐⭐";
                                                            } elseif ($row2['rating'] == "4") {
                                                                echo "⭐⭐⭐⭐";
                                                            } elseif ($row2['rating'] == "5") {
                                                                echo "⭐⭐⭐⭐⭐";
                                                            } ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="review-text">
                                                    <p>
                                                        <?php echo $row2['review']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <div class="print-report">
                            <a href="sample-doc.pdf" class="buttons">Print Feedback</a>
                        </div>



        </main>

    </div>
    </div>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script src="js\adminReviews.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="js\sidebar.js"></script>


</html>