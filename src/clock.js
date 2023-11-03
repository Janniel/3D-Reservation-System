import "./styles/home.css"

function updateTime() {
    const clock = document.getElementById('clock');
    const now = new Date();
    let hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    let timeOfDay = 'AM';

    if (hours >= 12) {
        timeOfDay = 'PM';
        if (hours > 12) {
            hours -= 12;
    
    
        }
    }

    hours = hours.toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds} ${timeOfDay}`;

    clock.textContent = timeString;
}

setInterval(updateTime, 1000);

updateTime();

function updateClock() {
    const dateElement = document.getElementById("date");
    const timeElement = document.getElementById("time"); // Add an element for time
    const currentDate = new Date();

    const daysOfWeek = [
      "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    ];
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];

    const dayOfWeek = daysOfWeek[currentDate.getDay()];
    const month = months[currentDate.getMonth()];
    const day = currentDate.getDate();
    const year = currentDate.getFullYear();
    const dateString = `${dayOfWeek}, ${month} ${day}, ${year}`;

    // Display the date
    dateElement.textContent = dateString;

    const timeString = currentDate.toLocaleTimeString();

    // Display the time
    timeElement.textContent = timeString;
}

// Update the clock every second
setInterval(updateClock, 1000);

// Initial call to set the date and time
updateClock();