import "./styles/adminReviews.css"


const progressDone = document.querySelectorAll('.progress-done');

progressDone.forEach(progress => {
	progress.style.width = progress.getAttribute('data-done') + '%';
});


// SOCIAL PANEL JS
const floating_btn = document.querySelector('.floating-btn');
const close_btn = document.querySelector('.close-btn');
const social_panel_container = document.querySelector('.social-panel-container');