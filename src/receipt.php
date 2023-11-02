<?php
session_start();
require 'php/connect.php';
require 'php/session.php';
require 'php/occupancy_timer.php';
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <!------------------------ Bootstrap 5.3.0 ------------------------>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <!------------------------ CSS Link ------------------------>
    <link rel="stylesheet" type="text/css" href="css/profile.css" />
    <!------------------------ ICONS ------------------------>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>



       
      
  <!------------------------ HEADER --------------------->

  <?php include 'php/header.php'; ?>

  <!------------------------ END HEADER --------------------->

  <?php
    // Retrieve the reservation ID from the URL parameter
    $reservation_id = $_GET['reservation_id'];

    // Retrieve reservation details from the database based on the reservation ID
    $query = "SELECT * FROM reservation WHERE reservation_id = '$reservation_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $seat_id = $row['seat_id'];
        $user_id = $row['user_id'];
        $date = date('F j, Y', strtotime($row['date'])); // Convert date to desired format
        $start_time = date('h:i A', strtotime($row['start_time'])); // Convert start time to AM/PM format
        $end_time = date('h:i A', strtotime($row['end_time'])); // Convert end time to AM/PM format

        // Retrieve additional information related to the reservation, such as seat details
        $seat_query = "SELECT * FROM seat WHERE seat_id = '$seat_id'";
        $seat_result = mysqli_query($conn, $seat_query);
        $seat_row = mysqli_fetch_assoc($seat_result);
        $seat_number = $seat_row['seat_name'];
        

        // Generate QR code content (e.g., reservation details)
        $qr_content = "Reservation ID: " . $reservation_id . "\n";
        $qr_content .= "Name " . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . "\n";
        $qr_content .= "Seat Number: " . $seat_number . "\n";
        $qr_content .= "Date: " . $date . "\n";
        $qr_content .= "Time: " . $start_time . " - " . $end_time . "\n";
        $qr_content .= "User ID: " . $user_id;
        

        // Generate the QR code URL
        $qrCodeUrl = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . urlencode($qr_content);

        // Display the reservation details in the card
        echo '<div class="container">
        <div class="card m-3 p-4 col" style="border-top: 10px solid #a81c1c;">
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center">
                            <img src="img/elib logo.png" style="width:70px" class="img-fluid rounded-start" alt="...">
                            <h1 class="card-title p-3">SOAR</h1>
                        </div>
                        
                        <p class="card-text fw-bold">Name: ' . $_SESSION["first_name"]  ." ". $_SESSION["last_name"]. '</p>
                        <p class="card-text fw-bold">Date: ' . $date . '</p>
                        <p class="card-text fw-bold">Time: ' . $start_time . ' - ' . $end_time . '</p>
                        <p class="card-text fw-bold">Seat No: ' . $seat_number . '</p>
                        <p class="card-text fw-bold">User ID: ' . $user_id . '</p>
                        <p class="card-text fw-bold" style="color: #a81c1c">Reservation No: ' . $reservation_id . '</p>
                    </div>
                </div>
                <div class="col-md-4 p-3  d-flex justify-content-center align-items-center">
                    <img src="' . $qrCodeUrl . '" alt="QR Code" class="img-fluid">
                </div>
            </div>
        </div>
        </div>';

        // Button for capturing and downloading the div as an image
        echo '<div class="container">
        <div class="text-center">
          
            <button onclick="printDiv()" class="btn btn-danger mt-3">Print Receipt</button>
        </div>
        </div>';
    } else {
        // Reservation not found
        echo "Reservation not found.";
    }
?>

<script>
    function captureAndDownload() {
        // Use html2canvas library to capture the div
        html2canvas(document.querySelector(".card")).then(canvas => {
            // Convert the canvas to a data URL
            const dataUrl = canvas.toDataURL("image/png");

            // Create a temporary link element to download the image
            const link = document.createElement("a");
            link.href = dataUrl;
            link.download = "reservation.png";

            // Trigger the download by programmatically clicking the link
            link.click();
        });
    }
    
    function printDiv() {
        var printContents = document.querySelector(".card").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>


<script>
    function captureAndDownload() {
        // Use html2canvas library to capture the div
        html2canvas(document.querySelector(".card")).then(canvas => {
            // Convert the canvas to a data URL
            const dataUrl = canvas.toDataURL("image/png");

            // Create a temporary link element to download the image
            const link = document.createElement("a");
            link.href = dataUrl;
            link.download = "card.png";

            // Trigger the download by programmatically clicking the link
            link.click();
        });
    }
</script>



    <!------------------------ HEADER --------------------->

   

<!------------------------ END HEADER --------------------->
