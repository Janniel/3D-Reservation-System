<?php
session_start();
require 'connect.php';
require 'session.php';

//Retrieve selected admin account from manage.php
$admin_account = $_GET['admin'];
$_SESSION['selected_admin'] = $admin_account;

//Retrieve admin account from database
$query = "SELECT * FROM ACCOUNT 
                INNER JOIN ADMIN ON ACCOUNT.account_id = ADMIN.account_id 
                WHERE ACCOUNT.account_id = '$admin_account'";
$result = mysqli_query($conn, $query);
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
    <link rel="stylesheet" type="text/css" href="css/adminProfile.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

:root {
  --main-color: #a81c1c;
  --color-dark: #1d2231;
  --text-gray: #8390a2;
}

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  list-style-type: none;
  text-decoration: none;
  font-family: "Poppins", sans-serif;
}

html,
body {
  margin: 0;
  height: 100%;
  overflow: hidden;
}

/* --------- SIDEBAR --------- */
.sidebar {
  width: 345px;
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  background: var(--main-color);
  z-index: 100;
  transition: width 300ms;
}

/* .sidebar a {
  text-decoration: underline 0.15em rgba(0, 0, 0, 0);
  transition: text-decoration-color 300ms;
  text-underline-offset: 0.4em;
} */

/* .sidebar a:hover {
  text-decoration-color: rgb(247, 247, 247);
} */

#tabButton .tabs a:hover {
  background: #fff8f8d3;
  color: var(--main-color);
  border-radius: 20px 0px 0px 20px;
  text-decoration: none;
  transition: 400ms;
}

.sidebar-brand {
  height: 90px;
  padding: 1rem 0rem 1rem 0.7rem;
  display: flex;
  color: #fff;
  padding-top: 1rem;
}

.sidebar-brand span {
  display: inline-block;
  padding-top: 0.3rem;
  margin-left: 1rem;
}

.sidebar-menu {
  margin-top: 1rem;
}

.sidebar-menu li {
  width: 100%;
  margin-bottom: 1.7rem;
  padding-left: 1rem;
  cursor: pointer;
}

.sidebar-menu a {
  padding-left: 1rem;
  display: block;
  color: #fff;
  font-size: 1.1rem;
}

#tabButton {
  color: #fff;
}

.sidebar-menu a span:first-child {
  font-size: 1.5rem;
  padding-right: 1rem;
}

#tabButton a.active {
  background: #fff;
  padding-top: 1rem;
  padding-bottom: 1rem;
  color: var(--main-color);
  border-radius: 20px 0px 0px 20px;
}

#tabContainer .tab {
  display: none; /* hide all tab */
  box-sizing: border-box;
  padding: 10px;
}

#tabContainer .active {
  display: block;
}

.logo {
  width: 50px;
  height: 50px;
}

.manage {
  color: #ffffff;
  cursor: pointer;
}

.logout {
  text-align: center;
  position: absolute;
  bottom: 0;
  background: #701313;
  padding: 5%;
  text-decoration: none;
}

.logout a {
  text-decoration: none;
}

/* --------- END OF SIDEBAR --------- */

.main-content {
  transition: margin-left 300ms;
  margin-left: 345px;
}

/* --------- HEADER --------- */
header {
  display: flex;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
  position: fixed;
  left: 345px;
  width: calc(100% - 345px);
  top: 0%;
  z-index: 100;
  background-color: #fff;
  transition: left 300ms;
}

header h2 {
  color: #222;
}

header label span {
  font-size: 1.7rem;
  padding-right: 1rem;
}

.toggle {
  cursor: pointer;
}

#nav-toggle {
  display: none;
  cursor: pointer;
}

#nav-toggle:checked + .sidebar {
  width: 70px;
}

#nav-toggle:checked + .sidebar .sidebar-brand h2 span:last-child,
#nav-toggle:checked + .sidebar li a span:last-child {
  display: none;
}

#nav-toggle:checked + .sidebar .sidebar-brand,
#nav-toggle:checked + .sidebar li {
  text-align: center;
}

#nav-toggle:checked ~ .main-content {
  margin-left: 70px;
}

#nav-toggle:checked ~ .header header {
  width: calc(100% - 70px);
  left: 70px;
}

.user-wrapper:hover {
  text-decoration-color: rgb(145, 13, 13);
}

.user-wrapper {
  display: flex;
  align-items: center;
  text-decoration: underline 0.15em rgba(0, 0, 0, 0);
  transition: text-decoration-color 300ms;
  text-underline-offset: 0.4em;
}

.user-wrapper img {
  border-radius: 50%;
  margin-right: 1rem;
}

.user-wrapper small {
  display: inline-block;
  color: var(--text-gray);
}

.user-wrapper h4 {
  margin-bottom: -7px !important;
}

.dropdown-toggle {
  background-color: transparent;
  border-color: #fff;
  border-style: solid;
  border-top: none;
  border-right: none;
  border-left: none;
  content: none;
}

.dropdown-toggle::after {
  content: none;
}

.dropdown-menu {
  background-color: hsl(0, 0%, 100%);
  margin-left: 60px;
}

.dropdown-menu > li > a {
  color: #a12a2a;
}

/* --------- END OF HEADER --------- */

main {
  margin-top: 35px;
  padding: 2rem 1.5rem;
  background: #f1f5f9;
  height: 100vh;
  top: 0;
}

main #note {
  font-weight: bold;
  color: #a81c1c;
}

@media only screen and (max-width: 960px) {
  .cards {
    grid-template-columns: repeat(3, 1fr);
  }

  .recent-grid {
    grid-template-columns: 60% 40%;
  }
}

@media only screen and (max-width: 768px) {
  .cards {
    grid-template-columns: repeat(2, 1fr);
  }

  .recent-grid {
    grid-template-columns: 100%;
  }

  .search-wrapper {
    display: none;
  }
}

.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 0 solid transparent;
  border-radius: 0.25rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%),
    0 2px 6px 0 rgb(206 206 238 / 54%);
}
.me-2 {
  margin-right: 0.5rem !important;
}

.adminButton {
  position: absolute;
  bottom: 0;
  width: 100%;
  right: 0;
}

/* Create two equal columns that floats next to each other */
.adminButtons {
  width: 100%;
  padding: 20px;
  padding-bottom: 0;
  height: 150px; /* Should be removed. Only for demonstration */
  margin-top: 0px;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Clear floats after the columns */
.adminButton:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}

.note1 {
  padding-left: 5%;
  font-size: small;
}

.note2 {
  font-size: small;
  display: none;
}

.suspendAcc {
  align-items: center;
  background-color: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0.25rem;
  box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
  box-sizing: border-box;
  color: rgba(0, 0, 0, 0.85);
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui, -apple-system, system-ui, "Helvetica Neue", Helvetica,
    Arial, sans-serif;
  font-size: 15px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(0.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: 100%;
}

.suspendAcc:hover,
.button-6:focus {
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
  color: rgba(196, 34, 34, 0.65);
}

.suspendAcc:hover {
  transform: translateY(-1px);
}

.suspendAcc:active {
  background-color: #f0f0f1;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
  color: rgba(196, 34, 34, 0.65);
  transform: translateY(0);
}

.deleteAcc {
  align-items: center;
  background-color: #cf4f4f;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0.25rem;
  box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
  box-sizing: border-box;
  color: rgba(252, 252, 252, 0.85);
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui, -apple-system, system-ui, "Helvetica Neue", Helvetica,
    Arial, sans-serif;
  font-size: 15px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(0.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: 100%;
}

.deleteAcc:hover,
.deleteAcc:focus {
  background-color: #740101;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
  color: rgb(255, 255, 255);
}

.deleteAcc:hover {
  transform: translateY(-1px);
}

.deleteAcc:active {
  background-color: #f0f0f1;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
  color: rgba(0, 0, 0, 0.65);
  transform: translateY(0);
}

.adminInfo {
  border: 2px solid black;
  margin-top: 10px;
}

/* CSS */
.saveBTN {
  background-color: #cf4f4f;
  border: 1px solid rgb(209, 213, 219);
  border-radius: 0.5rem;
  box-sizing: border-box;
  color: #ffffff;
  font-family: "Inter var", ui-sans-serif, system-ui, -apple-system, system-ui,
    "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
    "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  font-size: 0.775rem;
  font-weight: 600;
  line-height: 0.8rem;
  padding: 0.75rem 1rem;
  text-align: center;
  text-decoration: none #d1d5db solid;
  text-decoration-thickness: auto;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  margin-left: auto;
  margin-right: 20px;
}

.saveBTN:hover {
  background-color: #740101;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
  color: rgb(255, 255, 255);
  transform: translateY(-1px);
}

.saveBTN:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
}

.saveBTN:focus-visible {
  box-shadow: none;
}

.fieldTxt {
  padding-top: 11px;
}

#deleteModal img {
  margin-bottom: 50px;
  margin-left: 100px;
  font-size: x-large;
}

.manage {
  color: #ffffff;
  cursor: pointer;
}

.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}

.container {
  padding-top: 50px;
  margin: auto;
}

    </style>

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
                <li class="tabs"> <a href="admin.php" data-tabName="dashboard" id="tabButtons"><span
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
                Manage
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

        <!-- Popup for changing username -->
        <div class="modal fade" id="change_username" tabindex="-1" role="dialog" aria-labelledby="change_usernameLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="change_usernameLabel">Update Username </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="padding:40px 50px;">
                            <h6 class="" id="">Are you sure you want to change your username, <span
                                    style="font-weight:bold;">
                                    <?php echo $_SESSION["username"]; ?>
                                </span>?</h6>
                            <hr>
                            <div class="form-group">
                                <label for="name">New Username</label>
                                <input type="text" id="username-input" class="form-control" placeholder="Jdoe" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Confirm New Username</label>
                                <input type="text" id="confirmUsername-input" class="form-control" placeholder="Jdoe"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <a id="updateUname_BTN" class="btn btn-danger" type="submit" form="a-form">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup for changing password -->
        <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="change_passwordLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="change_passwordLabel">Update Password </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="padding:40px 50px;">
                            <h6 class="" id="">Are you sure you want to change your password, <span
                                    style="font-weight:bold;">
                                    <?php echo $_SESSION["username"]; ?>
                                </span>?</h6>
                            <hr>
                            <div class="form-group">
                                <label for="name">New Password</label>
                                <input type="password" id="password-field1" class="form-control pass">
                            </div>
                            <div class="form-group">
                                <label for="name">Confirm New Password</label>
                                <input id="password-field" type="password" class="form-control" name="password">
                                <span style="margin-right:10px;" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <a id="updatePass_BTN" class="btn btn-danger" type="submit" form="a-form">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup for SAVING ACCOUNT CHANGES with superadmin permission -->
        <div class="modal fade" id="updateInfo1" tabindex="-1" role="dialog" aria-labelledby="updateInfo1Label"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInfo2Label">Are these correct?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="padding:40px 50px;">
                            <p style="font-size: 16px;"><span style="font-weight: bold;">
                                    Email:&nbsp;&nbsp;</span><span id="edit_email"></span> </p>
                            <p style="font-size: 16px;"><span style="font-weight: bold;">
                                    Telephone number:&nbsp;&nbsp;</span><span id="edit_telNo"></span> </p>
                            <p style="font-size: 16px;"><span style="font-weight: bold;">Mobile
                                    Number:&nbsp;&nbsp;</span><span id="edit_mobileNo"></span> </p>
                            <p style="font-size: 16px;"><span
                                    style="font-weight: bold;">Facebook:&nbsp;&nbsp;</span><span id="edit_fb"></span>
                            </p>
                            <p style="font-size: 16px;"><span
                                    style="font-weight: bold;">LinkedIn:&nbsp;&nbsp;</span><span
                                    id="edit_linkedIn"></span> </p>
                            <p style="font-size: 16px;"><span style="font-weight: bold;">Home
                                    Address:&nbsp;&nbsp;</span><span id="edit_address"></span> </p>
                            <p style="font-size: 16px;"><span style="font-weight: bold;">Profile
                                    Picture:&nbsp;&nbsp;</span><span id="edit_picture"></span> </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <a id="updateInfo1_BTN" class="btn btn-danger" type="submit" form="a-form">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup for SAVING ACCOUNT CHANGES with superadmin permission -->
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="on" class="sign-in-form"
            style="padding-top:0;">
            <div class="modal fade" id="updateInfo2" tabindex="-1" role="dialog" aria-labelledby="updateInfo2Label"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateInfo2Label">Are these correct?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-body" style="padding:40px 50px;">
                                <p style="font-size: 16px;"><span style="font-weight: bold;">First
                                        Name:&nbsp;&nbsp;</span><span id="edit_fname"></span> </p>
                                <p style="font-size: 16px;"><span style="font-weight: bold;">Last
                                        Name:&nbsp;&nbsp;</span><span id="edit_lname"></span> </p>
                                <p style="font-size: 16px;"><span
                                        style="font-weight: bold;">Gender:&nbsp;&nbsp;</span><span
                                        id="edit_gender"></span> </p>
                                <p style="font-size: 16px;"><span
                                        style="font-weight: bold;">Department:&nbsp;&nbsp;</span><span
                                        id="edit_department"></span> </p>
                                <p style="font-size: 16px;"><span
                                        style="font-weight: bold;">Position:&nbsp;&nbsp;</span><span
                                        id="edit_position"></span> </p>
                                <p style="font-size: 16px;"><span style="font-weight: bold;">Employment
                                        Status:&nbsp;&nbsp;</span><span id="edit_employmentSTS"></span> </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                                <a id="updateInfo2_BTN" type="submit" class="btn btn-danger">Save</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <main style="margin-top:85px;">

            <div class="main-body">
                <div class="row">

                    <?php

                    while ($row = mysqli_fetch_assoc($result)) {

                        ?>
                        <div class="col-lg-4">
                            <div class="card" style="height: 85vh">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                    <img src="<?php echo $row['picture_admin']; ?>" alt="Admin" class="rounded-circle p-1 bg-secondary" width="110">
                                        <div class="mt-3">
                                            <h4>
                                                <?php echo ucwords($row["first_name"] . ' ' . $row["last_name"]); ?>
                                            </h4>
                                            <p class="text-secondary mb-1">Administrator</p>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Username <img src="../img/edit.png" width="20" height="20"
                                                    style="cursor:pointer;" data-toggle="modal"
                                                    data-target="#change_username"></h6>
                                            <span class="text-secondary">
                                                <?php echo $row['username']; ?>
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Password &nbsp;<img src="../img/edit.png" width="20"
                                                    height="20" style="cursor:pointer;" data-toggle="modal"
                                                    data-target="#change_password"></h6>

                                            <span class="text-secondary">
                                                Set
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Account Number</h6>
                                            <span class="text-secondary">
                                                <?php echo $row['account_id']; ?>
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Department</h6>
                                            <span class="text-secondary">
                                                <?php echo $row['department']; ?>
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-secondary" id="emailTxt">
                                                <?php echo $row['email']; ?>
                                            </span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-facebook me-2 icon-inline text-primary">
                                                    <path
                                                        d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                    </path>
                                                </svg>Facebook</h6>
                                            <a class="text-secondary" id="fbTxt" style="cursor: pointer;"
                                                href="https://<?php echo $row['fb_link'] ?>" target="_blank">
                                                <?php if ($row['fb_link'] == '')
                                                    echo "Empty Field";
                                                else
                                                    echo $row['fb_link'] ?>
                                                </a>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" class="bi bi-linkedin me-2 icon-inline text-primary"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                                                    </svg>LinkedIn</h6>
                                                <a class="text-secondary" id="linkedInTxt"
                                                    href="https://<?php echo $row['linkedIn_link'] ?>" target="_blank">
                                                <?php if ($row['linkedIn_link'] == '')
                                                    echo "Empty Field";
                                                else
                                                    echo $row['linkedIn_link'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card" style="height: 85vh">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 fieldTxt">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input id="email-input" type="text" class="form-control" placeholder="Empty"
                                                    value="<?php echo $row['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Tel No.</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="telNo-input" type="text" class="form-control" placeholder="Empty"
                                                minlength="12" maxlength="12" value="<?php echo $row['tel_no'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Mobile No.</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="mobileNo-input" type="text" class="form-control" minlength="12"
                                                maxlength="12" placeholder="Empty" value="<?php echo $row['mobile_no'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Facebook</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="fb-input" type="text" class="form-control" placeholder="Empty"
                                                value="<?php echo $row['fb_link'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">LinkedIn</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="linkedIn-input" type="text" class="form-control" placeholder="Empty"
                                                value="<?php echo $row['linkedIn_link'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Home Adress</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="address-input" type="text" class="form-control" placeholder="Empty"
                                                value="<?php echo $row['home_address'] ?>">
                                        </div>
                                    </div>
                                    <form action="toUpdateAdmin.php" id="profile-picture-form" enctype="multipart/form-data">
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Profile Picture</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                           
                                            <input type="file" class="form-control" id="inputGroupFile01" name="profile_picture"
                                                value="<?php echo $row['picture_admin'] ?>">
									    </div>
                                    </div>


                                    <div class="row ml-auto">
                                        <button id="updateInfo1" data-toggle="modal" data-target="#updateInfo1"
                                            class="saveBTN" type="button">Save changes</button>
                                    </div>

                                    <hr class="my-4">

                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">First Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="firstname-input" name="first_name" type="text" class="form-control"
                                                required="required" autocomplete="off"
                                                value="<?php echo ucwords($row['first_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Last Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="lastname-input" name="last_name" type="text" class="form-control"
                                                required="required" autocomplete="off"
                                                value="<?php echo ucwords($row['last_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 fieldTxt">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary gender">
                                            <select class="form-control" id="gender-input">
                                                <option <?php if ($row['gender'] == 'Male')
                                                    echo "selected " ?> value='Male'>
                                                        Male</option>
                                                    <option <?php if ($row['gender'] == 'Female')
                                                    echo "selected " ?> value='Female'>
                                                        Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 fieldTxt">Department</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary gender">
                                                <select class="form-control" id="department-input">
                                                    <option <?php if ($row['department'] == 'CAFA')
                                                    echo "selected" ?> value='CAFA'>
                                                        COLLEGE OF ARCHITECTURE AND FINE ARTS (CAFA)</option>
                                                    <option <?php if ($row['department'] == 'CAL')
                                                    echo "selected" ?> value='CAL'>
                                                        COLLEGE OF ARTS AND LETTERS (CAL)</option>
                                                    <option <?php if ($row['department'] == 'CBA')
                                                    echo "selected" ?> value='CBA'>
                                                        COLLEGE OF BUSINESS ADMINISTRATION (CBA)</option>
                                                    <option <?php if ($row['department'] == 'CCJE')
                                                    echo "selected" ?> value='CCJE'>
                                                        COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)</option>
                                                    <option <?php if ($row['department'] == 'CHTM')
                                                    echo "selected" ?> value='CHTM'>
                                                        COLLEGE OF HOSPITALITY AND TOURISM MANAGEMENT (CHTM)
                                                    </option>
                                                    <option <?php if ($row['department'] == 'CICT')
                                                    echo "selected" ?> value='CICT'>
                                                        COLLEGE OF INFORMATION AND COMMUNICATIONS TECHNOLOGY
                                                        (CICT)
                                                    </option>
                                                    <option <?php if ($row['department'] == 'CIT')
                                                    echo "selected" ?> value='CIT'>
                                                        COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)</option>
                                                    <option <?php if ($row['department'] == 'CLAW')
                                                    echo "selected" ?> value='CLAW'>
                                                        COLLEGE OF LAW (CLAW)</option>
                                                    <option <?php if ($row['department'] == 'CN')
                                                    echo "selected" ?> value='CN'>
                                                        COLLEGE OF NURSING (CN)</option>
                                                    <option <?php if ($row['department'] == 'COE')
                                                    echo "selected" ?> value='COE'>
                                                        COLLEGE OF ENGINEERING (COE)</option>
                                                    <option <?php if ($row['department'] == 'COED')
                                                    echo "selected" ?> value='COED'>
                                                        COLLEGE OF EDUCATION (COED)</option>
                                                    <option <?php if ($row['department'] == 'CS')
                                                    echo "selected" ?> value='CS'>
                                                        COLLEGE OF SCIENCE (CS)</option>
                                                    <option <?php if ($row['department'] == 'CSER')
                                                    echo "selected" ?> value='CSER'>
                                                        COLLEGE OF SPORTS, EXERCISE AND RECREATION (CSER)
                                                    </option>
                                                    <option <?php if ($row['department'] == 'CSSP')
                                                    echo "selected" ?> value='CSSP'>
                                                        COLLEGE OF SOCIAL SCIENCES AND PHILOSOPHY (CSSP)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 fieldTxt">Position</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary gender">
                                                <select class="form-control" id="position-input">
                                                    <option <?php if ($row['isSuperAdmin'] == 'yes')
                                                    echo "selected" ?> value='yes'>
                                                        Super Admin</option>
                                                    <option <?php if ($row['isSuperAdmin'] == 'no')
                                                    echo "selected" ?> value='no'>
                                                        Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 fieldTxt">Employment Status</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary gender">
                                                <select class="form-control" id="employmentSTS-input">
                                                    <option <?php if ($row['work_status'] == 'Permanent')
                                                    echo "selected " ?> value='Permanent'>
                                                        Permanent</option>
                                                    <option <?php if ($row['work_status'] == 'Temporary')
                                                    echo "selected " ?>
                                                        value='Temporary'>Temporary</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row ml-auto">
                                            <button id="updateInfo2" data-toggle="modal" data-target="#updateInfo2"
                                                class="saveBTN" type="button">Save changes</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                    <?php }

                    ?>
                </div>
            </div>
        </main>
    </div>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>



<!-- To change text values in popup base on admin Input -->
<script>
    document.getElementById("updateInfo1").addEventListener("mouseover", myFunction);
    function myFunction() {
        var email = document.getElementById("email-input").value;
        var telNo = document.getElementById("telNo-input").value;
        var mobileNo = document.getElementById("mobileNo-input").value;
        var fb = document.getElementById("fb-input").value;
        var linkedIn = document.getElementById("linkedIn-input").value;
        var address = document.getElementById("address-input").value;
        var picture = document.getElementById("inputGroupFile01").value;
        document.getElementById("edit_email").innerHTML = email;
        document.getElementById("edit_telNo").innerHTML = telNo;
        document.getElementById("edit_mobileNo").innerHTML = mobileNo;
        document.getElementById("edit_fb").innerHTML = fb;
        document.getElementById("edit_linkedIn").innerHTML = linkedIn;
        document.getElementById("edit_address").innerHTML = address;
        document.getElementById("edit_picture").innerHTML = picture;
    }   
</script>

<!-- To change text values in popup base on admin Input -->
<script type="text/javascript">
    document.getElementById("updateInfo2").addEventListener("mouseover", myFunction);
    function myFunction() {

        var fname = document.getElementById("firstname-input").value;
        var lname = document.getElementById("lastname-input").value;
        var gender = document.getElementById("gender-input").value;
        var department = document.getElementById("department-input").value;
        var employmentSTS = document.getElementById("employmentSTS-input").value;
        var position = document.getElementById("position-input").value;
        document.getElementById("edit_fname").innerHTML = fname;
        document.getElementById("edit_lname").innerHTML = lname;
        document.getElementById("edit_gender").innerHTML = gender;
        document.getElementById("edit_department").innerHTML = department;
        document.getElementById("edit_employmentSTS").innerHTML = employmentSTS;
        if (position == 'no') {
            document.getElementById("edit_position").innerHTML = "Admin";
        } else if (position == 'yes') {
            document.getElementById("edit_position").innerHTML = "Super Admin";
        }
    }

    // Function to show Swal alerts based on response status
    document.getElementById('updateInfo1_BTN').addEventListener('click', function (update1) {
    // Disable the button to prevent multiple clicks
    this.disabled = true;

    var newEmail = document.getElementById('email-input').value;
    var newTelNo = document.getElementById('telNo-input').value;
    var newMobileNo = document.getElementById('mobileNo-input').value;
    var newFb = document.getElementById('fb-input').value;
    var newLinkedIn = document.getElementById('linkedIn-input').value;
    var newAddress = document.getElementById('address-input').value;
    var pictureFile = $("#inputGroupFile01")[0].files[0];

    // Create a FormData object to send the data and the picture file
    var formData = new FormData();
    formData.append('email', newEmail);
    formData.append('telNo', newTelNo);
    formData.append('mobileNo', newMobileNo);
    formData.append('fb', newFb);
    formData.append('linkedIn', newLinkedIn);
    formData.append('address', newAddress);
    formData.append('profile_picture', pictureFile);

    $.ajax({
        url: 'toUpdateAdmin.php',
        method: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                title: response.status === 'success' ? "Saved!" : "Error",
                text: response.status === 'success' ? "Your information has been updated" : "Failed to update information",
                icon: response.status === 'success' ? "success" : "error"
            }).then((result) => {
                if (result.isConfirmed && response.status === 'success') {
                    location.reload();
                }
            });
        },
        error: function() {
            Swal.fire({
                title: "Error",
                text: "Failed to update information",
                icon: "error"
            });
        }
    });
});






    document.getElementById('delete_BTN').addEventListener('click', function (update1) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        const SA_username = document.getElementById("SA_username-input").value;
        const SA_password = document.getElementById("SA_password-input").value;

        $.ajax({
            url: 'toDeleteAdmin.php',
            method: 'POST',
            dataType: 'json',
            data: {
                SA_username: SA_username,
                SA_password: SA_password
            },
        });
    });
</script>


<script type="text/javascript">

    // Function to show Swal alerts based on response status
    document.getElementById('updateInfo2_BTN').addEventListener('click', function (update1) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        var newFirstName = document.getElementById('firstname-input').value;
        var newLastName = document.getElementById('lastname-input').value;
        var newGender = document.getElementById('gender-input').value;
        var newDepartment = document.getElementById('department-input').value;
        var newPosition = document.getElementById('position-input').value;
        var newEmploymentSTS = document.getElementById('employmentSTS-input').value;
        

        $.ajax({
            url: 'toUpdateAdminSA.php',
            method: 'POST',
            dataType: 'json',
            data: {
                firstName: newFirstName,
                lastName: newLastName,
                gender: newGender,
                department: newDepartment,
                position: newPosition,
                employmentSTS: newEmploymentSTS
            },
        });
        Swal.fire({
            title: "Saved!",
            text: "Your information has been updated",
            icon: "success"
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        })
    });

    //show password
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // Function to change admin username
    document.getElementById('updateUname_BTN').addEventListener('click', function (update1) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        var newUsername = document.getElementById('username-input').value;
        var confirmNewUname = document.getElementById('confirmUsername-input').value;

        if (newUsername != "" && confirmNewUname != "") {
            if (newUsername == confirmNewUname) {
                $.ajax({
                    url: 'toUpdateAdminUname.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        newUsername: newUsername
                    },
                });
                Swal.fire({
                    title: "Saved!",
                    text: "Your information has been updated",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Username do not match",
                    icon: "error"
                })
            }
        } else {
            Swal.fire({
                title: "Error!",
                text: "Please fill out both fields",
                icon: "error"
            })
        }

    });

    // Function to change admin pass
    document.getElementById('updatePass_BTN').addEventListener('click', function (update1) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        var newPass = document.getElementById('password-field1').value;
        var confirmNewPass = document.getElementById('password-field').value;

        if (newPass != "" && confirmNewPass != "") {
            if (newPass == confirmNewPass) {
                $.ajax({
                    url: 'toUpdateAdminPass.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        newPass: newPass
                    },
                });
                Swal.fire({
                    title: "Saved!",
                    text: "Your password has been updated",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Passwords do not match!",
                    icon: "error"
                })
            }

        } else {
            Swal.fire({
                title: "Error!",
                text: "Please fill out both fields",
                icon: "error"
            })
        }

    });
</script>

</html>