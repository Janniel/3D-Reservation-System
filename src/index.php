<?php
session_start();
require 'php/connect.php';
// require 'php/session.php';


?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <!------------------------ Bootstrap 5 ------------------------>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!------------------------ CSS Link ------------------------>
    <!-- Add this link for Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- Add this link for Bootstrap JavaScript (jQuery is a dependency) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!------------------------ For NAV-BAR ------------------------>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!------------------------ Google Fonts Used ------------------------>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Playfair+Display:ital@1&display=swap"
        rel="stylesheet">

    <!-- animation on scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>
    <style>
    /* Small devices (tablets, 768px and up) */
    /* Default styles for the model-viewer */
    
    .model-viewer {
    width: 100%; /* Initially, it takes the full width of its container */
    height: 100%; /* Initially, it takes the full height of its container */
    max-width: 100%; /* Ensure it doesn't exceed the container's width */
    max-height: 100%; /* Ensure it doesn't exceed the container's height */
    }

    /* Media query for larger screens */
    
        /* Large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
        model-viewer {
            width: 100%;
            height: 600px;
            margin: 0, auto;
        }
        }
  </style>
</head>

<body>


    <script>

        // Function to trigger the PHP script
        function triggerValidation() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'php/validateReservation.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log('Checked expired validation');
                    } else {
                        console.log('Error in checking expired validation');
                    }
                }
            };
            xhr.send();
        }

        // Call the function immediately
        triggerValidation();

        // Set up a recurring timer to call the function every 5 seconds (5000 milliseconds)
        setInterval(triggerValidation, 5000);
    </script>

    <script>
        AOS.init();

    </script>

    <div class="wrapper">

        <!------------------------ HEADER --------------------->

        <?php
        // if the user was not logged in
        if (
            !isset($_SESSION["user_id"]) && !isset($_SESSION["password"]) && !isset($_SESSION["first_name"])
            && !isset($_SESSION["last_name"]) && !isset($_SESSION["reservation_count"])
        ) {
            require 'php/header_notLogged.php';


        } else {
            require 'php/header.php';
            require 'php/occupancy_timer.php';
        }

        ?>

        <!------------------------ END HEADER --------------------->
        <!------------------------ COVER ------------------------>
        <div id="home" class="parallax-home">
            <img class="banner" src="img/lib building_bg.jpg" id="lib-front">

            <div class="title">
                <h1 id="parallax-home-text-lib" data-aos="fade-up" data-aos="fade-up" data-aos-duration="500">Library
                </h1>
                <h1 id="parallax-home-text-school" data-aos="fade-up" data-aos-duration="800">BULACAN STATE UNIVERSITY
                </h1>
                <h1 id="parallax-home-text-disc" data-aos="fade-up" data-aos-duration="1100">Discover and Learn</h1>
            </div>
        </div>
        <!------------------------ END OF COVER ------------------------>


        <!------------------------ SEAT INFO ------------------------>
        <!--<div class="webgl-container">
            <<canvas class="webgl"></canvas> 
            
            


            
            <a href="reserve.php" class="reserve-btn btn">
                Reserve seat
            </a>
        </div> -->

    
        
            <section class="webgl-container">
                <model-viewer 
                    id="myModelViewer"
                    src="models/exterior.glb"
                    ar
                    ar-modes="webxr scene-viewer quick-look"
                    poster="poster.webp"
                    shadow-intensity="1"
                    auto-rotate
                    min-camera-orbit="auto 63deg auto"
                    max-camera-orbit="auto 99deg auto"
                    camera-orbit="-178.4deg 76.97deg 186.6m"
                    field-of-view="30deg"
                    width="1200"
                    height="600"
                    
                    >
                    <div class="progress-bar hide" slot="progress-bar">
                        <div class="update-bar"></div>
                    </div>
                </model-viewer>
                <a href="reserve.php" class="reserve-btn btn">
                    Reserve seat
                </a>
            </section>

            <script>
    const modelViewer = document.getElementById('#myModelViewer');
    
    modelViewer.addEventListener('wheel', (event) => {
        event.preventDefault(); // Prevent zooming via mouse wheel
    });

    modelViewer.addEventListener('touchmove', (event) => {
        event.preventDefault(); // Prevent panning via touch gestures
    });

</script>

        <!------------------------ END OF SEAT INFO ------------------------>


        <!------------------------ ABOUT US ------------------------>
        <span class="abtus" id="aboutSOAR"></span>
        <div class="section"></div>
        <div id="aboutus">
            <h2>ABOUT US</h2>
            <p>
                The Bulacan State University Library, through its resources, facility, and staff, is dedicated to
                providing open
                access to information and to offering the services and tools with which to locate and interpret that
                information. As patrons’ needs and information technologies continue to evolve, so will the means
                with which the
                Library attempts to fulfill its role within the community.
            </p>
        </div>

        <!------------------------ END OF ABOUT US ------------------------>
        <section class="carousel-section">
        <input type="radio" id="s-1" name="slider-control" checked="checked">
            <input type="radio" id="s-2" name="slider-control">
            <input type="radio" id="s-3" name="slider-control">
            <div class="js-slider">
            <figure class="js-slider_item img-1">
                <div class="js-slider_img">
                <img class="c-img-w-full" src="img/reserve.png" alt="">
                </div>
                <figcaption class="wo-caption">
                <h3 class="wo-h3">
                    <div class="c-label">How to Reserve a seat?</div>
                    <br class="view-sm mb-s">1. Filter Date</h3>
                <ul class="wo-credit">
                    <li>Go to <a href="reserve.php">Reserve Seat</a> tab</li>
                    <li>Choose and filter your desired date and time of reservation</li>
                    
                </ul>
                </figcaption>
            </figure>
            <figure class="js-slider_item img-2">
                <div class="js-slider_img">
                <img class="c-img-h-full" src="img/seat.png" alt=""></div>
                <figcaption class="wo-caption">
                <h3 class="wo-h3">2. Naviagate and choose available seat</h3>
                <ul class="wo-credit">
                    <li>Click the preferred available seat and confirm your reservation</li>
                    <li>Unavailable seats are hidden from view</li>
                    <li>Once reserved, you can keep track of your reservation details in the <a href="account.php">Account </a>tab. You may also cancel your reservation here.</ul>
                </figcaption>
            </figure>
            <figure class="js-slider_item img-3">
                <div class="js-slider_img">
                <img class="c-img-h-full" src="img/rfid.png" alt=""></div>
                <figcaption class="wo-caption">
                <h3 class="wo-h3">3. Scan your RFID</h3>
                <ul class="wo-credit">
                    <li>Upon your scheduled reservation, insert your RFID in the scanner. Don't remove it to keep the seat occupied.</li>
                    <li>If you are unable to scan your RFID within the first 10 minutes of your shceduled time, the reservation will automatically becancelled.</li>
                    <li>Once done with the reservation, remove your RFID in the scanner and give us a feedback!</li></ul>
                </figcaption>
            </figure>
            <div class="js-slider_nav">
                <label class="js-slider_nav_item s-nav-1 prev" for="s-3"></label>
                <label class="js-slider_nav_item s-nav-1 next" for="s-2"></label>
                <label class="js-slider_nav_item s-nav-2 prev" for="s-1"></label>
                <label class="js-slider_nav_item s-nav-2 next" for="s-3"></label>
                <label class="js-slider_nav_item s-nav-3 prev" for="s-2"></label>
                <label class="js-slider_nav_item s-nav-3 next" for="s-1"></label>
            </div>
            <div class="js-slider_indicator">
                <div class="js-slider-indi indi-1"></div>
                <div class="js-slider-indi indi-2"></div>
                <div class="js-slider-indi indi-3"></div>
            </div>
            </div>
        </section>


        <!------------------------ VMGO ------------------------>

        <div class="wrap">
            <div class="tile" data-aos="fade-up" data-aos-duration="1000">
                <img src='img/elib4.jpg' />
                <div class="text">
                    <h1>Vision</h1>
                    <p class="animate-text">Bulacan State University is a progressive knowledge-generating institution
                        globally recognized for excellent instruction, pioneering research, and responsive community
                        engagements. </p>
                    <div class="dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>


            <div class="tile" data-aos="fade-up" data-aos-duration="1500">
                <img src='img/inaug7.jpg' />
                <div class="text">
                    <h1>Mission</h1>
                    <p class="animate-text"> Bulacan State University exists to produce highly competent, ethical and
                        service-oriented professionals that contribute to the sustainable socio-economic growth and
                        development of the nation </p>
                    <div class="dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

            <div class="tile" data-aos="fade-up" data-aos-duration="2000">
                <img src='img/inaug2.jpg' />
                <div class="text">
                    <h1>Goals</h1>
                    <p class="animate-text">The university is committed to provide education that is accessible to
                        deserving and qualified students through internationally-recognized and industry-responsive
                        programs set in a 21st century learning environment. </p>
                    <div class="dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

            <div class="tile" data-aos="fade-up" data-aos-duration="2000">
                <img src='img/inaug2.jpg' />
                <div class="text">
                    <h1>Core Values</h1>
                    <p class="animate-text">S – Service to God and Community.<br>O – Order and Peace.<br>
                        A – Assurance of Quality and Accountability.<br>R – Respect and Responsibility. </p>
                    <div class="dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>


        <!------------------------ END OF VMGO ------------------------>
        

 

        <!------------------------ FOOTER ------------------------>
        <footer>
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 about-footer">
                            <h3>Bulacan State University
                                E-Library </h3>
                            <ul>
                                <li><a href="tel:(010) 919 7800"><i class="fas fa-phone fa-flip-horizontal"></i>
                                        919 7800</a></li>
                                <li><i class="fas fa-map-marker-alt"></i>
                                    Guinhawa,
                                    <br />City of Malolos,
                                    <br />Bulacan
                                </li>
                                <li><i class="fas fa-at"></i>
                                    officeofthepresident@bulsu.edu.ph
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-2 page-more-info">
                            <div class="footer-title">
                                <h4>Page links</h4>
                            </div>
                            <ul>
                                <li><a href="#home">Home</a></li>
                                <li><a href="#aboutSOAR">About Us</a></li>
                                <li><a href="reserve.php">Reserve seat</a></li>
                                <li><a href="profile.php">Your Account</a></li>
                            </ul>
                        </div>

                        <div class="col-md-6 col-lg-3 page-more-info">
                            <div class="footer-title">
                                <h4>More Info</h4>
                            </div>
                            <ul>
                                <li><a href="survey.php" target="_blank">Rate our service</a></li>
                                <li><a href="https://www.bulsu.edu.ph/" target="_blank">Official Website</a></li>
                                <li><a href="https://myportal.bulsu.edu.ph/" target="_blank">BulSU Portal</a></li>
                                <li><a href="https://www.bulsu.edu.ph/library/" target="_blank">Library Service</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-4 open-hours">
                            <div class="footer-title">
                                <h4>Open hours</h4>
                                <ul class="footer-social">
                                    <li><a href="https://www.facebook.com/BulSUaklatan" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.instagram.com/bulsuaklatan/" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.linkedin.com/school/bulacan-state-university/"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>

                                </ul>
                            </div>
                            <table class="table-hours">
                                <tbody>
                                    <tr>
                                        <td><i class="far fa-clock"></i>Monday-Thursday </td>
                                        <td>10:00am - 7:00pm</td>
                                    </tr>
                                    <tr>
                                        <td><i class="far fa-clock"></i>Friday</td>
                                        <td>10:00am - 7:30pm</td>
                                    </tr>
                                    <tr>
                                        <td><i class="far fa-clock"></i>Saturday</td>
                                        <td>10:30am - 7:30pm</td>
                                    </tr>
                                    <tr>
                                        <td><i class="far fa-clock"></i>Sunday</td>
                                        <td>10:30am - 7:00pm</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="footer-logo">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><img src="img/elib logo.png"></td>
                                            <td><img src="img/bulsu logo.png"></td>
                                    </tbody>
                                </table>
                            </div>
                            <div class="footerBottom">
                                <div class="row">
                                    <div>
                                        <p>© 2017 Bulacan State University</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </footer>
        <!------------------------ FOOTER ------------------------>
    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
    integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
    integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>

</html>