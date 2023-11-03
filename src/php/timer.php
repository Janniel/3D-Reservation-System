<?php
session_start();
require 'connect.php';
require 'session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.0.1/model-viewer.min.js"></script>
    <title>Reserve3D</title>
    <!------------------------ Bootstrap 5.3.0 ------------------------>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!------------------------ CSS Link ------------------------>
    <!-- <link rel="stylesheet" type="text/css" href="../styles/timer.css" /> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>

<script>
     // mark as done function will be trigger if the reservation time is over
     function markReservationAsDone(reservationId) {
        Swal.fire({
            title: 'Occupying Done?',
            text: 'This button will serve as act of removing RFID card on the reader will automatically submit this form',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d3d3d3',
            confirmButtonText: 'Mark available'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update seat status and move reservation to history
                // mark as done button
                $.ajax({
                    url: `toAddHistory.php?reservation_id=${reservationId}`,  
                    type: 'GET',
                    success: function (response) {
                        window.location.href = `survey.php`;
                        
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while marking the reservation as done.',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }
</script>

    <div class="wrapper">

        <!-- Sticky header -->
        <?php 
        // include 'header.php'; 
        ?>
        <!-- Sticky header -->

        <!------------------------ TIMER START ------------------------>
        <div class="container" id="container">
            <div class="form-container sign-in-container">
                <form action="#">
                <?php
$ongoing_query = "SELECT occupy.*, seat.seat_number, reservation.start_time, reservation.end_time 
                FROM occupy 
                INNER JOIN reservation ON occupy.reservation_id = reservation.reservation_id 
                INNER JOIN seat ON reservation.seat_id = seat.seat_id
                WHERE reservation.user_id = '{$_SESSION['user_id']}' 
                AND reservation.date = CURDATE() 
                AND occupy.isDone = 0";

$ongoing_result = mysqli_query($conn, $ongoing_query);


if (mysqli_num_rows($ongoing_result) > 0) {
    $row = mysqli_fetch_assoc($ongoing_result);
    $seat_number = $row['seat_number'];
    $start_time = date('h:i A', strtotime($row['start_time'])); // Convert start time to AM/PM format
    $end_time = date('h:i A', strtotime($row['end_time'])); // Convert end time to AM/PM format
    $reservation_id = $row['reservation_id'];

    $start_time_raw = $row['start_time'];
    $end_time_raw = $row['end_time'];

    $end_timestamp = strtotime($row['end_time']);
    $current_timestamp = time();
    $remaining_time = max(0, $end_timestamp - $current_timestamp); // Remaining time in seconds

    // Calculate the remaining time in seconds
    $end_timestamp = strtotime($row['end_time']);
    $current_timestamp = time();
    $remaining_seconds = max(0, $end_timestamp - $current_timestamp); // Remaining time in seconds

    $remaining_hours = floor($remaining_seconds / 3600); // Calculate remaining hours
    $remaining_minutes = floor(($remaining_seconds % 3600) / 60); // Calculate remaining minutes
    $remaining_seconds %= 60; // Calculate remaining seconds

    echo "<h1>Seat {$seat_number}</h1>";
    echo "<span>6th Floor</span>";
    echo "<h5>{$start_time} - {$end_time}</h5>";
    echo "<i>Please don't forget your ID when done</i><br>";
    echo "<a href='#' class='btn btn-outline-danger btn-sm' onclick='markReservationAsDone({$row['reservation_id']});'>Mark as Done</a>";
    echo "<div id='extendtimeDiv' style='display:none'><button onclick='extendReservationTime(event)' class='btn btn-danger'>extend 30 mins</button><br>";
    echo "</div>";
    
} else {
    echo "<h1>No ongoing reservations for this user.</h1>";
    $remaining_time = 0; // No ongoing reservations
}

mysqli_free_result($ongoing_result);
?>

                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Time Left:</h1>
                        <div id="app"></div>

                        <script>
        // Start the timer if there is remaining time
        if (TIME_LIMIT > 0) {
            document.getElementById("app").innerHTML = `
                <div class="base-timer">
                    <!-- Rest of the timer HTML remains the same -->
                </div>
            `;
            startTimer();
        }
    </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------JAVASCRIPT-------->

    <script>

   



// function that extend the time
function extendReservationTime(event) {
    event.preventDefault();
    const reservationId = <?php echo $reservation_id ?>; // Get the reservation ID from PHP
    const seatId = <?php echo $seat_number ?>;
  
    const endTime = <?php echo strtotime($row['end_time']) ?>;
    const startTime = <?php echo strtotime($row['start_time']) ?>;

    Swal.fire({
        title: 'Extend Time?',
        text: 'Add more 30 minutes?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#a81c1c',
        cancelButtonColor: '#d3d3d3',
        confirmButtonText: 'Extend',
        
    }).then((confirmResult) => {
        if (confirmResult.isConfirmed) {
            $.ajax({
                url: 'extendProcess.php',
                type: 'POST',
                data: { 
                    reservation_id: reservationId,
                    seat_id: seatId,
                    start_time_raw: startTime,
                    end_time_raw: endTime
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Reservation Time Extended',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#a81c1c'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed to extend time',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: '#a81c1c',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while extending the reservation time.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}




    </script>



 <script>
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 10;
    const ALERT_THRESHOLD = 5;

    const COLOR_CODES = {
        info: {
            color: "green"
        },
        warning: {
            color: "orange",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "red",
            threshold: ALERT_THRESHOLD
        }
    };
    const TIME_LIMIT = <?php echo $remaining_time; ?>;

    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;

    document.getElementById("app").innerHTML = `
        <div class="base-timer">
            <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="base-timer__circle">
                    <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                    <path
                        id="base-timer-path-remaining"
                        stroke-dasharray="283"
                        class="base-timer__path-remaining ${remainingPathColor}"
                        d="
                        M 50, 50
                        m -45, 0
                        a 45,45 0 1,0 90,0
                        a 45,45 0 1,0 -90,0
                        "
                    ></path>
                </g>
            </svg>
            <span id="base-timer-label" class="base-timer__label">${formatTime(timeLeft)}</span>
        </div>
    `;
    let extendButtonShown = false;
    startTimer();

    function onTimesUp() {
        clearInterval(timerInterval);
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            document.getElementById("base-timer-label").innerHTML = formatTime(timeLeft);
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

             // Check if timeLeft is 5 minutes
            if (timeLeft <= 300 && !extendButtonShown) {  // 5 minutes = 300 seconds
                // less than 5 minutes
                extendButtonShown = true;
                document.getElementById("extendtimeDiv").style = 'block';
               
               
                
            }
            

            if ((timeLeft === 0) || (timeLeft <= 0)) {
                onTimesUp();
                $.ajax({
                url: `toAddHistory.php?reservation_id=<?php echo $reservation_id;?>`,  
                type: 'GET',
                success: function (response) {
                    Swal.fire({
                        title: 'Time\'s Up',
                        text: 'Your reservation time is up!',
                        icon: 'success',
                        confirmButtonColor: '#a81c1c',
                        confirmButtonText: 'OK',
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = `survey.php`;
                    });
                   
                },
                error: function (xhr, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while marking the reservation as done.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });
               
            }
        }, 1000);
    }

    // function formatTime(time) {
    //     const minutes = Math.floor(time / 60);
    //     const seconds = time % 60;
    //     return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    // }

    function formatTime(time) {
    if (time < 0) {
        return 'Time\'s Up';
    }

    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    return `${minutes}:${seconds < 10 ? '0' : ''}${Math.max(seconds, 0)}`;
    }


    function setRemainingPathColor(timeLeft) {
        const { alert, warning, info } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
            document.getElementById("base-timer-path-remaining").classList.remove(warning.color);
            document.getElementById("base-timer-path-remaining").classList.add(alert.color);
        } else if (timeLeft <= warning.threshold) {
            document.getElementById("base-timer-path-remaining").classList.remove(info.color);
            document.getElementById("base-timer-path-remaining").classList.add(warning.color);
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(calculateTimeFraction() * FULL_DASH_ARRAY).toFixed(0)} 283`;
        document.getElementById("base-timer-path-remaining").setAttribute("stroke-dasharray", circleDasharray);
    }
</script>

</body>

</html>
