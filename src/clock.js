import "./styles/home.css"

function updateTime() {
    const clock = document.getElementById('clock');
    
    // Make an AJAX request to get the server's time
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/get_server_time.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const serverTime = new Date(response.server_time);
            
            const options = {
                timeZone: 'Asia/Manila',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            
            const timeString = serverTime.toLocaleTimeString('en-US', options);
            
            clock.textContent = timeString;
        }
    };
    xhr.send();
}

setInterval(updateTime, 1000);

updateTime();