import * as THREE from 'three'
import "./styles/reserve.css"
import interior from "./models/interior final.glb"
import gsap from "gsap"
import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader'
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader'


//Scene
const scene = new THREE.Scene()

//GLTF Loader
const loader = new GLTFLoader()
let gltfmodel;
loader.load("./models/interior final.glb", function(gltf) {
  console.log(gltf)
  gltfmodel = gltf.scene
  gltfmodel.scale.set(1,1,1)
  gltfmodel.position.y = -0.2
  scene.add(gltfmodel)

  window.addEventListener('mouseup', function() {
    console.log(('Camera Position: '), camera.position)
    console.log(('Controls Target: '), controls.target)

  })

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

const light2 = new THREE.HemisphereLight(0xD1D1D1, 0xFFB92E, 1.1)
scene.add(light2)

//Camera
const camera = new THREE.PerspectiveCamera(45, sizes.width/sizes.height, 0.1, 100)
camera.position.x = -0.34
camera.position.z = 1.315
camera.position.y = -0.059
scene.add(camera)

//Renderer
const canvas = document.querySelector('.webgl2')
const renderer = new THREE.WebGLRenderer({canvas})
renderer.setSize(sizes.width, sizes.height)
renderer.render(scene, camera)
renderer.setPixelRatio(2)

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

const explore = document.querySelector(".explore");
const titlediv = document.querySelector(".container");

const tooltip = document.querySelector(".tooltip")
const tooltipHeading = tooltip.querySelector('h2');
const tooltipParagraph = tooltip.querySelector('p');
tooltip.style.display = 'none'

const sectionNav = document.querySelector(".section-nav")
const section1 = sectionNav.querySelector(".section1")
const section2 = sectionNav.querySelector(".section2")
const section3 = sectionNav.querySelector(".section3")
const section4 = sectionNav.querySelector(".section4")

explore.addEventListener("click", ()=> {
  moveCamera(-1.46, 0.44, -0.17)
  rotateCamera(0, 0.1, 0)
  titlediv.style.pointerEvents = "none"
  titlediv.classList.add("hidden")
  controls.minPolarAngle = Math.PI / 10;
  controls.maxPolarAngle = (2 * Math.PI) / 3.8;
  showtip()
  showsection()
})

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
    duration: 2.2,
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
    duration: 2.4
  })
}

function showtitle () {
  titlediv.style.display = "block"
  const tl2 = gsap.timeline({defaults: {duration: 1.5} })
  tl2.fromTo(titlediv, {x: "-100%"}, {x:"0%"})
}

function showsection () {
  sectionNav.style.display = "block"
  sectionNav.style.opacity = "1"
  const tl3 = gsap.timeline({defaults: {duration: 1.5, delay: 2} })
  tl3.fromTo(sectionNav, {x: "-100%"}, {x:"0%"})
}

function showtip () {
  tooltip.style.display = "block"
  const tl4 = gsap.timeline({defaults: {delay: 10} })
  tl4.fromTo(tooltip, {opacity:0}, {opacity:1})
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
  }

  function hideTooltip() {
    tooltip.style.opacity = '0'
    tooltip.style.transform = 'translateY(-10px)'
    tooltip.style.pointerEvents = 'none'
  }
  
  window.addEventListener('mousemove', (event) => {
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
        console.log('Clicked on the 1_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT L1');
        break;
      
      case '1_CompChair_2':
        console.log('Clicked on the 1_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT L2');
        break;
      
      case '1_CompChair_3':
        console.log('Clicked on the 1_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT L3');
        break;

      case '1_CompChair_4':
        console.log('Clicked on the 1_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT L4');
        break;

        case '1_CompChair_5':
        console.log('Clicked on the 1_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT L5');
        break;

        case '2_CompChair_1':
        console.log('Clicked on the 2_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT K1');
        break;

        case '2_CompChair_2':
        console.log('Clicked on the 2_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT K2');
        break;

        case '2_CompChair_3':
        console.log('Clicked on the 2_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT K3');
        break;

        case '2_CompChair_4':
        console.log('Clicked on the 2_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT K4');
        break;

        case '2_CompChair_5':
        console.log('Clicked on the 2_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT K5');
        break;

        case '3_CompChair_1':
        console.log('Clicked on the 3_CompChair_1 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT J1');
        break;

        case '3_CompChair_2':
        console.log('Clicked on the 3_CompChair_2 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT J2');
        break;

        case '3_CompChair_3':
        console.log('Clicked on the 3_CompChair_3 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT J3');
        break;

        case '3_CompChair_4':
        console.log('Clicked on the 3_CompChair_4 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT J4');
        break;

        case '3_CompChair_5':
        console.log('Clicked on the 3_CompChair_5 object');
        showTooltip(event, 'Click to reserve seat', 'SEAT J5');
        break;

      default:
        hideTooltip()
        break;
      }
    }
  
  });