<?php
require 'assets/php/connect.php';


if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $userId = $_DELETE["userId"];

    // Use a prepared statement to delete the user
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}



?>

