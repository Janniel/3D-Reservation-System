<div class="reservations-wrapper">
    <h2>
        You reserved
        <?php
        $count_query = "SELECT COUNT(*) AS reservation_count FROM reservation WHERE user_id = '{$_SESSION['user_id']}' AND date >= CURDATE()";
        $count_result = mysqli_query($conn, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $reservation_count = $count_row['reservation_count'];

        // Retrieve the maximum reservation per day from the settings table
        $settings_query = "SELECT reservePerDay FROM settings WHERE settings_id = '1'";
        $settings_result = mysqli_query($conn, $settings_query);
        $settings_row = mysqli_fetch_assoc($settings_result);
        $reservePerDay = $settings_row['reservePerDay'];

        $_SESSION["reservation_count"] = $reservation_count;

        echo "<span class='total-reservation'>{$reservation_count} out of {$reservePerDay}</span>";
        ?>
    </h2>

    <div class="reservations">
        <?php
        $query = "SELECT * FROM reservation WHERE user_id = '{$_SESSION['user_id']}' AND date >= CURDATE()  ORDER BY reservation_id DESC LIMIT {$reservePerDay}";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $seat_id = $row['seat_id'];
                $date = date('F j, Y', strtotime($row['date'])); // Convert date to desired format
                $start_time = date('h:i A', strtotime($row['start_time'])); // Convert start time to AM/PM format
                $end_time = date('h:i A', strtotime($row['end_time'])); // Convert end time to AM/PM format

                // Retrieve additional information related to the reservation, such as seat details
                $seat_query = "SELECT * FROM seat WHERE seat_id = '$seat_id'";
                $seat_result = mysqli_query($conn, $seat_query);
                $seat_row = mysqli_fetch_assoc($seat_result);
                $seat_number = $seat_row['seat_number'];

                // Display the pending reservation information
                echo "<div class='row'><div class='col-6'>";
                echo "<h3>Seat {$seat_number}</h3>";
                echo "<p><ion-icon name='time-outline'></ion-icon> {$start_time} - {$end_time}<br>";
                echo "<ion-icon name='calendar-outline'></ion-icon> {$date}</p></div>";

                // Add View Details button
                echo "<div class='col'>";
                echo "<a href='receipt.php?reservation_id={$row['reservation_id']}' class='btn btn-danger btn-sm'>View Details</a>&nbsp";

                $reservation_id = $row['reservation_id']; // Assuming you have the reservation_id from your loop

                // Check if the reservation_id exists in the history table
                $sql_check_history = "SELECT COUNT(*) AS history_count FROM history WHERE reservation_id = $reservation_id";
                $result_check_history = $conn->query($sql_check_history);

                // Check if the reservation_id exists in the occupy table
                $sql_check_occupy = "SELECT COUNT(*) AS occupy_count FROM occupy WHERE reservation_id = $reservation_id";
                $result_check_occupy = $conn->query($sql_check_occupy);

                if ($result_check_occupy && $result_check_history) {
                    $row_check_history = $result_check_history->fetch_assoc();
                    $history_count = $row_check_history['history_count'];

                    $row_check_occupy = $result_check_occupy->fetch_assoc();
                    $occupy_count = $row_check_occupy['occupy_count'];

                    // Check if the reservation is found in the history table
                    if ($history_count > 0) {
                        echo "<small class='text-success'>Completed</small>";
                    }
                    // Check if the reservation is found in the occupy table
                    elseif ($occupy_count > 0) {
                        echo "<small class='text-warning' onclick='return false;' disabled>Occupying</small>";
                    }
                    // If not found in history or occupy table, display the Delete button
                    else {
                        echo "<a href='#' class='btn text-danger btn-sm' onclick='confirmDelete({$row['reservation_id']}); return false;'>Cancel</a>";
                    }
                } else {
                    // Handle SQL error if needed
                    echo "Error: " . $conn->error;
                }

                echo "</div>";

                echo "</div>";
                echo "<br><br>";
            }
        } else {
            // No pending reservations found
            echo "<center> <br> <br> <br> <br> <br>No reservations yet. <br><br><a class='btn btn-outline-secondary 'href='reserve.php'>Reserve seat</a></center>";
        }
        ?>
    </div>
</div>
