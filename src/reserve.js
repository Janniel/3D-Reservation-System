import * as THREE from 'three'
import "./styles/reserve.css"
import interior from "./models/interior final.glb"
import gsap from "gsap"
import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader'
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader'

let date;
let startTime;
let endTime;

let seatsViewed = false;

//Scene
const scene = new THREE.Scene()


let seatMaterials = {};
//GLTF Loader
const loader = new GLTFLoader()
let gltfmodel;
loader.load("./models/interior final.glb", function(gltf) {
  console.log(gltf)
  gltfmodel = gltf.scene
  gltfmodel.scale.set(1,1,1)
  gltfmodel.position.y = -0.2
  scene.add(gltfmodel);

   // Store the original material color for each seat
   gltfmodel.traverse((object) => {
    if (object.isMesh) {
      seatMaterials[object.name] = object.material.clone();
    }
  });
 

  // PRINTS THE EXACT CAMERA POSITION AND CONTROLS TARGET
  // window.addEventListener('mouseup', function() {
  //   console.log(('Camera Position: '), camera.position)
  //   console.log(('Controls Target: '), controls.target)

  // })

// TIMELINE
const tl = gsap.timeline({defaults: {duration: 1}})
tl.fromTo(gltfmodel.scale, {z:0, x:0, y:0}, {z: 0.20, x: 0.20, y: 0.20})
showtitle()
})

//DRACO Loader
const dLoader = new DRACOLoader()
dLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');
dLoader.setDecoderConfig ({type: 'js'});
loader.setDRACOLoader(dLoader);

//Sizes
const sizes = {
    width: window.innerWidth,
    height: window.innerHeight,
  }
  
//Light
// const light = new THREE.AmbientLight(0x404040, 10, 100)
// scene.add(light)

const light2 = new THREE.HemisphereLight(0xD1D1D1, 0xFFB92E, 2)
scene.add(light2)

//Camera
const fov = 50;
const camera = new THREE.PerspectiveCamera(fov, sizes.width/sizes.height, 0.1, 100)
camera.position.x = -0.34
camera.position.z = 1.315
camera.position.y = -0.059
scene.add(camera)





//Renderer
const canvas = document.querySelector('.webgl2')
const renderer = new THREE.WebGLRenderer({canvas})
renderer.setSize(sizes.width, sizes.height)
renderer.render(scene, camera)
renderer.setPixelRatio(0.75)

//Controls
const controls = new OrbitControls(camera, canvas)
controls.enableDamping = true
controls.enablePan = true
controls.enableZoom = true

//Resize
window.addEventListener("resize", () => {

    //Update Sizes
    sizes.width = window.innerWidth
    sizes.height = window.innerHeight

    //Update Camera
    camera.aspect = sizes.width / sizes.height
    camera.updateProjectionMatrix()
    renderer.setSize(sizes.width, sizes.height)
    // labelRenderer.setSize(sizes.width, sizes.height)
  })

  
  // reserve a seat button
const explore = document.querySelector(".explore");
const explore2 = document.querySelector(".explore2");
const titlediv = document.querySelector(".container");
const dateTimeDiv = document.querySelector(".container2");
const dateTimeSelected = document.getElementById('dateTimeSelected');

const reserveDiv = document.getElementById('reserveDiv');
const reserveDivClose = document.getElementById('reserveDivClose');
const reserveBtn= document.getElementById('reserveBtn');


let selectedSeat = null;

const tooltip = document.querySelector(".tooltip")
const tooltipHeading = tooltip.querySelector('h2');
const tooltipParagraph = tooltip.querySelector('p');
tooltip.style.display = 'none'

const sectionNav = document.querySelector(".section-nav")
const section1 = sectionNav.querySelector(".section1")
const section2 = sectionNav.querySelector(".section2")
const section3 = sectionNav.querySelector(".section3")
const section4 = sectionNav.querySelector(".section4")
const filterBtn = sectionNav.querySelector(".filterBtn")

// Define an array to hold selected seats
const selectedSeats = [];
// This is just a sample to show how to set the opacity
selectedSeats.forEach((selectedSeatID) => {
  const selectedObject = gltfmodel.getObjectByName(selectedSeatID);
  if (selectedObject) {
    // Set the opacity (adjust this to your needs)
    selectedObject.material.opacity = 0.1;
  }
});



filterBtn.addEventListener("click", ()=>{
  showDateTime();hideSectionNav();

});


var availableSeats = [];
explore2.addEventListener('click', () => {
  seatsViewed = true;
  // Hide the date and time form
  dateTimeDiv.style.display = "none";
  dateTimeDiv.style.pointerEvents = "none";

  moveTarget(-0.07, -0.18, 0.22)
  moveCamera(-1.06, 0.58,-0.65)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;

    // Add this to log the available seats
    console.log('Reserved are :', availableSeats);



  // Read date, start_time, and end_time from your form inputs
   date = document.getElementById('date').value;
   startTime = document.getElementById('start_time').value;
   endTime = document.getElementById('end_time').value;

  fetchAvailableSeats(date, start_time, end_time)
  .then((availableSeats) => {
    // Log the available seats to the console for debugging
    console.log("Reserved seats:", availableSeats);
    showsection();

    // Get all the object names of the seats in your 3D scene
    const seatObjectNames = Object.keys(seatMaterials);

    // Iterate through the seat objects and adjust transparency
    // seatObjectNames.forEach((objectName) => {
    //   if (availableSeats.includes(objectName)) {
    //     // Object name matches an available seat, make it transparent
    //     const seatObject = gltfmodel.getObjectByName(objectName, true); // Use recursive search
    //     if (seatObject) {
    //       seatObject.material.transparent = true; // Enable transparency
    //       seatObject.material.opacity = 0; // Adjust opacity (0.0 to 1.0, where 0 is fully transparent)
    //     } else {
    //       console.log("Seat object not found for name:", objectName);
    //     }
    //   }
    // });
    seatObjectNames.forEach((objectName) => {
      const seatObject = gltfmodel.getObjectByName(objectName, true); // Use recursive search
      if (seatObject) {
        if (availableSeats.includes(objectName)) {
          // Seat is available, make it transparent
          seatObject.material.transparent = true;
          seatObject.material.opacity = 0.1; // Adjust as needed
          
        } else {
          // Seat is available, opacity is now fully opaque
          seatObject.material.transparent = false;
          seatObject.material.opacity = 1.0; // Set it back to fully opaque
        }
      } else {
        console.log("Seat object not found for name:", objectName);
      }
    });
    
  })
  .catch((error) => {
    console.error("Error fetching seat numbers:", error);
  });
});





function fetchAvailableSeats(date, start_time, end_time) {
  const formData = new FormData();
  formData.append('date', date);
  formData.append('start_time', start_time.value);
  formData.append('end_time', end_time.value);

  console.log(date);
  console.log(start_time.value);
  console.log(end_time.value);

  return fetch('viewSeats.php', {
    method: 'POST',
    body: formData, // Include the form data in the request body
  })
    .then((response) => response.text())
    .then((data) => {
      // Parse the data from your PHP response
      // You can implement this part based on your PHP response format
      // For example, if your PHP script returns a comma-separated list of seat names, you can split it into an array.
      return data.split(',').map((seatName) => seatName.trim());
    })
    .catch((error) => {
      console.error('Error fetching available seats data:', error);
      return [];
    });
}









explore.addEventListener("click", ()=> {
  titlediv.style.pointerEvents = "none";
  titlediv.classList.add("hidden");
  showDateTime();
});

//close the div
reserveDivClose.addEventListener("click", () => {
  hideReserveDiv();
  hideSectionNav();
  showsection();
}); 





section1.addEventListener("click", () => {
  console.log('Clicked on the 1st Section');
  moveTarget(-2.37, 0.12, -0.899)
  moveCamera(-2.05, 0.14, -0.249)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
})

section2.addEventListener("click", () => {
  console.log('Clicked on the 2nd Section');
  moveTarget(0.12, 0.03, 0.168)
  moveCamera(0.60, 0.157, -0.979)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
})

section3.addEventListener("click", () => {
  console.log('Clicked on the 3rd Section');
  moveTarget(2.11, 0.036, 0.02)
  moveCamera(2.445, 0.13, 0.494)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
})

section4.addEventListener("click", () => {
  console.log('Clicked on the 4th Section');
  moveTarget(2.51, 0.10, -1.148)
  moveCamera(2.467, 0.448, -0.332)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
})


function moveCamera(x,y,z) {
  gsap.to(camera.position, {
    x,
    y,
    z,
    duration: 2,
    ease: 'power3.inOut'
  })
}

function moveTarget(x,y,z) {
  gsap.to(controls.target, {
    x,
    y,
    z,
    duration: 2,
    ease: 'power3.inOut'
  })
}

function rotateCamera(x,y,z) {
  gsap.to(camera.rotation, {
    x,
    y,
    z,
    duration: 2
  })
}



function showtitle () {
  titlediv.style.display = "block"
  const tl2 = gsap.timeline({defaults: {duration: 1} })
  tl2.fromTo(titlediv, {x: "-100%"}, {x:"0%"})
}

function showsection() {
  sectionNav.style.display = "block";
  sectionNav.style.opacity = "1";
  sectionNav.style.pointerEvents = "auto";
  const tl3 = gsap.timeline({ defaults: { duration: 1 } });
  tl3.fromTo(sectionNav, { x: "-100%" }, { x: "0%" });

  // Use the selected date and time stored in the higher scope
  const chosenDate = document.getElementById('chosen_date');
  const chosenTime = document.getElementById('chosen_time');

  const formattedDate = formatDate(date);

  chosenDate.textContent = `${formattedDate}`;
  chosenTime.textContent = `, from ${startTime} to ${endTime}`;
}

function formatDate(dateStr) {
  // Create a Date object from the input date string
  const dateObj = new Date(dateStr);

  // Define options for formatting
  const options = { year: 'numeric', month: 'long', day: 'numeric' };

  // Format the date as "Month Day, Year"
  const formattedDate = dateObj.toLocaleDateString('en-US', options);

  return formattedDate;
}

function formatTimeToAMPM(timeStr) {
  // Parse the time string (assuming it's in "HH:mm" format)
  const [hours, minutes] = timeStr.split(':');
  const hour = parseInt(hours, 10);
  const minute = parseInt(minutes, 10);

  // Determine AM or PM
  const period = hour >= 12 ? 'PM' : 'AM';

  // Convert to 12-hour format
  const formattedHour = hour % 12 || 12;

  // Format the time as "hh:mm AM/PM"
  const formattedTime = `${formattedHour}:${minutes} ${period}`;

  return formattedTime;
}


function showtip () {
  tooltip.style.display = "block" 
  const tl4 = gsap.timeline({defaults: {delay: 0} })
  tl4.fromTo(tooltip, {opacity:0}, {opacity:1})
}
function showDateTime() {
  console.log("shows date and time form");
  dateTimeDiv.style.display = "block";
  dateTimeDiv.style.pointerEvents = "auto";
  const tl4 = gsap.timeline({defaults: {duration: 1} })
  tl4.fromTo(dateTimeDiv, {x: "-100%"}, {x:"0%"})
  seatsViewed = false;

  
}





function showSeatInfo(selectedSeatNumber, date, startTime, endTime) {
  selectedSeat = selectedSeatNumber;
  console.log("shows seat info");
  reserveDiv.style.display = "block";
  reserveDiv.style.opacity = "1";
  reserveDiv.style.pointerEvents = 'auto';
  hideSectionNav();
  const tl5 = gsap.timeline({defaults: {duration: 1}})
  tl5.fromTo(reserveDiv, {x: "100%"}, {x: "0%"})

  // Fetch the seat name from the server using an AJAX request or similar method.
  fetchSeatName(selectedSeatNumber)
    .then(seatName => {
      const seatInfoDiv = document.getElementById("reserveDiv");
      const seatNumberHeading = seatInfoDiv.querySelector("h1");
      const dateParagraph = seatInfoDiv.querySelector("p:nth-of-type(1)");
      const timeParagraph = seatInfoDiv.querySelector("p:nth-of-type(2)");

      //format date
      const formattedDate = formatDate(date);

      // Display the seat_name instead of selectedSeatNumber
      seatNumberHeading.textContent = `SEAT ${seatName}`;
      dateParagraph.textContent = `on ${formattedDate}`;
      timeParagraph.textContent = `${startTime} to ${endTime}`;

      seatInfoDiv.style.display = "block";


    
    });
}

// get the seat number on database
function fetchSeatName(seatNumber) {
  const url = `fetchSeatInfo.php?seat_number=${seatNumber}`;
  return fetch(url)
    .then(response => response.json())
    .then(data => data.seat_name)
    .catch(error => {
      console.error('Error fetching seat name:', error);
      return seatNumber; 
    });
}

// // get the seat id on database
// function fetchSeatId(seatNumber) {
//   const url = `fetchSeatId.php?seat_number=${seatNumber}`;
//   return fetch(url)
//     .then(response => response.json())
//     .then(data => data.seat_name)
//     .catch(error => {
//       console.error('Error fetching seat name:', error);
//       return seatNumber; 
//     });
// }
// reserveBtn.addEventListener("click", ()=>{

//   //get reservation info. get the seat_id based on the seat_number, get the date, start_time, end_time 
//   moveTarget(0.12, 0.03, 0.17);
//   moveCamera(-1.06, 0.30, -0.01);
//   hideSectionNav();
//   hideReserveDiv();
//   hideTooltip(); 
//   Swal.fire({
//     icon: 'success',
//     title: 'Reservation Success',
//     text: 'Your reservation has been successfully made.',
//   });
// });



// Add a click event listener to the button
reserveBtn.addEventListener("click", () => {
  if (selectedSeat) {
    const seatNumber = selectedSeat;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", 'fetchSeatId.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const seatId = xhr.responseText;
        
        reserveSeat(seatId);
        console.log("you reserved", seatId);
      }
    };
    xhr.send("seat_number=" + seatNumber);
  } else {
    console.log("No seat selected.");
  }
});


// Function to convert time to 24-hour format
function convertTo24HourFormat(time) {
  const date = new Date("2000-01-01 " + time);
  return date.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
}


//function when clicking the seat button
function reserveSeat(seat_id) {

  // Display SweetAlert to confirm seat reservation
  Swal.fire({
    title: 'Confirm Reservation',
    html: 'Seat No.: ' + seat_id + '<br>Date: ' + $('#date').val() +
      '<br>Time: ' + $('#start_time').val() +
      ' - ' + $('#end_time').val(),
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: '#a81c1c',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      // Insert reservation into the database
      var reservationData = {
        seat_id: seat_id,
        date: $('#date').val(),
        start_time: convertTo24HourFormat($('#start_time').val()),
        end_time: convertTo24HourFormat($('#end_time').val()),
      };
    
      console.log(reservationData);
    
      $.ajax({
        url: 'toReserve.php',
        method: 'GET',
        data: reservationData,
        success: function (response) {
          if (response === 'success') {
            console.log('Reservation inserted into the database');
            // Show success alert
            Swal.fire({
              title: 'Reserved Successful',
              text: 'Seat ' + seat_id + ' has been reserved.',
              icon: 'success',
              confirmButtonText: 'Okay',
              confirmButtonColor: '#a81c1c',
            }).then(() => {
              
              window.location.href = 'profile.php';
            });
          } else if (response === 'error') {
            console.log('The selected seat is already reserved for the selected date and time range');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'The selected seat is already reserved for the selected date and time range. Please choose another seat or time.',
              icon: 'error',
              confirmButtonColor: '#a81c1c',
            })
          } else {
            console.log('An error occurred during the reservation process');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'An error occurred during the reservation process.',
              icon: 'error',
              confirmButtonColor: '#a81c1c',
            })
          }
        },
      });
    }
    
  });
}



function hideSectionNav() {
  sectionNav.style.transition = "opacity 0.5s";
  sectionNav.style.opacity = "0";
  sectionNav.style.transform = 'translateX(-20px)';
  sectionNav.style.pointerEvents = 'none';

}


function hideReserveDiv() {
  reserveDiv.style.display = "none";
  reserveDiv.style.transition = "opacity 0.5s";
  reserveDiv.style.opacity = "0";
  reserveDiv.style.transform = 'translateX(20px)';
  reserveDiv.style.pointerEvents = 'none';
}

  //Animate
  const loop = () => {
    controls.update()
    renderer.render(scene, camera)
    window.requestAnimationFrame(loop)
  }
  loop()


  function performRaycasting(event) {
    const mouse = new THREE.Vector2();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
  
    const raycaster = new THREE.Raycaster();
    raycaster.setFromCamera(mouse, camera);
  
    const intersects = raycaster.intersectObject(gltfmodel, true);
  
    if (intersects.length > 0) {
      const selectedObject = intersects[0].object;
      
      if(selectedObject.name) {
        const objectName = selectedObject.name;
  
      if (objectName === 'Cube019') {
        console.log('Clicked on the CB_EightSeater object');
        moveTarget(-2.37, 0.12, -0.899)
        moveCamera(-2.05, 0.14, -0.249)
        controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
      }
      if (objectName === 'Cube012'){
        console.log('Clicked on the BE_EightSeater object');
        moveTarget(2.11, 0.036, 0.02)
        moveCamera(2.445, 0.13, 0.494)
        controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
      }
      if (objectName === 'Cylinder025_2') {
        console.log('Clicked on the 2_FiveSeater object');
        moveTarget(0.12, 0.03, 0.168)
        moveCamera(0.60, 0.157, -0.979)
        controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
      }
    }
  }
  }
  
  window.addEventListener('click', performRaycasting);


  function showTooltip(event, paragraphText, headingText) {
    tooltipHeading.textContent = headingText;
    tooltipParagraph.textContent = paragraphText;
    tooltip.style.opacity = '1'
    tooltip.style.transform = 'translateY(0px)'
    tooltip.style.display = "block" 

  }

  function hideTooltip() {
    tooltip.style.opacity = '0'
    tooltip.style.transform = 'translateY(-10px)'
    tooltip.style.pointerEvents = 'none'
  }

 
  
  

  // when user hover the seats
  window.addEventListener('mousemove', (event) => {
    if (!seatsViewed) {
      console.log("select date and time first before hovering");
      return;
    }
    else {

    const mouse = new THREE.Vector2();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    const raycaster = new THREE.Raycaster();
    raycaster.setFromCamera(mouse, camera);
  
    const intersects = raycaster.intersectObject(gltfmodel, true);

    if (intersects.length > 0) {
      const selectedObject = intersects[0].object;
      const objectName = selectedObject.name;
      
      switch(objectName) {

      case '1_CompChair_1':
        console.log('hovered on the 1_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B1');
        
        break;
      
      case '1_CompChair_2':
        console.log('hovered on the 1_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B2');
        break;
      
      case '1_CompChair_3':
        console.log('hovered on the 1_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B3');
        break;

      case '1_CompChair_4':
        console.log('hovered on the 1_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B4');
        break;

        case '1_CompChair_5':
        console.log('hovered on the 1_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B5'); 
        break;

        case '2_CompChair_1':
        console.log('hovered on the 2_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B6');
        break;

        case '2_CompChair_2':
        console.log('hovered on the 2_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B7');
        break;

        case '2_CompChair_3':
        console.log('hovered on the 2_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B8');
        break;

        case '2_CompChair_4':
        console.log('hovered on the 2_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B9');
        break;

        case '2_CompChair_5':
        console.log('hovered on the 2_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B10');
        break;

        case '3_CompChair_1':
        console.log('hovered on the 3_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B11');
        break;

        case '3_CompChair_2':
        console.log('hovered on the 3_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B12');
        break;

        case '3_CompChair_3':
        console.log('hovered on the 3_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B13');
        break;

        case '3_CompChair_4':
        console.log('hovered on the 3_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B14');
        break;

        case '3_CompChair_5':
        console.log('hovered on the 3_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT B150');
        break;

      default:
        hideTooltip()
        break;
      }
    }
  }
  
  });


  // when user clicks the seat
  window.addEventListener('mousedown', (event) => {
    if (!seatsViewed) {
      console.log("select date and time first before clicking this seat haha");
      return;
    }
    else {
     
      const mouse = new THREE.Vector2();
      mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
      mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

      const raycaster = new THREE.Raycaster();
      raycaster.setFromCamera(mouse, camera);
    
      const intersects = raycaster.intersectObject(gltfmodel, true);

      if (intersects.length > 0) {
        const selectedObject = intersects[0].object;
        const objectName = selectedObject.name;
        // Assuming you have retrieved date, startTime, and endTime from your form inputs
      date = document.getElementById('date').value;
      startTime = document.getElementById('start_time').value;
      endTime = document.getElementById('end_time').value;


        switch(objectName) {

        case '1_CompChair_1':
          console.log('Clicked on the 1_CompChair_1 object');
          showSeatInfo(objectName, date, startTime, endTime);
          hideTooltip()
          break;
        
        case '1_CompChair_2':
          console.log('Clicked on the 1_CompChair_2 object');
          showSeatInfo(objectName, date, startTime, endTime);
          hideTooltip()
          break;
        
        case '1_CompChair_3':
          console.log('Clicked on the 1_CompChair_3 object');
          showSeatInfo(objectName, date, startTime, endTime);
          hideTooltip()
          break;

        case '1_CompChair_4':
          console.log('Clicked on the 1_CompChair_4 object');
          showSeatInfo(objectName, date, startTime, endTime);
          hideTooltip()
          break;

          case '1_CompChair_5':
          console.log('Clicked on the 1_CompChair_5 object');
          hideTooltip()
          moveTarget(-0.44, -0.44, 0.40);
          moveCamera(-1.32, 0.33,-0.024);
          controls.minPolarAngle = Math.PI / 10;
          controls.maxPolarAngle = (2 * Math.PI) / 3.8;
          showSeatInfo(objectName, date, startTime, endTime);
          
          break;

          case '2_CompChair_1':
          console.log('Clicked on the 2_CompChair_1 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '2_CompChair_2':
          console.log('Clicked on the 2_CompChair_2 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '2_CompChair_3':
          console.log('Clicked on the 2_CompChair_3 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '2_CompChair_4':
          console.log('Clicked on the 2_CompChair_4 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '2_CompChair_5':
          console.log('Clicked on the 2_CompChair_5 object');
          console.log(gltfmodel.getObjectByName('2_CompChair_5'));
          showSeatInfo(objectName, date, startTime, endTime);
          gltfmodel.getObjectByName('2_CompChair_5').material.emissiveIntensity = 1.0;
          break;

          case '3_CompChair_1':
          console.log('Clicked on the 3_CompChair_1 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '3_CompChair_2':
          console.log('Clicked on the 3_CompChair_2 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '3_CompChair_3':
          console.log('Clicked on the 3_CompChair_3 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '3_CompChair_4':
          console.log('Clicked on the 3_CompChair_4 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

          case '3_CompChair_5':
          console.log('Clicked on the 3_CompChair_5 object');
          showSeatInfo(objectName, date, startTime, endTime);
          break;

        default:
          hideTooltip()
          break;
        }
      }
    }
  });




  