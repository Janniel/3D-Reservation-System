<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $oldPassword = $_POST['old_password'];
  $newPassword = $_POST['new_password'];

  // Retrieve the username from the session
  $username = $_SESSION['username'];

  // Retrieve the old password from the database
  $sql = "SELECT password FROM ACCOUNT WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();
      $storedOldPassword = $row['password'];

      // Verify the old password
      if ($oldPassword === $storedOldPassword) {
          // Update the password in the database
          $updateSql = "UPDATE ACCOUNT SET password = '$newPassword' WHERE username = '$username'";
          if ($conn->query($updateSql)) {
              $response = ['status' => 'success'];
          } else {
              $response = ['status' => 'error'];
          }
      } else {
          $response = ['status' => 'invalid_password'];
      }
  } else {
      $response = ['status' => 'error'];
  }

  echo json_encode($response);
}

?>
