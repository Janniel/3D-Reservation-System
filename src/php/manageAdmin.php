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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/manageAdmin.css" />

    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>


<body>

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
                <li class="tabs"> <a href="analytics.php"><span class="las la-chart-bar"></span>
                        <span>Analytics</span></a>
                </li>
                <li class="tabs"> <a href="settings.php"><span class="las la-cog"></span>
                        <span>Settings</span></a>
                </li>
                <li id="hidden" class="manage tabs" data-toggle="modal" data-target="#exampleModal"> <a
                        href="manageAdmin.php" class="active"><span class="las la-users-cog"></span>
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
                Manage Admin Accounts
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

        <!-- Popup for CREATING ADMIN ACCOUNT -->
        <div class="modal fade" id="createAccount" tabindex="-1" role="dialog" aria-labelledby="createAccountLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAccountLabel">Create Admin Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="padding:10px 40px;">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" id="username-input" class="form-control" placeholder="Jdoe" required>
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
                                <a href="#" data-toggle="modal" data-target="#login"
                                    style="display:none; position: absolute; right: 0; font-size: 12px;">That's you?
                                    Login</a>
                            </div>
                            <div class="form-group" style="position:relative;">
                                <label for="email">Gender</label>
                                <select class="form-control" id="gender-input">
                                    <option hidden disabled selected value> -- select a gender -- </option>
                                    <option value='Male'>Male</option>
                                    <option value='Female'>Female</option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="form-group col">
                                    <label for="password">Password</label>
                                    <input type="password" id="password-input" class="form-control"
                                        placeholder="*********" required>

                                </div>
                                <div class="form-group col">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="passwordConfirm-input" class="form-control"
                                        placeholder="*********" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="position:relative;">
                                <label for="email">Department</label>
                                <select class="form-control" id="department-input">
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option value='CAFA'>
                                        COLLEGE OF ARCHITECTURE AND FINE ARTS (CAFA)</option>
                                    <option value='CAL'>
                                        COLLEGE OF ARTS AND LETTERS (CAL)</option>
                                    <option value='CBA'>
                                        COLLEGE OF BUSINESS ADMINISTRATION (CBA)</option>
                                    <option value='CCJE'>
                                        COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)</option>
                                    <option value='CHTM'>
                                        COLLEGE OF HOSPITALITY AND TOURISM MANAGEMENT (CHTM)
                                    </option>
                                    <option value='CICT'>
                                        COLLEGE OF INFORMATION AND COMMUNICATIONS TECHNOLOGY
                                        (CICT)
                                    </option>
                                    <option value='CIT'>
                                        COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)</option>
                                    <option value='CLAW'>
                                        COLLEGE OF LAW (CLAW)</option>
                                    <option value='CN'>
                                        COLLEGE OF NURSING (CN)</option>
                                    <option value='COE'>
                                        COLLEGE OF ENGINEERING (COE)</option>
                                    <option value='COED'>
                                        COLLEGE OF EDUCATION (COED)</option>
                                    <option value='CS'>
                                        COLLEGE OF SCIENCE (CS)</option>
                                    <option value='CSER'>
                                        COLLEGE OF SPORTS, EXERCISE AND RECREATION (CSER)
                                    </option>
                                    <option value='CSSP'>
                                        COLLEGE OF SOCIAL SCIENCES AND PHILOSOPHY (CSSP)
                                    </option>
                                </select>
                            </div>
                            <div class="form-group" style="position:relative;">
                                <label for="email">Employment Status</label>
                                <select class="form-control" id="employmentSTS-input">
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option value='Permanent'>Permanent</option>
                                    <option value='Temporary'>Temporary</option>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group" style="position:relative;">
                                <label for="email">Position</label>
                                <select class="form-control" id="position-input">
                                    <option value='no'>Admin</option>
                                    <option value='yes'>Super Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <a id="createAccount_BTN" class="btn btn-danger" type="submit" form="a-form">Create</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // Check if the POST parameter is set
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buttonValue'])) {
            $buttonValue = $_POST['buttonValue'];
            $phpVariable = $buttonValue;
            echo $phpVariable;
            exit;
        }
        $phpVariable = "Initial Value";
        ?>

        <!-- Popup for viewing admin accounts -->
        <div class="modal modal-fullscreen-xl viewAdmin" id="viewProfile" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog opacity-animate3" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <main class="mainPopup">


                        </main>
                    </div>
                </div>
            </div>
        </div>


        <main class="main">

            <div class="filter">
                <div class="filter">
                    <form action="manageAdmin.php" method="GET">

                        <div class="row">
                            <div class="department">
                                <label for="cars">Department</label>
                                <select class="form-control" type="submit" name="department">
                                    <option style="display:none">Select here</option>
                                    <option value="CAFA">College of Architecture and Fine Arts (CAFA)</option>
                                    <option value="CAL">College of Arts and Letters (CAL)</option>
                                    <option value="CBA">College of Business Administration (CBA)</option>
                                    <option value="CCJE">College of Criminal Justice Education (CCJE)</option>
                                    <option value="CHTM">College of Hospitaity and Tourism Management (CHTM)</option>
                                    <option value="CICT">College of Information and Communications Technology (CICT)
                                    </option>
                                    <option value="CIT">College of Industrial Technology (CIT)</option>
                                    <option value="CLAW">College of Law (CLAW)</option>
                                    <option value="CN">College of Nursing (CN)</option>
                                    <option value="COE">College of Engineering (COE)</option>
                                    <option value="COED">College of Education (COED)</option>
                                    <option value="CS">College of Science (CS)</option>
                                    <option value="CSER">College of Exercise and Recreation (CSER)</option>
                                    <option value="CSSP">College of Social Sciences and Philosophy (CSSP)</option>
                                    <option value="GS">Graduate School (GS)</option>
                                </select>
                            </div>

                            <div class="type" class="form-control">
                                <label for="cars">Type of Work</label>
                                <select class="form-control">
                                    <option style="display:none">Select here</option>
                                    <option>Permanent</option>
                                    <option>Temporary</option>
                                </select>
                            </div>
                            <div class="searchBar">
                                <input type="search" placeholder="Search" name="search">
                            </div>

                            <?php
                            // //sort by department
                            // if (isset($_GET['department'])) {
                            //     $valueToSearch = $_GET['department'];
                            //     $querySearch = "SELECT ACCOUNT.account_id, ACCOUNT.username, ADMIN.gender, ADMIN.department, ADMIN.work_status, ADMIN.isSuperAdmin, ACCOUNT.email, ACCOUNT.account_type, rfid_no, ADMIN.first_name, ADMIN.last_name FROM ACCOUNT 
                            //     INNER JOIN ADMIN ON ACCOUNT.account_id = ADMIN.account_id
                            //     WHERE ADMIN.department = $valueToSearch";
                            //     $search_result = filterTable($querySearch);
                            // }
                            
                            if (isset($_GET['search'])) {
                                $valueToSearch = $_GET['search'];
                                // search in all table columns
                                // using concat mysql function
                                $querySearch = "SELECT ACCOUNT.account_id, ACCOUNT.username, ADMIN.gender, ADMIN.department, ADMIN.work_status, ADMIN.isSuperAdmin, ACCOUNT.email, ACCOUNT.account_type, rfid_no, ADMIN.first_name, ADMIN.last_name FROM ACCOUNT 
                                INNER JOIN ADMIN ON ACCOUNT.account_id = ADMIN.account_id
                                WHERE ACCOUNT.account_id > 0 AND ACCOUNT.account_id != 1  AND CONCAT(ACCOUNT.account_id, ACCOUNT.username, ADMIN.first_name, ADMIN.last_name, ACCOUNT.email, ADMIN.isSuperAdmin, ADMIN.work_status)LIKE '%" . $valueToSearch . "%'";
                                $search_result = filterTable($querySearch);

                            } else {
                                // display students existing on databse. exclude the admins/librarians
                                $querySearch = "SELECT ACCOUNT.account_id, ACCOUNT.username, ADMIN.gender, ADMIN.department, ADMIN.work_status, ADMIN.isSuperAdmin, email, account_type, ADMIN.rfid_no, ADMIN.first_name, ADMIN.last_name FROM ACCOUNT 
                                    INNER JOIN ADMIN ON ACCOUNT.account_id = ADMIN.account_id
                                    WHERE ACCOUNT_TYPE = 'admin' AND ACCOUNT.account_id != 1 ";
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

                        </div>
                    </form>
                </div>



                <div class="recent-grid">
                    <div class="history">
                        <div class="card">
                            <div class="card-header">
                                <h3>Admin Accounts</h3>

                                <div class="create">
                                    <button type="button" data-toggle="modal" data-target="#createAccount">
                                        <i class="las la-user-plus"></i> Create Account
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table width="100%">
                                        <div class="head">
                                            <thead>
                                                <tr>
                                                    <td>Account Number</td>
                                                    <td>Username</td>
                                                    <td>Name</td>
                                                    <td>RFID</td>
                                                    <td>Department</td>
                                                    <td>Gender</td>
                                                    <td>Employment Status</td>
                                                    <td>Position</td>
                                                    <td>More Action</td>
                                                </tr>
                                            </thead>
                                        </div>

                                        <div class='fill'>

                                            <tbody>
                                                <?php
                                                if ($count = mysqli_num_rows($search_result) > 0) {

                                                    while ($row2 = mysqli_fetch_array($search_result)) {

                                                        ?>
                                                        <tr>
                                                            <td class="studno" id="acc">
                                                                <?php echo $row2['account_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row2['username']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ucwords($row2['first_name']) . ' ' . ucwords($row2['last_name']); ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($row2['rfid_no'] == "") {
                                                                    echo "Not registered";
                                                                } else {
                                                                    echo $row2['rfid_no'];
                                                                } ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row2['department']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row2['gender']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row2['work_status']; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($row2['isSuperAdmin'] == "no") {
                                                                    echo "Admin";
                                                                } elseif ($row2['isSuperAdmin'] == "yes") {
                                                                    echo "Super Admin";
                                                                } ?>

                                                            </td>
                                                            <td>
                                                                <div id="container">
                                                                    <div id="menu-wrap">
                                                                        <input type="checkbox" class="toggler" />
                                                                        <div class="dots">
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="menu">
                                                                            <div>
                                                                                <ul>
                                                                                    <form method='GET' action='viewAdmin.php'
                                                                                        class='form'>
                                                                                        <li><button class="link" name="admin"
                                                                                                id="view_Profile" type="submit"
                                                                                                value="<?php echo $row2['account_id'] ?>">View
                                                                                                Profile</button>
                                                                                        </li>
                                                                                    </form>
                                                                                    <!-- data-toggle="modal" data-target="#viewProfile" -->
                                                                                    <li>
                                                                                        <button class="link deleteAcc"
                                                                                            type="button"
                                                                                            value="<?php echo $row2['account_id'] ?>">Delete</button>
                                                                                    </li>

                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                }
                                                ?>
                                            </tbody>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>


    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<script>
    // Function to show Swal alerts based on response status
    document.getElementById('createAccount_BTN').addEventListener('click', function (update1) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        var userName = document.getElementById('username-input').value;
        var firstName = document.getElementById('firstname-input').value;
        var lastName = document.getElementById('lastname-input').value;
        var email = document.getElementById('email-input').value;
        var gender = document.getElementById('gender-input').value;
        var adminPass = document.getElementById('password-input').value;
        var confirm_adminPass = document.getElementById('passwordConfirm-input').value;
        var department = document.getElementById('department-input').value;
        var employmentSTS = document.getElementById('employmentSTS-input').value;
        var position = document.getElementById('position-input').value;

        if (userName !== '' && firstName !== '' && lastName !== '' && email !== '' && gender !== '' && password !== '' && password !== '' && department !== '' && employmentSTS !== '') {
            if (adminPass == confirm_adminPass) {
                var password = adminPass;
                $.ajax({
                    url: 'toCreateAdmin.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        userName: userName,
                        firstName: firstName,
                        lastName: lastName,
                        email: email,
                        gender: gender,
                        password: password,
                        department: department,
                        employmentSTS: employmentSTS,
                        position: position
                    },
                });

                Swal.fire({
                    title: "Saved!",
                    text: "Your information has beed updated",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Passwords do not match",
                    icon: "error"
                }).then((result) => {
                    if (result.isConfirmed) {
                    }
                })
            };

        } else {
            Swal.fire({
                title: "Error!",
                text: "Please complete all the fields!",
                icon: "error"
            }).then((result) => {
            })
        };



    });


    // Function to show Swal alerts based on response status
    $('.deleteAcc').click(function (e) {
        // Disable the button to prevent multiple clicks
        e.preventDefault();

        // Get the value from the clicked button
        var account_id = $(this).val();
        Swal.fire({
            title: 'Warning',
            text: 'Deleting this account will permanently remove all associated data and cannot be undone. Please ensure you have backed up any essential information before proceeding.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#ddd',
            confirmButtonColor: "#a81c1c",
            confirmButtonText: 'Delete Account'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'toDeleteAdmin.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        account_id: account_id
                    },
                });
                Swal.fire({
                    title: "Account Deleted!",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            }
        });
    });
</script>


</html>