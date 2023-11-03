<?php
session_start();
require 'php/connect.php';
require 'php/session.php';
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Review</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="css/survey.css" /> -->
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <!-- Include Swal2 CSS and JS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <!-- Custom CSS for Stars -->
    <style>
        .star {
            font-size: 24px;
            color: #ccc; /* Default color for empty star */
            cursor: pointer;
        }

        .star.selected {
            color: gold; /* Color for selected (filled) star */
        }
        /* Survey */
.survey {
  background: var(--white);
  padding: 2rem;
  max-width: 576px;
  border-radius: 0.75rem;
  box-shadow: var(--shadow);
  text-align: center;
  width: 90%;
  position: relative;
  margin: auto;
  margin-top: 10%;
  margin-bottom: 10%;
}
.survey h3 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
.rating {
  display: flex;
  justify-content: center;
  align-items: center;
  grid-gap: 0.5rem;
  font-size: 2rem;
  color: var(--yellow);
  margin-bottom: 2rem;
}
.rating .star {
  cursor: pointer;
}
.rating .star.active {
  opacity: 0;
  animation: animate 0.5s calc(var(--i) * 0.1s) ease-in-out forwards;
}

@keyframes animate {
  0% {
    opacity: 0;
    transform: scale(1);
  }
  50% {
    opacity: 1;
    transform: scale(1.2);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.rating .star:hover {
  transform: scale(1.1);
}
textarea {
  width: 100%;
  background: var(--light);
  padding: 1rem;
  border-radius: 0.5rem;
  border: none;
  outline: none;
  resize: none;
  margin-bottom: 0.5rem;
}
.btn-group {
  display: flex;
  grid-gap: 0.5rem;
  align-items: center;
}
.btn-group .btn {
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  border: none;
  outline: none;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
}
.btn-group .btn.submit {
  background: var(--submit);
  color: var(--white);
}
.btn-group .btn.submit:hover {
  background: var(--blue-d-1);
}
.btn-group .btn.cancel {
  background: var(--white);
  color: var(--submit);
}
.btn-group .btn.cancel:hover {
  background: var(--light);
}
/* END of Survey */
    </style>
</head>

<body>



    <div class="wrapper">
        <!-- SURVEY -->
        <div class="survey">
            <h3>Tell us how was your experience.</h3>
            <form action="surveyProcess.php" method="post">
                <div class="rating">
                    <input type="number" name="rating" hidden>
                    <i class="fas fa-star star" data-rating="1"></i>
                    <i class="fas fa-star star" data-rating="2"></i>
                    <i class="fas fa-star star" data-rating="3"></i>
                    <i class="fas fa-star star" data-rating="4"></i>
                    <i class="fas fa-star star" data-rating="5"></i>
                </div>
                <textarea name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger w-100">Submit Review</button>
                    </form>
                    <a href="index.php"class="btn cancel">Cancel</a>
                </div>
           
        </div>
        <!-- END OF SURVEY -->

        <!-- FOOTER (commented out for brevity) -->
        <!-- ... -->
    </div>

    <script>
        $(document).ready(function() {
    // Function to handle clicking on a star
    $(".star").click(function() {
        // Get the index of the clicked star
        var starIndex = $(this).data('rating');

        // Set the hidden input field with the selected rating
        $('input[name="rating"]').val(starIndex);

        // Highlight the selected stars
        $(".star").removeClass("selected");
        $(".star:lt(" + starIndex + ")").addClass("selected");
    });

    // Function to handle the form submission
    $("form").submit(function(event) {
        event.preventDefault();

        // Retrieve the selected rating and opinion
        var rating = $('input[name="rating"]').val();
        var opinion = $('textarea[name="opinion"]').val();

        // Send the data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "surveyProcess.php", // Adjust the URL to the correct endpoint
            data: {
                rating: rating,
                opinion: opinion
            },
            success: function(response) {
                console.log("Record inserted successfully!");
                Swal.fire({
                        title: 'Successfully submitted!',
                        icon: 'success',
                        confirmButtonColor: 'darkred',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `index.php`;
                        }
                    });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                // Handle errors and display an appropriate message
            }
        });
    });
});

    </script>

  

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
</body>

</html>
