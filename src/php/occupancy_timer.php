<?php 
require 'connect.php';


$ongoing_query = "SELECT occupy.*, seat.seat_number, reservation.start_time, reservation.end_time 
                FROM occupy 
                INNER JOIN reservation ON occupy.reservation_id = reservation.reservation_id 
                INNER JOIN seat ON reservation.seat_id = seat.seat_id
                WHERE reservation.user_id = '{$_SESSION['user_id']}' 
                AND reservation.date = CURDATE() 
                AND occupy.isDone = 0";

$result = mysqli_query($conn, $ongoing_query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $start_time = strtotime($row['start_time']);
    $end_time = strtotime($row['end_time']);
    $reservation_id = $row['reservation_id'];
    // Convert the times to milliseconds since JavaScript works with milliseconds
    $start_time_milliseconds = $start_time * 1000;
    $end_time_milliseconds = $end_time * 1000;
} else {
    // Set default values if no ongoing reservation
    $start_time_milliseconds = 0;
    $end_time_milliseconds = 0;
}
?>


<!-- TIMER TOAST -->
<div class="pt-5 m-1 position-fixed top-0 end-0" style="z-index: 11; margin-top: 100px;">
    <div id="toastContainer" class="toast" style="background-color: #fff; border-left: 3px solid #ffc107; border-radius: 8px;">
        <div class="toast-body">
            <div id="toastBody">
                <div class="row">
                    <div class="col-2">
                        <!-- Icon -->
                        <i class="fas fa-exclamation-triangle me-2 text-dark m-2"></i>
                    </div>
                    <div class="col">
                        <b>Your time will end soon!</b>
                        <p id="remainingTime">Time left:</p>
                        <a href="timer.php" class="btn btn-warning btn-sm" style="margin-left: auto;">View   </a>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ensure you have Font Awesome included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.css">


<script>
    $(document).ready(function() {
        var timerInterval;
        var toastShown = false;

        function displayToast() {
            $('#toastContainer').toast('show');
            toastShown = true;
        }

        function hideToast() {
            $('#toastContainer').toast('hide');
            clearInterval(timerInterval);
       
        }

        function updateRemainingTime() {
            var currentTime = new Date().getTime();
            var remainingTime = Math.max(0, <?php echo $end_time_milliseconds; ?> - currentTime);

            var minutes = Math.floor(remainingTime / (1000 * 60));
            var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
            var remainingTimeString = minutes + 'm ' + seconds + 's';

            $('#remainingTime').text('Time left: ' + remainingTimeString);

            if (remainingTime <= fiveMinutesInMillis && !toastShown) {
                displayToast();
            }

            if (remainingTime <= 0) {
                hideToast();
                $.ajax({
                url: 'php/toAddHistory.php?reservation_id=<?php echo $reservation_id; ?>',
                type: 'GET',
                success: function (response) {
                    console.log(' completed');
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
                    console.log('errpr adding to history. [occupancy timer said]');
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
        }

        //set 5 minutes 
        var fiveMinutesInMillis = 60 * 60 * 1000;
        timerInterval = setInterval(updateRemainingTime, 1000);
    });
</script>


<?php
$query = "SELECT * FROM reservation WHERE date >= CURDATE() AND end_time <= CURTIME() AND isDone = 0";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservation_id = $row['reservation_id'];
        $date = date('F j, Y', strtotime($row['date']));
        $start_time = date('h:i A', strtotime($row['start_time']));
        $end_time = date('h:i A', strtotime($row['end_time']));
        $seat_id = $row['seat_id'];
        $isDone = $row['isDone'];

        // Calculate the time remaining in seconds
        $end_timestamp = strtotime($row['date'] . ' ' . $row['end_time']);
        $current_timestamp = time();
        $time_remaining = $end_timestamp - $current_timestamp;

        if ($time_remaining <= 0) {
            // If the reservation time has expired, trigger the PHP script
            ?>
            <script>
                // Swal.fire({
                //     title: 'Your time has ended!',
                //     text: 'Your reservation time has expired.',
                //     icon: 'warning',
                //     showConfirmButton: false,
                //     timer: 3000,
                // });

            
                    // After 3 seconds, trigger the PHP script using AJAX
                    $.ajax({
                        url: 'toAddHistory.php?reservation_id=<?php echo $reservation_id; ?>',
                        type: 'GET',
                        success: function (response) {
                            console.log('Some reservation is completed');
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log('Error adding to history');
                        }
                    });
               
            </script>
            <?php
        }
    }
}
?>
