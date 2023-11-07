import * as THREE from 'three'
import "./styles/seats-info.css"
import interior from "./models/interior final.glb"
import gsap from "gsap"
import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader'
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader'

//Scene
const scene = new THREE.Scene()

//GLTF Loader
const loader = new GLTFLoader()
let gltfmodel2;
loader.load("./models/interior final.glb", function(gltf) {
  console.log(gltf)
  gltfmodel2 = gltf.scene
  gltfmodel2.scale.set(1,1,1)
  gltfmodel2.position.y = -0.2
  scene.add(gltfmodel2);

// TIMELINE
const tl = gsap.timeline({defaults: {duration: 1}})
tl.fromTo(gltfmodel2.scale, {z:0, x:0, y:0}, {z: 0.20, x: 0.20, y: 0.20})
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
const canvas = document.querySelector('.webgl3')
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
  })


//Animate
const loop = () => {
  controls.update()
  renderer.render(scene, camera)
  window.requestAnimationFrame(loop)
}
loop()

const infoContainer = document.querySelector(".info-container");
const infoHeading = infoContainer.querySelector('h3');
const infoParagraph = infoContainer.querySelector('p');
const infoButton = document.querySelector(".maintenance-btn")


function showInfo(event, headerText) {
  infoHeading.textContent = headerText;
  infoContainer.style.opacity = '1'
  infoContainer.style.transform = 'translateX(0px)'
  infoContainer.style.display = "block" 
  infoContainer.style.pointerEvents = 'all'
}

function hideInfo() {
  infoContainer.style.opacity = '0'
  infoContainer.style.transform = 'translateX(10px)'
  infoContainer.style.pointerEvents = 'none'
}


 // when user hover the seats
 window.addEventListener('click', (event) => {

  const mouse = new THREE.Vector2();
  mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

  const raycaster = new THREE.Raycaster();
  raycaster.setFromCamera(mouse, camera);

  const intersects = raycaster.intersectObject(gltfmodel2, true);

  if (intersects.length > 0) {
    const selectedObject = intersects[0].object;
    const objectName = selectedObject.name;

    switch(objectName) {

    case '1_CompChair_1':
      console.log('hovered on the 1_CompChair_1 object');
      showInfo(event, 'SEAT B1');
      break;
    
    case '1_CompChair_2':
      console.log('hovered on the 1_CompChair_2 object');
      showInfo(event, 'SEAT B2');
      break;
    
    case '1_CompChair_3':
      console.log('hovered on the 1_CompChair_3 object');
      showInfo(event, 'SEAT B3');
      break;

    case '1_CompChair_4':
      console.log('hovered on the 1_CompChair_4 object');
      showInfo(event, 'SEAT B4');
      break;

      case '1_CompChair_5':
      console.log('hovered on the 1_CompChair_5 object');
      showInfo(event, 'SEAT B5'); 
      break;

      case '2_CompChair_1':
      console.log('hovered on the 2_CompChair_1 object');
      showInfo(event, 'SEAT B6');
      break;

      case '2_CompChair_2':
      console.log('hovered on the 2_CompChair_2 object');
      showInfo(event, 'SEAT B7');
      break;

      case '2_CompChair_3':
      console.log('hovered on the 2_CompChair_3 object');
      showInfo(event, 'SEAT B8');
      break;

      case '2_CompChair_4':
      console.log('hovered on the 2_CompChair_4 object');
      showInfo(event, 'SEAT B9');
      break;

      case '2_CompChair_5':
      console.log('hovered on the 2_CompChair_5 object');
      showInfo(event, 'SEAT B10');
      break;

      case '3_CompChair_1':
      console.log('hovered on the 3_CompChair_1 object');
      showInfo(event, 'SEAT B11');
      break;

      case '3_CompChair_2':
      console.log('hovered on the 3_CompChair_2 object');
      showInfo(event, 'SEAT B12');
      break;

      case '3_CompChair_3':
      console.log('hovered on the 3_CompChair_3 object');
      showInfo(event, 'SEAT B13');
      break;

      case '3_CompChair_4':
      console.log('hovered on the 3_CompChair_4 object');
      showInfo(event, 'SEAT B14');
      break;

      case '3_CompChair_5':
      console.log('hovered on the 3_CompChair_5 object');
      showInfo(event, 'SEAT B15');
      break;

    default:
      hideInfo()
      break;
    }
  }


});