<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php
$current_timestamp = time();

$query = "SELECT * FROM reservation WHERE date <= CURDATE() AND end_time <= CURTIME() AND isDone = 0";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservation_id = $row['reservation_id'];
        $end_timestamp = strtotime($row['date'] . ' ' . $row['end_time']);
        
        
        if ($current_timestamp >= $end_timestamp) {
            echo "<body>
                <script>
                    // After 3 seconds, trigger the PHP script using AJAX
                    $.ajax({
                        url: 'php/toAddHistory.php?reservation_id=$reservation_id',
                        type: 'GET',
                        success: function (response) {
                            console.log('Reservation $reservation_id completed and added to history.');
                            Swal.fire({
                                icon: 'info',
                                title: 'Missed Reservation',
                                text: 'You have missed one of your reservations. Check history to view more details.',
                                showCancelButton: false,
                                confirmButtonColor: '#a81c1c',
                                confirmButtonText: 'Ok, I Understand',
                                
                            }).then(function () {
                                location.reload();
                            });
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log('Error adding reservation $reservation_id to history');
                        }
                    });
                </script>
                </body>
            ";
        }
        
    }
}


// Get the current timestamp
$current_timestamp = time();

// Select reservations that meet the conditions
$query1 = "SELECT * FROM reservation WHERE date = CURDATE() AND isDone = 0";
$result1 = mysqli_query($conn, $query1);

if (mysqli_num_rows($result1) > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $reservation_id = $row1['reservation_id']; 
        $start_timestamp = strtotime($row1['date'] . ' ' . $row1['start_time']);
        
        // Calculate the time difference in seconds
        $time_difference = $current_timestamp - $start_timestamp;
        
        // Check if the user occupied the seat
        $query2 = "SELECT * FROM occupy WHERE reservation_id = $reservation_id";
        $result2 = mysqli_query($conn, $query2);
        
        if (mysqli_num_rows($result2) == 0 && $time_difference >= 600) {
            // The user did not occupy the seat within 10 minutes
            echo "<script>
                // After 3 seconds, trigger the PHP script using AJAX
                $.ajax({
                    url: 'php/toAddHistory.php?reservation_id=$reservation_id',
                    type: 'GET',
                    success: function (response) {
                        console.log('Reservation $reservation_id completed and added to history.');
                        Swal.fire({
                            icon: 'info',
                            title: '10 minutes already passed',
                            text: 'You have missed one of your reservations. Check history to view more details.',
                            showCancelButton: false,
                            confirmButtonColor: '#a81c1c',
                            confirmButtonText: 'Ok, I Understand',
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log('Error adding reservation $reservation_id to history');
                    }
                });
            </script>";
        }
    }
}



?>

