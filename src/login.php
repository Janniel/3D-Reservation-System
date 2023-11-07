<?php
// Include the connect.php file
require_once 'php/connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
  $username = $_POST['username'];
  $password = $_POST['login_password'];
 
  // Check if the user is a regular user
  $sql = "SELECT * FROM account WHERE username = '$username' AND account_type != 'admin'";
  $result = $conn->query($sql);


// Check if a matching user record is found
  if ($result->num_rows == 1) {
    // Fetch the user's data from the database
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];
    $account_id = $row['account_id'];
    
    // Verify the provided password against the stored hash
    if (password_verify($password, $stored_password)) {
      // Passwords match, user is authenticated
      $sql2 = "SELECT * FROM users WHERE account_id = '$account_id'";
      $result2 = $conn->query($sql2);

      if ($result2->num_rows == 1) {
        $user_row = $result2->fetch_assoc();

        $_SESSION["username"] = $username;
        $_SESSION["account_type"] = $row['account_type'];
        $_SESSION["user_id"] = $user_row['user_id']; // Fetch user_id from the second query
        $_SESSION["first_name"] = $user_row['first_name'];
        $_SESSION["last_name"] = $user_row['last_name'];
        $_SESSION["reservation_count"] = $user_row['reservation_count'];

        header("Location: index.php");
        exit();
      } else {
        $error_message = "Invalid username or password";
        header("Location: login.php");
        exit();
      }
    } else {
      $error_message = "Invalid username or password";
      header("Location: login.php");
      exit();
    }
  } else {
    $error_message = "Invalid username or password";
    header("Location: login.php");
    exit();
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign in & Sign up Form</title>
  <!------------------------ CSS Link ------------------------>
  <link rel="stylesheet" href="css/login.css" />
  <!------------------------ Bootstrap 5.3.0 ------------------------>
  <!-- <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    
  </script>
  <style>
    .box {
  position: relative;
  width: 100%;
  max-width: 1320px;
  height: 800px;
  background-color: #fff;
  border-radius: 1.3rem;
  box-shadow: 0 60px 40px -30px rgba(0, 0, 0, 0.27);
}
.sign-up-form {
  max-width: 400px;
  width: 100%;
  margin: 0 auto;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  grid-column: 1 / 2;
  grid-row: 1 / 2;
  transition: opacity 0.02s 0.4s;
}

  </style>

</head>

<body>
<script>
          
          // Function to trigger the PHP script
          function triggerValidation() {
              var xhr = new XMLHttpRequest();
              xhr.open('GET', 'php/validateReservation.php', true);
              xhr.onreadystatechange = function () {
                  if (xhr.readyState === 4) {
                      if (xhr.status === 200) {
                          console.log('Checked expired validation');
                      } else {
                          console.log('Error in checking expired validation');
                      }
                  }
              };
              xhr.send();
          }
      
          // Call the function immediately
          triggerValidation();
      
          // Set up a recurring timer to call the function every 5 seconds (5000 milliseconds)
          setInterval(triggerValidation, 5000);
      </script>
<main>
  <div class="box">
    <div class="inner-box">
      <div class="forms-wrap">

        <!-- LOGIN FORM -->
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="on" class="sign-in-form needs-validation" novalidate>
          <div class="logo">
            <img src="img/elib logo.png" alt="easyclass" />
            <h4>SOAR</h4>
          </div>

          <div class="heading">
            <h2>Welcome Back</h2>
            <h6>Not registered yet?</h6>
            <a href="#" class="toggle">Sign up</a>
          </div>

          <div class="actual-form">
            <div class="form-floating mb-3">
              <input type="text" name="username" class="form-control" id="username" autocomplete="on" required>
              <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" name="login_password" class="form-control" id="login_password"  autocomplete="off" required>
              <label for="login_password">Password</label>
            </div>

            <?php if (isset($error_message)) { ?>
              <p style="color:red">
                <?php echo $error_message; ?>
              </p>
            <?php } ?>
            <p class="text">
              <a href="#">Forgot Password?</a>
            </p>
            <button type="submit" style="background-color: #a81c1c;"class="btn sign-btn text-white">Login</button>
            <div class="invalid-feedback">
              Invalid username or password.
            </div>
            
          </div>
        </form>
        <!-- END OF LOGIN FORM -->


        <!-- REGISTER FORM -->
        
        
        <form id="register-form" autocomplete="off" class="sign-up-form needs-validation">
            <div class="logo">
      <img src="img/elib logo.png" alt="easyclass" />
      <h4>SOAR</h4>
    </div>

    <div class="heading">
      <h6>Already have an account?</h6>
      <a href="#" class="toggle">Sign in</a>
    </div>

    <div class="actual-form">
    <div class="row mb-3">
    <div class="col">
      <div class="form-floating">
        <input type="text" name="firstName" minlength="1" class="form-control" id="firstName" autocomplete="off" required>
        <label for="firstName">First Name</label>
      </div>
    </div>
    <div class="col">
      <div class="form-floating">
        <input type="text" name="lastName"  minlength="1" class="form-control" id="lastName" autocomplete="off" required>
        <label for="lastName">Last Name</label>
      </div>
    </div>
  </div>


  <div class="row mb-3">
      <div class="col">
        <div class="form-floating">
        <select name="account_type" class="form-select" id="account_type" autocomplete="off" required>
        <option selected disabled></option>
          <option value="student">Regular Student</option>
          <option value="alumni">Old Student</option>
          <option value="faculty">Faculty</option>
        </select>
        <label for="account_type">Type</label>
        </div>
      </div>
      <div class="col">
        <div class="form-floating">
          <input type="number" name="user_id" class="form-control" id="user_id" autocomplete="off" required>
          <label for="user_id">ID Number</label>
          <div class="invalid-feedback">
        Sorry, it's already used.
      </div>
        </div>
      </div>
    </div>

    <div class="row mb-3">
    <div class="col">
      <div class="form-floating">
        <select name="courseCode" class="form-select" id="courseCode" autocomplete="off">
        <option selected disabled></option>
          <option value="BSIT">BSIT</option>
          <option value="BLIS">BLIS</option>
        </select>
        <label for="courseCode">Course</label>
      </div>
    </div>
  </div>


      <div class="row mb-3">
        <div class="col">
          <div class="form-floating">
            <select name="year_level" class="form-select" id="year_level">
            <option selected disabled></option>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
              <option value="5">5th Year</option>
            </select>
            <label for="year_level">Year</label>
          </div>
        </div>
        <div class="col">
          <div class="form-floating">
          <select name="section" class="form-select" id="section">
          <option selected disabled></option>
            <?php

              for ($i = 65; $i <= 90; $i++) {
                $optionValue = chr($i); // Convert ASCII value to character (A-Z)
                echo "<option value='$optionValue'>$optionValue</option>";
              }
            ?>
          </select>

            <label for="section">Section</label>
          </div>
        </div>
        <div class="col">
          <div class="form-floating">
            <select name="section_group" class="form-select" id="section_group">
            <option selected disabled></option>
              <option value="1">G1</option>
              <option value="2">G2</option>
              <!-- Add more section groups if needed -->
            </select>
            <label for="section_group">Group</label>
          </div>
        </div>
      </div>
  <!--   -->
  <div class="row mb-3">
      <div class="col">
        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="email" autocomplete="off" required>
          <label for="email">Email</label>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col">
        <div class="form-floating">
          <input type="password" name="new_password" class="form-control" id="new_password" autocomplete="off" required>
          <label for="new_password">Password</label>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <div class="form-floating">
          <!-- Update name to match the backend -->
          <input type="password" name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" required>
          <label for="confirm_password">Confirm Password</label>
        </div>
        <div class="invalid-feedback">
          Passwords do not match.
        </div>
      </div>
    </div>
  <p class="text">
        By signing up, I agree to the
        <a href="#" data-bs-toggle="modal" data-bs-target="#terms"><b>Terms of Services</b></a> and
        <a href="#" data-bs-toggle="modal" data-bs-target="#privacy"><b>Privacy Policy</b></a>
      </p>

      <div class="row mb-3">
      <div class="col">
        <button type="submit" style="background-color: #a81c1c;" class="btn text-white sign-btn" id="register-btn">Sign Up</button>
      </div>
    </div>

    
    </div>
</form>

      </div>


       <div class="carousel">
          <div class="images-wrapper">
            <img src="img/image1.png" class="image img-1 show" alt="" />
            <img src="img/image2.png" class="image img-2" alt="" />
            <img src="img/image3.png" class="image img-3" alt="" />
          </div>
          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Reserve.</h2>
                <h2>Track.</h2>
                <h2>Enjoy.</h2>
              </div>
            </div>
            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>

      
    </div>
  </div>
</main>


<script>
  $(document).ready(function() {
      // Define a regular expression pattern to match only letters
      var lettersOnlyPattern = /^[A-Za-z]+$/;

    // Attach an onchange event handler to the firstName input
    $('#firstName').on('input', function() {
        var firstName = $(this).val();

        if (lettersOnlyPattern.test(firstName)) {
          registerButton.prop('disabled', false);
        } else {
          registerButton.prop('disabled', true);
        }
    });
    $('#lastName').on('input', function() {
        var lastName = $(this).val();

        if (lettersOnlyPattern.test(lastName)) {
          registerButton.prop('disabled', false);
        } else {
          registerButton.prop('disabled', true);
        }
    });


    
    const registerForm = $('#register-form');
    const registerButton = $('#register-btn');

    // Disable the button initially
    registerButton.prop('disabled', true);

    registerForm.submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Check if all required fields are valid
      let formValid = true;
      $(this)
        .find('[required]')
        .each(function() {
          if (!this.checkValidity()) {
            formValid = false;
            $(this).addClass('is-invalid');
          } else {
            $(this).removeClass('is-invalid');
          }
        });

      // Check if passwords match
      const password = $('#new_password').val();
      const confirmPassword = $('#confirm_password').val();

      if (password !== confirmPassword) {
        formValid = false;
        $('#new_password').addClass('is-invalid');
        $('#confirm_password').addClass('is-invalid');
      }
      
  //     const userIdInput = document.getElementById('user_id');
  // const userIdValue = userIdInput.value;
  // if (userIdValue === 'used') {
  //   userIdInput.classList.add('is-invalid');
  //   // You may need to define formValid and update it as needed.
  //   // Assuming formValid is defined outside of this function.
  //   formValid = false;
  // } else {
  //   userIdInput.classList.remove('is-invalid');
  //   // Update formValid as needed.
  // }

      if (formValid) {
        // If all required fields are valid and passwords match, proceed with the AJAX request
        const formData = new FormData(this);

        $.ajax({
          url: 'toRegister.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            // Display a success message using SweetAlert2
            Swal.fire({
              icon: 'success',
              title: 'Registration Successful',
              text: 'You have successfully registered.',
              confirmButtonColor: '#a81c1c',
            }).then(function () {
              // Reload the page after the alert is closed
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Registration Error',
              text: 'Registration failed. Please try again.',
              confirmButtonColor: '#a81c1c',
            });
          }
        });
      }
    });

    // Disable or enable the button based on form validity
    registerForm.on('input', function() {
      const password = $('#new_password').val();
      const confirmPassword = $('#confirm_password').val();
      const userIdInput = $('#user_id');

      if (this.checkValidity() && password === confirmPassword && !userIdInput.hasClass('is-invalid')) {
        registerButton.prop('disabled', false);
      } else {
        registerButton.prop('disabled', true);
      }
    });

    // Check if userId is already used (you need to implement this logic)
    $('#user_id').on('change', function() {
      // Implement the logic to check if the user_id is already used
      // If it's already used, add the 'is-invalid' class to mark it as invalid
      // Example:
      const userIdValue = $(this).val();
      if (userIdValue === 'used') {
        $(this).addClass('is-invalid');
        registerButton.prop('disabled', true);
      } else {
        registerButton.prop('disabled', false);
      }
    });
  });
</script>




<script>
  // Enable Bootstrap's floating labels
  (function () {
    'use strict';
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
  })();
  
  $(document).ready(function () {
    $('#account_type').change(function () {
      var accountType = $(this).val();
      var courseField = $('#courseCode');
      var yearLevelField = $('#year_level');
      var sectionField = $('#section');
      var sectionGroupField = $('#section_group');

      // Disable or enable fields based on the selected account type
      if (accountType !== 'student') {
        courseField.prop('disabled', true);
        yearLevelField.prop('disabled', true);
        sectionField.prop('disabled', true);
        sectionGroupField.prop('disabled', true);
      } else {
        courseField.prop('disabled', false);
        yearLevelField.prop('disabled', false);
        sectionField.prop('disabled', false);
        sectionGroupField.prop('disabled', false);
      }
    });
  });

  
</script>


<!-- Modal -->

<?php include_once 'php/login_modal.php'?>


  <!-- <script>
  $(document).ready(function () {
    // Listen for form submission
    $("#register-form").submit(function (e) {
      // Check if the form is valid
      if (this.checkValidity() === false) {
        e.preventDefault(); // Prevent the default form submission
        e.stopPropagation();
        // Trigger Bootstrap validation styles
        $(this).addClass('was-validated');
      } else {
        // Perform Ajax request
        $.ajax({
          url: $(this).attr("action"),
          type: $(this).attr("method"),
          data: $(this).serialize(),
          success: function (response) {
            Swal.fire({
              icon: "success",
              title: "Registration Success!",
              text: "Please input your credentials to login!",
              showConfirmButton: false,
              timer: 1500,
            }).then(function () {
              // Reload the page after the alert is closed
              location.reload();
            });
          },
          error: function () {
            // Display error message using SweetAlert2
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "An error occurred. Please try again later.",
            });
          }
        });
      }
    });
  });
</script> -->


  </script>

  <!------------------------ For Sliding  ------------------------>

  <!-- Javascript file -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
</body>

</html>