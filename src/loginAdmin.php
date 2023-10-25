<?php
// Include the connect.php file
require_once 'php/connect.php';
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the user is an admin
  $sql = "SELECT * FROM ACCOUNT 
  INNER JOIN ADMIN ON ACCOUNT.account_id = ADMIN.account_id 
  WHERE ACCOUNT.username = '$username' AND account_type = 'admin'";
  $result = $conn->query($sql);

  // if admin account found
  if ($result->num_rows == 1) {
    // Fetch the admin details
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    if (password_verify($password, $stored_password)) {
      $account_id = $row['account_id'];
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $admin_id = $row['admin_id'];
      $email = $row['email'];
      $isSuperAdmin = $row['isSuperAdmin'];
      $gender = $row['gender'];
      $account_type = $row['account_type'];

      // Set the session variables for admin
      $_SESSION["account_id"] = $account_id;
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $stored_password;
      $_SESSION["admin_id"] = $admin_id;
      $_SESSION["first_name"] = $first_name;
      $_SESSION["last_name"] = $last_name;
      $_SESSION["email"] = $email;
      $_SESSION["isSuperAdmin"] = $isSuperAdmin;
      $_SESSION["gender"] = $gender;
      $_SESSION["account_type"] = $account_type;

      header("Location: admin.php");
      exit();
    } else {
      // Passwords don't match, login failed
      $error_message = "Invalid username or passwords";
    }

  }

  // Login failed
  $error_message = "Invalid username or passwordz";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Log In</title>
  <!------------------------ CSS Link ------------------------>
  <link rel="stylesheet" href="css/loginAdmin.css" />
  <!------------------------ Bootstrap 5.3.0 ------------------------>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

  <div class="container">
    <img src="img\elib logo.png" alt="Logo">
    <h1>Welcome, Admin!</h1>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="on" class="sign-in-form">
      <input type="text" name="username" placeholder="Username" autocomplete="off">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" value="Sign In" class="loginButton" />
      <p><a href="#">Forgot Password?</a></p>
    </form>
  </div>

</body>

</html>