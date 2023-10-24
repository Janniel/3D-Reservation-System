<div class="reservations-wrapper">
    <h2>Ongoing Reservations</h2>

    <?php
    // Fetch ongoing reservations from the occupy table
    $ongoing_query = "SELECT * FROM occupy 
                      INNER JOIN reservation ON occupy.reservation_id = reservation.reservation_id 
                      AND occupy.isDone = 0
                      INNER JOIN seat ON reservation.seat_id = seat.seat_id
                      WHERE reservation.user_id = '{$_SESSION['user_id']}' AND reservation.date = CURDATE()";
    $ongoing_result = mysqli_query($conn, $ongoing_query);

    if (mysqli_num_rows($ongoing_result) > 0) {
        while ($row = mysqli_fetch_assoc($ongoing_result)) {
            $seat_number = $row['seat_number'];
            $start_time = date('h:i A', strtotime($row['start_time'])); // Convert start time to AM/PM format
            $end_time = date('h:i A', strtotime($row['end_time'])); // Convert end time to AM/PM format
            
            // Calculate the remaining time in seconds
            $end_timestamp = strtotime($row['end_time']);
            $current_timestamp = time();
            $remaining_seconds = max(0, $end_timestamp - $current_timestamp); // Remaining time in seconds

            $remaining_minutes = floor($remaining_seconds / 60); // Calculate remaining minutes
            $remaining_seconds %= 60; // Calculate remaining seconds

            // Display ongoing reservation information
            echo "<div class='row'><div class='col-6'>";
            echo "<h3>Seat {$seat_number}</h3>";
            echo "<p><ion-icon name='time-outline'></ion-icon> {$start_time} - {$end_time} Remaining Time: ";

            if ($remaining_minutes > 0) {
                echo "{$remaining_minutes} minutes";
                if ($remaining_seconds > 0) {
                    echo " and {$remaining_seconds} seconds";
                }
            } else {
                echo "{$remaining_seconds} seconds";
            }

            echo "</p></div>";

            // Add View Details button
            echo "<div class='col'>";
            // echo "<a href='#' class='btn btn-outline-danger btn-sm' onclick='markReservationAsDone({$row['reservation_id']}); return false;'>Mark as Done</a>";
            echo "<a href='php/timer.php' class='btn btn-danger btn-sm'; return false;'>View Time</a>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>No ongoing reservations.</p>";
    }
    ?>
</div>
<script>
//         function markReservationAsDone(reservationId) {
//     Swal.fire({
//         title: 'Occupying Done?',
//         text: 'This button will serve as act of removing RFID card on the reader will automatically submit this form',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: 'green',
//         cancelButtonColor: '#d3d3d3',
//         confirmButtonText: 'Mark this seat as available'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // Send AJAX request to update seat status and move reservation to history
//             // mark as done button
//             $.ajax({
//                 url: `toAddHistory.php?reservation_id=${reservationId}`,  
//                 type: 'GET',
//                 success: function (response) {
//                     window.location.href = `survey.php`;
                    
//                 },
//                 error: function (xhr, textStatus, errorThrown) {
//                     Swal.fire({
//                         title: 'Error',
//                         text: 'An error occurred while marking the reservation as done.',
//                         icon: 'error',
//                         confirmButtonColor: '#d33',
//                         confirmButtonText: 'OK'
//                     });
//                 }
//             });
//         }
//     });
// }

</script>