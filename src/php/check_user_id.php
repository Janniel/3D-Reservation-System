<?php
require 'connect.php';

if (isset($_POST['user_id'])) {
  $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

  $query = "SELECT * FROM users WHERE user_id = '$user_id'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    echo 'exists';
  } else {
    echo 'available';
  }
}
?>
