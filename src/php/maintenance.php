
<?php
// always start session
session_start();

// if the user was not logged in
if (!isset($_SESSION["student_id"]) && !isset($_SESSION["password"])) {
    echo '<style type="text/css">
        .wrapper .hidden{
            display: none;
        }
        </style>'; // reserve and account button is hidden if the user was not logged in

} else {
    echo '<style type="text/css">
        .wrapper .show{
            display: none;
        }
        </style>'; // login button is hidden if the user was logged in
}



// Check if maintenance mode is enabled
$maintenanceMode = false; // Set this variable based on your toggle status

if ($maintenanceMode) {
  header("Location: maintenance.php"); // Redirect to maintenance.php
  exit(); // Terminate further execution of the script
}


?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <!------------------------ Bootstrap 5 ------------------------>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!------------------------ CSS Link ------------------------>
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/maintenance.css" /> -->

    <!------------------------ For NAV-BAR ------------------------>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->

    <!------------------------ Google Fonts Used ------------------------>
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Playfair+Display:ital@1&display=swap"
        rel="stylesheet"> -->

        <style>
            body {
    margin: 0;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background-color: #e1e8ee;
  }
  
  #fix_icon {
    width: 200px;
    height: 200px;
  }
  .my-proflie h2 {
    font-weight: 400;
    color: #707584;

    align-items: center;
  }
  
  .my-proflie h3 {
    margin: 0px 0px 5px;
    font-weight: 600;
    font-size: 18px;
    line-height: 18px;
  }
  
  .my-proflie {
    width: 100vw;
 
    padding: 50px 10px;
  }
  
  .app-wrapper {
  background-color: #fff;
  height: 500px;
  max-width: 880px;
  margin: 0 auto;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  box-shadow: 8px 8px 30px rgba(0, 0, 0, 0.05);
  padding: 70px;
}
        </style>
        
<script>
    // Function to trigger the PHP script
    function triggerValidation() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'validateReservation.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log('Checked expired validation');
                } else {
                    console.log('Error in checking expired validation');
                }
            }
        };
        xhr.send();
    }

    // Call the function immediately
    triggerValidation();

    // Set up a recurring timer to call the function every 5 seconds (5000 milliseconds)
    setInterval(triggerValidation, 5000);
</script>

</head>

<body>

    <div class="wrapper">


        <!-- Sticky header -->

        <!-- Sticky header -->


        <div class="my-proflie">
            <div class="app-wrapper">
                <img id="fix_icon" src="../img/maintenance.png">
                <h1 class="fw-bolder">We'll be right back!</h1>
                <p>Our reservation service is temporarily unavailable. <br> We are working diligently to resolve the issue.</p>
                <h3>Please try again later</h3>
                <a class="btn btn-danger mt-2"href="../index.php">Return to Home</a>
            </div>

        </div>

        <!------------------------ FOOTER ------------------------>
      
        <!------------------------ FOOTER ------------------------>



    </div>


</body>