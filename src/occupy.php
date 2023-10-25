<?php
session_start();
require 'php/connect.php';
require 'php/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seat Occupy Demo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- SweetAlert2 CSS and JS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="css/edit_profile.css" />



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

  <!------------------------ HEADER --------------------->

  <header class="header-outer">
    <div class="header-inner responsive-wrapper">
      <div class="header-logo">
        <img src="img/elib logo.png" class="icon">
      </div>
      <nav class="header-navigation">
        <a href="index.php">HOME</a>
        <a href="index.php#aboutus">ABOUT US</a>
        <a href="reserve.php">RESERVE SEAT</a>
        <a class="active" id="hidden" href="occupy.php">OCCUPY SEAT</a>

        <a id="hidden" href="profile.php">ACCOUNT</a>
        <a id="hidden" href="toLogout.php">LOGOUT</a>
        <!-- <a id="show" href="login.php" >LOGIN</a> -->
      </nav>
    </div>
  </header>

  <!------------------------ END HEADER --------------------->


       
<div class="container">
    <br>
    <h1><b>Seat Occupy Demo (testing page)</b></h1>
    <p> This is a demo of sitting in the real seat on e-lib. </p><br>
    
    <h3><i>Note: You must reserve at least (1) one seat before occupying it.</i></h3><br>
    
    <h3>Direction: <br>1. Choose the seat that you reserved. <br> 2. Check the console for log <br> 3. Refresh the page to see changes <br> 4. View your occupying seat on the <b>Account > Occupying Tab</b> <br> 5. Click the "Mark as Done" if you are done in occupying the seat.</</h3><br>
    
    <div class="row">
        <?php
        // Retrieve initial seat status from the database and generate buttons
        $sql = "SELECT * FROM seat";
        $result = mysqli_query($conn, $sql);
        



while ($row = mysqli_fetch_assoc($result)) {
    $seat_number = $row['seat_number'];
    $seat_id = $row['seat_id'];
    $status = $row['status'];

    if ($status == 1) {
        // If the seat is occupied, fetch the occupying user information
        $occupying_user_query = "SELECT u.user_id
                                 FROM reservation r
                                 JOIN users u ON r.user_id = u.user_id
                                 WHERE r.seat_id = $seat_id AND r.isDone = 0";
        $occupying_user_result = mysqli_query($conn, $occupying_user_query);

        if ($occupying_user_result && mysqli_num_rows($occupying_user_result) > 0) {
            $user_row = mysqli_fetch_assoc($occupying_user_result);
            $occupying_user = $user_row['user_id'];

            echo "<button id='$seat_id' class='btn btn-dark ml-2 btn-lg disabled'> $seat_number (occupied by $occupying_user) </button>";
        } else {
            // Handle the case where there's an issue fetching user information
            echo "<button id='$seat_id' class='btn btn-danger ml-2 btn-lg disabled'> $seat_number (Error fetching user)</button>";
        }
    } else {
        echo "<button id='$seat_id' onclick='occupySeat($seat_id)' class='btn btn-success ml-2 btn-lg'>$seat_number</button>";
    }
}

        ?>
    </div>

<script>


    function occupySeat(seat_id) {
        // Make an AJAX request to occupyProcess.php
        $.ajax({
            type: "POST",
            url: "occupyProcess.php",
            data: { seat_id: seat_id }, // Send the seat ID as data
            success: function (response) {
                // Handle the response from occupyProcess.php here if needed
                console.log(response);
                location.reload();
                
            },
            error: function (xhr, status, error) {
                // Handle errors here if needed
                console.error(xhr.responseText);
                
            }
        });
    }
</script>

  

</div>





</body>
</html>
