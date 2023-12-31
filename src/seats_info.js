import * as THREE from 'three'
import "./styles/seats-info.css";
import interior from "./models/interior final.glb"
import gsap from "gsap"
import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader'
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader'

let date;
let startTime;
let endTime;
let helperViewed = true;
let seatsViewed = true;

let reservedSeatsList = [];
let maintenanceSeatsList = [];



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
const renderer = new THREE.WebGLRenderer({canvas, antialias: true})
const backgroundColor = new THREE.Color(0x000000);
renderer.setClearColor(backgroundColor);
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
const topviewBtn = document.querySelector(".topviewBtn");
const titlediv = document.querySelector(".container");
const dateTimeDiv = document.querySelector(".container2");
const dateTimeSelected = document.getElementById('dateTimeSelected');
const helper = document.getElementById('helper');

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

const topview1 = document.querySelector(".topview1")
const topview2 = document.querySelector(".topview2")
const topview3 = document.querySelector(".topview3")
const topview4 = document.querySelector(".topview4")

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




explore2.addEventListener('click', () => {
  seatsViewed = true;
  canvas.style.display = "block";
  topview.style.display = "flex";

  if (helperViewed == false ) {
    hideTooltip();
    showHelper();

  }
  // Hide the date and time form
  dateTimeDiv.style.display = "none";
  dateTimeDiv.style.pointerEvents = "none";

  moveTarget(-0.07, -0.18, 0.22)
  moveCamera(-1.06, 0.58, -0.65)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;

  // Read date, start_time, and end_time from your form inputs
  date = document.getElementById('date').value;
  startTime = document.getElementById('start_time').value;
  endTime = document.getElementById('end_time').value;

  
  fetchReservedSeats(date, start_time, end_time)
    .then((reservedSeats) => {

      reservedSeatsList = reservedSeats;
      // Log the reserved seats to the console for debugging
      console.log("Reserved seats:", reservedSeats);
      console.log("reservedSeatsList value is ", reservedSeatsList);

      // Fetch maintenance seats after fetching reserved seats
      fetchMaintenanceSeats()
        .then((maintenanceSeats) => {
          maintenanceSeatsList = maintenanceSeats;
          // Log the maintenance seats to the console for debugging
          console.log("Maintenance seats:", maintenanceSeats);
          console.log("maintenanceSeatsList", maintenanceSeatsList);

          showsection();
          

          // Get all the object names of the seats in your 3D scene
          const seatObjectNames = Object.keys(seatMaterials);
          seatObjectNames.forEach((objectName) => {

            const seatObject = gltfmodel.getObjectByName(objectName, true); // Use recursive search
            seatObject.material.transparent = false;
            seatObject.material.opacity = 1;

            if (seatObject) {
              if (reservedSeats.includes(objectName)) {
                seatObject.material.transparent = true;
                seatObject.material.opacity = 0.1;
                console.log(objectName, 'is set to 0.1 opacity because it is reserved by someone');
                seatObject.addEventListener('click', function (event) {
                  event.stopPropagation();
                  event.preventDefault();
                });
              }
              if (maintenanceSeats.includes(objectName)) {
                seatObject.material.transparent = true;
                seatObject.material.opacity = 0.1;
                console.log(objectName, 'is invisible beacuse is it maintenance seat');
                // seatObject.addEventListener('click', function (event) {
                //   event.stopPropagation();
                //   event.preventDefault();
                // });
              }
            
            } else {
              seatObject.material.transparent = false;
              seatObject.material.opacity = 1;
              console.log("Seat object not found for name:", objectName);
            }
          });
        })
        .catch((error) => {
          console.error("Error fetching maintenance seats:", error);
        });
    })
    .catch((error) => {
      console.error("Error fetching reserved seats:", error);
    });
});


const topview = document.getElementById('topview')
const navHome = document.getElementById('nav_home')
const navAcc = document.getElementById('nav_account')

topviewBtn.addEventListener('click', () => {
  hideTooltip();
  seatsViewed = true;
  canvas.style.display = "none";
  topview.style.display = "flex";


  // navHome.classList.add("text-dark");
  // navAcc.classList.add("text-dark");
  


  if (helperViewed == false) {
    hideTooltip();
    // showHelper();
  }
     hideTooltip();
  // Hide the date and time form
  dateTimeDiv.style.display = "none";
  dateTimeDiv.style.pointerEvents = "none";

  // moveTarget(-0.07, -0.18, 0.22)
  // moveCamera(-1.46, 0.44, -0.17)
  // controls.minPolarAngle = Math.PI / 10;
  // controls.maxPolarAngle = (2 * Math.PI) / 3.8;

  // Read date, start_time, and end_time from your form inputs
  date = document.getElementById('date').value;
  startTime = document.getElementById('start_time').value;
  endTime = document.getElementById('end_time').value;

  fetchReservedSeats(date, start_time, end_time)
    .then((reservedSeats) => {
      reservedSeatsList = reservedSeats;
      // console.log("Reserved seats:", reservedSeats);
      // console.log("reservedSeatsList value is ", reservedSeatsList);

      // Fetch maintenance seats after fetching reserved seats
      fetchMaintenanceSeats()
        .then((maintenanceSeats) => {
          maintenanceSeatsList = maintenanceSeats;
          console.log("Maintenance seats:", maintenanceSeats);
          console.log("maintenanceSeatsList", maintenanceSeatsList);

          showsection();

          
            const buttonElements = document.querySelectorAll('.btn2d');
            const buttonIDs = Array.from(buttonElements).map(button => button.id);
          
            console.log('Button Elements:', buttonElements);
            console.log('Button IDs:', buttonIDs);
            console.log('Reserved Seats:', reservedSeats);
            console.log('Maintenance Seats:', maintenanceSeats);
          
            buttonIDs.forEach((buttonID) => {
              const button = document.getElementById(buttonID);
              button.classList.remove("disabled");
          
              if (button) {
                if (reservedSeats.includes(buttonID)) {
                  console.log(buttonID, 'is in reservedSeats');
                  button.style.opacity = 0.5;
              
                }
                if (maintenanceSeats.includes(buttonID)) {
                  console.log(buttonID, 'is in maintenanceSeats');
                  button.style.opacity = 0.1;
                 
                  
                }
              } else {
                console.log("Button not found for ID:", buttonID);
              }
              
            });
          
          
          

        })
        .catch((error) => {
          console.error("Error fetching maintenance seats:", error);
        });
    })
    .catch((error) => {
      console.error("Error fetching reserved seats:", error);
    });
});

section1.addEventListener("click", () => {
  // console.log('Clicked on the 1st Section');
  moveTarget(-2.37, 0.12, -0.899)
  moveCamera(-2.05, 0.14, -0.249)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
  topview1.style.display = 'block';
  topview2.style.display = 'none';
  topview3.style.display = 'none';
  topview4.style.display = 'none';
})

section2.addEventListener("click", () => {
  // console.log('Clicked on the 2nd Section');
  moveTarget(0.12, 0.03, 0.168)
  moveCamera(0.60, 0.157, -0.979)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
  topview1.style.display = 'none';
  topview2.style.display = 'block';
  topview3.style.display = 'none';
  topview4.style.display = 'none';
})

section3.addEventListener("click", () => {
  // console.log('Clicked on the 3rd Section');
  moveTarget(2.11, 0.036, 0.02)
  moveCamera(2.445, 0.13, 0.494)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
  topview1.style.display = 'none';
  topview2.style.display = 'none';
  topview3.style.display = 'block';
  topview4.style.display = 'none';
})

section4.addEventListener("click", () => {
  // console.log('Clicked on the 4th Section');
  moveTarget(2.51, 0.10, -1.148)
  moveCamera(2.467, 0.448, -0.332)
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
  topview1.style.display = 'none';
  topview2.style.display = 'none';
  topview3.style.display = 'none';
  topview4.style.display = 'block';
})





function fetchReservedSeats(date, start_time, end_time) {
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

function fetchMaintenanceSeats() {
  // Replace 'your-maintenance-seats-api-url' with the actual URL to fetch maintenance seats from
  const maintenanceSeatsUrl = 'fetchSeatStatus.php';

  return fetch(maintenanceSeatsUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Failed to fetch maintenance seats. Status: ${response.status}`);
      }

      return response.json();
    })
    .then((maintenanceSeatsData) => {
      // Assuming the API response contains the list of maintenance seat names
      return maintenanceSeatsData.maintenanceSeats; // Adjust this based on your API response structure
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

  chosenDate.textContent = ``;
  chosenTime.textContent = ``;
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

function showHelper() {
  helperViewed = true;
  hideTooltip();
  helper.style.opacity = "1";
  helper.style.display = "flex";
  helper.style.pointerEvents = "auto";



}

function hideHelper() {
  helper.style.opacity = "0" 
  helper.style.pointerEvents = "none";
}

function showtip () {
  tooltip.style.display = "block" 
  const tl4 = gsap.timeline({defaults: {delay: 0} })
  tl4.fromTo(tooltip, {opacity:0}, {opacity:1})
}
function showDateTime() {
  console.log("shows date and time form");
  dateTimeDiv.style.display = "flex";
  dateTimeDiv.style.pointerEvents = "auto";
  // const tl4 = gsap.timeline({defaults: {duration: 1} })
  // tl4.fromTo(dateTimeDiv, {y: "100%"}, {y:"0%"})
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
      dateParagraph.textContent = ``;
      timeParagraph.textContent = ``;

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

const fixBtn = document.getElementById('fixBtn');

// Add a click event listener to the button
fixBtn.addEventListener("click", () => {
  if (selectedSeat) {
    const seatNumber = selectedSeat;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", 'fetchSeatId.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const seatId = xhr.responseText;
        
        fixSeat(seatId);
        console.log("you want fix", seatId);
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
    title: 'Mark seat as under maintenance?',
    html: 'Seat No.: ' + seat_id  +
      '<br>',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: '#a81c1c',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      // Insert reservation into the database
      // var reservationData = {
      //   seat_id: seat_id
      //   // date: $('#date').val(),
      //   // start_time: convertTo24HourFormat($('#start_time').val()),
      //   // end_time: convertTo24HourFormat($('#end_time').val()),
      // };
    
      console.log(seat_id);
    
      $.ajax({
        url: './php/toDestroy.php',
        method: 'GET',
        data: { seat_id: seat_id },
        success: function (response) {
          console.log(response);
          if (response === 'success') {
            console.log('success mark as under maintenance the database');
            // Show success alert
            Swal.fire({
              title: 'Successful',
              text: 'Seat ' + seat_id + ' has set as under maintenance.',
              icon: 'success',
              confirmButtonText: 'Okay',
              confirmButtonColor: '#a81c1c',
            }).then(() => {



               // Fetch maintenance seats after fetching reserved seats
      fetchMaintenanceSeats()
      .then((maintenanceSeats) => {
        maintenanceSeatsList = maintenanceSeats;
        // Log the maintenance seats to the console for debugging
        console.log("Maintenance seats:", maintenanceSeats);
        console.log("maintenanceSeatsList", maintenanceSeatsList);

        // showsection();
        

        // Get all the object names of the seats in your 3D scene
        const seatObjectNames = Object.keys(seatMaterials);
        seatObjectNames.forEach((objectName) => {

          const seatObject = gltfmodel.getObjectByName(objectName, true); // Use recursive search
          seatObject.material.transparent = false;
          seatObject.material.opacity = 1;

          if (seatObject) {
          
            if (maintenanceSeats.includes(objectName)) {
              seatObject.material.transparent = true;
              seatObject.material.opacity = 0.1;
              console.log(objectName, 'is invisible beacuse is it maintenance seat');
              // seatObject.addEventListener('click', function (event) {
              //   event.stopPropagation();
              //   event.preventDefault();
              // });
            }
          
          } else {
            seatObject.material.transparent = false;
            seatObject.material.opacity = 1;
            console.log("Seat object not found for name:", objectName);
          }
        });
      })
      .catch((error) => {
        console.error("Error fetching maintenance seats:", error);
      });
              
              
          
              
            });
          } else if (response === 'error') {
            console.log('The selected seat is already reserved for the selected date and time range');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'The selected seat is currently reserved or occupied. Please wait until it is available',
              icon: 'error',
              confirmButtonColor: '#a81c1c',
            })
          } else {
            console.log('An error occurred during the process');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'An error occurred during the  process.',
              icon: 'error',
              confirmButtonColor: '#a81c1c',
            })
          }
        },
      });
    }
    
  });
}

//function when clicking the seat button
function fixSeat(seat_id) {

  // Display SweetAlert to confirm seat reservation
  Swal.fire({
    title: 'Mark seat as fix?',
    html: 'Seat No.: ' + seat_id  +
      '<br>',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: '#a81c1c',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      // Insert reservation into the database
      // var reservationData = {
      //   seat_id: seat_id
      //   // date: $('#date').val(),
      //   // start_time: convertTo24HourFormat($('#start_time').val()),
      //   // end_time: convertTo24HourFormat($('#end_time').val()),
      // };
    
      console.log(seat_id);
    
      $.ajax({
        url: './php/toFix.php',
        method: 'GET',
        data: { seat_id: seat_id },
        success: function (response) {
          console.log(response);
          if (response === 'success') {
            console.log('success mark as under maintenance the database');
            // Show success alert
            Swal.fire({
              title: 'Successful',
              text: 'Seat ' + seat_id + ' has been fixed and open for reservation',
              icon: 'success',
              confirmButtonText: 'Okay',
              confirmButtonColor: '#a81c1c',
            }).then(() => {



               // Fetch maintenance seats after fetching reserved seats
      fetchMaintenanceSeats()
      .then((maintenanceSeats) => {
        maintenanceSeatsList = maintenanceSeats;
        // Log the maintenance seats to the console for debugging
        console.log("Maintenance seats:", maintenanceSeats);
        console.log("maintenanceSeatsList", maintenanceSeatsList);

        // showsection();
        

        // Get all the object names of the seats in your 3D scene
        const seatObjectNames = Object.keys(seatMaterials);
        seatObjectNames.forEach((objectName) => {

          const seatObject = gltfmodel.getObjectByName(objectName, true); // Use recursive search
          seatObject.material.transparent = false;
          seatObject.material.opacity = 1;

          if (seatObject) {
          
            if (maintenanceSeats.includes(objectName)) {
              seatObject.material.transparent = true;
              seatObject.material.opacity = 0.1;
              console.log(objectName, 'is invisible beacuse is it maintenance seat');
              // seatObject.addEventListener('click', function (event) {
              //   event.stopPropagation();
              //   event.preventDefault();
              // });
            }
          
          } else {
            seatObject.material.transparent = false;
            seatObject.material.opacity = 1;
            console.log("Seat object not found for name:", objectName);
          }
        });

            const buttonElements = document.querySelectorAll('.btn2d');
            const buttonIDs = Array.from(buttonElements).map(button => button.id);
          
            console.log('Button Elements:', buttonElements);
            console.log('Button IDs:', buttonIDs);
            console.log('Reserved Seats:', reservedSeats);
            console.log('Maintenance Seats:', maintenanceSeats);
          
            buttonIDs.forEach((buttonID) => {
              const button = document.getElementById(buttonID);
              button.classList.remove("disabled");
          
              if (button) {
                if (reservedSeats.includes(buttonID)) {
                  console.log(buttonID, 'is in reservedSeats');
                  button.style.opacity = 0.5;
              
                }
                if (maintenanceSeats.includes(buttonID)) {
                  console.log(buttonID, 'is in maintenanceSeats');
                  button.style.opacity = 0.1;
                 
                  
                }
              } else {
                console.log("Button not found for ID:", buttonID);
              }
              
            });
      })
      .catch((error) => {
        console.error("Error fetching maintenance seats:", error);
      });
              
              
          
              
            });
          } else if (response === 'error') {
            console.log('The selected seat is already reserved for the selected date and time range');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'The selected seat is currently reserved or occupied. Please wait until it is available',
              icon: 'error',
              confirmButtonColor: '#a81c1c',
            })
          } else {
            console.log('An error occurred during the process');
            // Show error alert
            Swal.fire({
              title: 'Error',
              text: 'An error occurred during the  process.',
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
    if (!seatsViewed && !helperViewed) {
      console.log("select date and time first before hovering");
      return;
    }
    else if (!helperViewed) {
      console.log("please dismiss the helper before hovering");
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

       // Check if the seat is reserved or for maintenance
       let seatStatus = "Available";
       if (reservedSeatsList.includes(objectName)) {
         seatStatus = "Reserved";
       }
       if (maintenanceSeatsList.includes(objectName)) {
         seatStatus = "Maintenance";
       }
      
      switch(objectName) {

      case '1_CompChair_1':
        console.log('hovered on the 1_CompChair_1 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B1');
        
        break;
      
      case '1_CompChair_2':
        console.log('hovered on the 1_CompChair_2 object');
        showTooltip(event, `${seatStatus}` + ' seat',  'SEAT B2');
        break;
      
      case '1_CompChair_3':
        console.log('hovered on the 1_CompChair_3 object');
        showTooltip(event,`${seatStatus}` + ' seat',  'SEAT B3');
        break;

      case '1_CompChair_4':
        console.log('hovered on the 1_CompChair_4 object');
        showTooltip(event, `${seatStatus}` + ' seat',  'SEAT B4');
        break;

        case '1_CompChair_5':
        console.log('hovered on the 1_CompChair_5 object');
        showTooltip(event,`${seatStatus}` + ' seat',  'SEAT B5'); 
        break;

        case '2_CompChair_1':
        console.log('hovered on the 2_CompChair_1 object');
        showTooltip(event,`${seatStatus}` + ' seat', 'SEAT B6');
        break;

        case '2_CompChair_2':
        console.log('hovered on the 2_CompChair_2 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B7');
        break;

        case '2_CompChair_3':
        console.log('hovered on the 2_CompChair_3 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B8');
        break;

        case '2_CompChair_4':
        console.log('hovered on the 2_CompChair_4 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B9');
        break;

        case '2_CompChair_5':
        console.log('hovered on the 2_CompChair_5 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B10');
        break;

        case '3_CompChair_1':
        console.log('hovered on the 3_CompChair_1 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B11');
        break;

        case '3_CompChair_2':
        console.log('hovered on the 3_CompChair_2 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B12');
        break;

        case '3_CompChair_3':
        console.log('hovered on the 3_CompChair_3 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B13');
        break;

        case '3_CompChair_4':
        console.log('hovered on the 3_CompChair_4 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B14');
        break;

        case '3_CompChair_5':
        console.log('hovered on the 3_CompChair_5 object');
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B15');
        break;

      default:
        hideTooltip()
        break;
      }
    }
  }
  
  });


  // when user clicks the seat
  window.addEventListener('click', (event) => {
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
  // Check if the clicked seat is in reservedSeats or maintenanceSeats


  if (reservedSeatsList.includes(objectName)) {
    Swal.fire({
      title: 'Seat still in use or reserved',
      text: 'Seat ' + seat_id + ' can not be mark as under maintenance because it is reserved or occupied. Please wait until it is available',
      icon: 'success',
      confirmButtonText: 'Okay',
      confirmButtonColor: '#a81c1c',
    })
    return; // Make the seat unclickable
  }
  else if  (maintenanceSeatsList.includes(objectName)) {
    // Hide reserveBtn and show fixBtn
    $('#reserveBtn').hide();
    $('#fixBtn').show();
      hideReserveDiv();
  }
  else  {
    $('#reserveBtn').show();
    $('#fixBtn').hide();
    hideReserveDiv();
  }

  switch (objectName) {
    //section B
    case '6_CompChair_2':
            
    showSeatInfo(objectName, date, startTime, endTime);
    
    break;
  
  case '6_CompChair_1':
  
    showSeatInfo(objectName, date, startTime, endTime);
    break
  
  case '6_CompChair_5':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

  case '6_CompChair_4':
  
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '6_CompChair_3':

    showSeatInfo(objectName, date, startTime, endTime); 
    break;

    case '10_CompChair_5':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '10_CompChair_1':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '10_CompChair_2':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '10_CompChair_4':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '10_CompChair_3':
    showSeatInfo(objectName, date, startTime, endTime);
    break;

    case '12_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '12_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '12_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '12_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '12_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '5_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '5_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '5_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '5_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '5_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '9_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '9_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '9_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '9_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '9_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '11_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '11_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '11_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '11_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '11_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '4_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '4_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '4_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '4_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '4_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '7_CompChair_5':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '7_CompChair_1':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '7_CompChair_2':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '7_CompChair_4':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '7_CompChair_3':
showSeatInfo(objectName, date, startTime, endTime);
break;

case '8_CompChair_2':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '8_CompChair_1':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '8_CompChair_5':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '8_CompChair_4':
  showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B44');
  break;

case '8_CompChair_3':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '3_CompChair_2':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '3_CompChair_1':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '3_CompChair_5':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '3_CompChair_4':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '3_CompChair_3':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '2_CompChair_5':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '2_CompChair_1':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '2_CompChair_2':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '2_CompChair_4':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '2_CompChair_3':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '1_CompChair_2':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '1_CompChair_1':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '1_CompChair_5':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '1_CompChair_4':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

case '1_CompChair_3':
 showSeatInfo(objectName, date, startTime, endTime);
  break;

   
              
        
        
      
  





    // section A Continue for seats A68 to A1
    case 'CA_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A67 to A1
    case 'CB_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CB_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A62 to A1
    case 'CB_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CB_CompChair_5':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CB_CompChair_4':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CB_CompChair_3':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
            case 'CB_CompChair_2':
              showSeatInfo(objectName, date, startTime, endTime);
              break;
  
    case 'CB_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A61 to A1
    case 'CC_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CC_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A54 to A1
    case 'CC_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CC_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A53 to A1
    case 'CD_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CD_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A46 to A1
    case 'CD_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CD_CompChair_5':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CD_CompChair_4':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CD_CompChair_3':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
            case 'CD_CompChair_2':
              showSeatInfo(objectName, date, startTime, endTime);
              break;
  
    case 'CD_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A45 to A1
    case 'CE_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CE_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A38 to A1
    case 'CE_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A37 to A1
    case 'CF_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CF_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A30 to A1
  
      case 'CF_CompChair_6':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CF_CompChair_5':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CF_CompChair_4':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
    case 'CF_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CF_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CF_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A29 to A1
    case 'CG_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CG_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A22 to A1
    case 'CG_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    
    case 'CG_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CG_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A21 to A1
    case 'CH_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CH_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A14 to A1
    
    case 'CH_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A13 to A1
    case 'CI_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A6 to A1
  
    case 'CI_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A5 to A1
    case 'CI_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;

      case 'CI_CompChair_6':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
  
    case 'CI_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A4 to A1
  
    default:
      hideTooltip();
      break;
  }
      }
    }
  });



    // when user clicks the seat in 2d
    document.addEventListener('DOMContentLoaded', function () {
      const seatsViewed = true; // Assuming seatsViewed is defined
  
      // Your existing code for raycasting and seat selection
  
      // Select all buttons with the class 'btn2d'
      const buttons = document.querySelectorAll('.btn2d');
  
      // Add click event listener to each button
      buttons.forEach(button => {
        button.addEventListener('click', (event) => {
          // if (!seatsViewed) {
          //   console.log("Select date and time first before clicking this seat");
          //   return;
          // }
  
          // Assuming you have retrieved date, startTime, and endTime from your form inputs
          const date = document.getElementById('date').value;
          const startTime = document.getElementById('start_time').value;
          const endTime = document.getElementById('end_time').value;
  
          // Check if the clicked seat is in reservedSeats or maintenanceSeats
          const objectName = button.id;
          // const reservedSeatsList = []; // Replace with your actual reserved seats list
          // const maintenanceSeatsList = []; // Replace with your actual maintenance seats list
  
           // Check if the clicked seat is in reservedSeats or maintenanceSeats
  if (reservedSeatsList.includes(objectName)) {
    Swal.fire({
      title: 'Seat still in use or reserved',
      text: 'Seat ' + seat_id + ' can not be mark as under maintenance because it is reserved or occupied. Please wait until it is available',
      icon: 'success',
      confirmButtonText: 'Okay',
      confirmButtonColor: '#a81c1c',
    })
    return; // Make the seat unclickable
  }
  else if  (maintenanceSeatsList.includes(objectName)) {
    // Hide reserveBtn and show fixBtn
    $('#reserveBtn').hide();
    $('#fixBtn').show();
      hideReserveDiv();
  }
  else  {
    $('#reserveBtn').show();
    $('#fixBtn').hide();
    hideReserveDiv();
  }
  
  switch (objectName) {
    //section B
    case '6_CompChair_2':
            
          showSeatInfo(objectName, date, startTime, endTime);
          
          break;
        
        case '6_CompChair_1':
        
          showSeatInfo(objectName, date, startTime, endTime);
          break
        
        case '6_CompChair_5':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
        case '6_CompChair_4':
        
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '6_CompChair_3':
      
          showSeatInfo(objectName, date, startTime, endTime); 
          break;
      
          case '10_CompChair_5':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '10_CompChair_1':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '10_CompChair_2':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '10_CompChair_4':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '10_CompChair_3':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
      
          case '12_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '12_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '12_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '12_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '12_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '5_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '5_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '5_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '5_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '5_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '9_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '9_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '9_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '9_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '9_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '11_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '11_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '11_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '11_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '11_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '4_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '4_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '4_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '4_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '4_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '7_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '7_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '7_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '7_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '7_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      
      case '8_CompChair_2':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '8_CompChair_1':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '8_CompChair_5':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '8_CompChair_4':
        showTooltip(event, `${seatStatus}` + ' seat', 'SEAT B44');
        break;
      
      case '8_CompChair_3':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '3_CompChair_2':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '3_CompChair_1':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '3_CompChair_5':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '3_CompChair_4':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '3_CompChair_3':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '2_CompChair_5':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '2_CompChair_1':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '2_CompChair_2':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '2_CompChair_4':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '2_CompChair_3':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '1_CompChair_2':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '1_CompChair_1':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '1_CompChair_5':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '1_CompChair_4':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
      
      case '1_CompChair_3':
       showSeatInfo(objectName, date, startTime, endTime);
        break;
        
      
  





    // section A Continue for seats A68 to A1
    case 'CA_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CA_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A67 to A1
    case 'CB_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CB_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A62 to A1
    case 'CB_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CB_CompChair_5':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CB_CompChair_4':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CB_CompChair_3':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
            case 'CB_CompChair_2':
              showSeatInfo(objectName, date, startTime, endTime);
              break;
  
    case 'CB_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A61 to A1
    case 'CC_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CC_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A54 to A1
    case 'CC_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CC_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CC_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A53 to A1
    case 'CD_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CD_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A46 to A1
    case 'CD_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
      case 'CD_CompChair_5':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CD_CompChair_4':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CD_CompChair_3':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
            case 'CD_CompChair_2':
              showSeatInfo(objectName, date, startTime, endTime);
              break;
  
    case 'CD_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A45 to A1
    case 'CE_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CE_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A38 to A1
    case 'CE_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CE_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A37 to A1
    case 'CF_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CF_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A30 to A1
  
      case 'CF_CompChair_6':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
        case 'CF_CompChair_5':
          showSeatInfo(objectName, date, startTime, endTime);
          break;
          case 'CF_CompChair_4':
            showSeatInfo(objectName, date, startTime, endTime);
            break;
    case 'CF_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CF_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CF_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A29 to A1
    case 'CG_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CG_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A22 to A1
    case 'CG_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    
    case 'CG_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CG_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CG_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A21 to A1
    case 'CH_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CH_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A14 to A1
    
    case 'CH_CompChair_6':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
    case 'CH_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A13 to A1
    case 'CI_CompChair_8':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_7':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A6 to A1
  
    case 'CI_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Continue for seats A5 to A1
    case 'CI_CompChair_5':
      showSeatInfo(objectName, date, startTime, endTime);
      break;

      case 'CI_CompChair_6':
        showSeatInfo(objectName, date, startTime, endTime);
        break;
  
    case 'CI_CompChair_4':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_3':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_2':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    case 'CI_CompChair_1':
      showSeatInfo(objectName, date, startTime, endTime);
      break;
  
    // Add more cases as needed for seats A4 to A1
  
    default:
      hideTooltip();
      break;
  }
          
        });
      });
    });