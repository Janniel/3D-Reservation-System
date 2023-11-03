<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php
$query = "SELECT * FROM reservation WHERE date <= CURDATE() AND end_time <= CURTIME() AND isDone = 0";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservation_id = $row['reservation_id'];
        $end_timestamp = strtotime($row['date'] . ' ' . $row['end_time']);
        $current_timestamp = time();
        
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
?>

