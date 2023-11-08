<?php 

session_start();
require 'connect.php';

if (isset($_GET['seat_id'])) {
    $seat_id = $_GET['seat_id'];

    // Check if the selected seat exists in the database
    $query = "SELECT * FROM seat WHERE seat_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $seat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        // Update the status of the seat
        $sql = "UPDATE seat SET status = 0 WHERE seat_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $seat_id);

        if (mysqli_stmt_execute($stmt)) {
            // Seat status updated successfully
            echo "success";
        } else {
            // Error occurred during the update
            echo "error";
        }

        mysqli_stmt_close($stmt);
    } else {
        // The seat with the specified ID does not exist
        echo "error";
    }
} else {
    // 'seat_id' parameter is missing in the URL
    echo "error: 'seat_id' parameter is missing in the URL";
}

mysqli_close($conn);


?>