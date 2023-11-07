
const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

import "./styles/login.css"

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

let currentIndex = 0;  // Add a variable to keep track of the current image index

function moveSlider() {
  bullets[currentIndex].classList.remove("active");  // Remove the active class from the current bullet
  images[currentIndex].classList.remove("show");  // Hide the current image

  currentIndex = parseInt(this.dataset.value) - 1;  // Update the current index based on the clicked bullet
  if (currentIndex < 0) currentIndex = images.length - 1;  // Handle wrap-around to the last image

  images[currentIndex].classList.add("show");  // Show the new current image
  bullets[currentIndex].classList.add("active");  // Update the bullet for the new current image
}

// Automatically slide to the next image every 1 second
function autoSlide() {
  const nextIndex = (currentIndex + 1) % images.length;  // Calculate the index of the next image

  bullets[currentIndex].classList.remove("active");  // Remove the active class from the current bullet
  images[currentIndex].classList.remove("show");  // Hide the current image

  currentIndex = nextIndex;  // Update the current index to the next image
  images[currentIndex].classList.add("show");  // Show the new current image
  bullets[currentIndex].classList.add("active");  // Update the bullet for the new current image
}

// Set up the interval to automatically slide the carousel every 3 second
let slideInterval = setInterval(autoSlide, 3000);

// Stop the automatic sliding when a bullet is clicked
bullets.forEach((bullet) => {
  bullet.addEventListener("click", () => {
    clearInterval(slideInterval);  // Clear the automatic sliding interval
    moveSlider.call(bullet);  // Manually move to the clicked image
    slideInterval = setInterval(autoSlide, 3000);  // Restart the automatic sliding
  });
});


// Function to validate existence user_id on db
function checkUserIdAvailability() {
	var user_id = $('#user_id').val();
	$.ajax({
		url: 'php/check_user_id.php',
		type: 'POST',
		data: {
			user_id: user_id
		},
		success: function(response) {
			if (response == 'exists') {
				$('#user_id').addClass('is-invalid');
				$('#register-btn').prop('disabled', true);
			} else {
				$('#user_id').removeClass('is-invalid');
				$('#register-btn').prop('disabled', false);
			}
		}
	});
}
// Function to validate password fields
function validatePasswords() {
	var password = $('#new_password').val();
	var confirm_password = $('#confirm_password').val();
	if (password !== confirm_password) {
		$('#confirm_password').addClass('is-invalid');
		$('#password_error').show();
		console.log('Passwords do not match');
	} else {
		$('#confirm_password').removeClass('is-invalid');
		$('#password_error').hide();
		console.log('Passwords match');
	}
}

$('#user_id').on('change', checkUserIdAvailability);
$('#new_password, #confirm_password').on('change', validatePasswords);