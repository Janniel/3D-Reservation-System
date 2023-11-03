import * as THREE from 'three'
import "./styles/home.css"
import gsap from "gsap"
import exterior from "./models/exterior.gltf"
import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader'

//Scene
const scene = new THREE.Scene()

//load model
const loader = new GLTFLoader()
loader.load("./models/exterior.gltf", function(gltf) {
  console.log(gltf)
  const root = gltf.scene
  root.scale.set(0.2,0.2,0.2)
  root.position.y = -6
  root.rotation.y = 3

  scene.add(root)

  // TIMELINE
const tl = gsap.timeline({defaults: {duration: 1} })
tl.fromTo(root.scale, {z:0, x:0, y:0}, {z: 0.20, x: 0.20, y: 0.20})
})

//Sizes
const sizes = {
  width: window.innerWidth,
  height: window.innerHeight,
}

//Light
const light = new THREE.AmbientLight(0x404040, 10, 100)
scene.add(light)

//Camera
const camera = new THREE.PerspectiveCamera(50, sizes.width/sizes.height, 0.1, 100)
camera.position.z = 30
scene.add(camera)

//Renderer
const canvas = document.querySelector('.webgl')
const renderer = new THREE.WebGLRenderer({canvas})
const backgroundColor = new THREE.Color(0xffffff);
renderer.setClearColor(backgroundColor);
renderer.setSize(sizes.width, sizes.height)
renderer.render(scene, camera)
renderer.setPixelRatio(1)

//Controls
const controls = new OrbitControls(camera, canvas)
controls.enableDamping = true
controls.enablePan = false
controls.enableZoom = false
controls.autoRotate = true
controls.autoRotateSpeed = 1

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

const loop = () => {
  controls.update()
  renderer.render(scene, camera)
  window.requestAnimationFrame(loop)
}
loop()

