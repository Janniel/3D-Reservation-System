<!--<header class="header-outer">
  <div class="header-inner responsive-wrapper">
    <div class="header-logo">
      <img src="img/elib logo.png" class="icon">
    </div>
    <div class="header-text">
      <strong>SOAR</strong>
    </div>
    <div id="header-time">
      <div id="phtime">
        <p class="phdate">Philippine Time: </p>
        <div id="date"></div>
      </div>
      <div id="clock">
        <div class="clock">
          <div class="hour">
            <div class="hr" id="hr"></div>
          </div>
          <div class="min">
            <div class="mn" id="mn"></div>
          </div>
          <div class="sec">
            <div class="sc" id="sc"></div>
          </div>
        </div>
      </div>
    </div>
    <nav class="header-navigation">
      <a class="active" href="index.php">HOME</a>
      <a href="index.php#aboutSOAR">ABOUT US</a>
      <a href="reserve.php">RESERVE SEAT</a>
      <a id="hidden" href="occupy.php">OCCUPY SEAT</a>
      <a id="hidden" href="profile.php">ACCOUNT</a>
      <a id="hidden" href="toLogout.php">LOGOUT</a>
      
    </nav>
  </div>
</header> -->

<header class="header-outer">
<nav>
        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Product</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Forum</a></li>
            <li><a href="#">Login</a></li>
        </ul>
        
        <ul>
            <li>
            <a>
              <img src="img/elib logo.png" class="icon"> 
              <strong>SOAR</strong>
            
            </a>
              
            </li>
            <div id="header-time">
              <div id="phtime">
                <p class="phdate">Philippine Time: </p>
                <div id="date"></div>
              </div>
              <div id="clock">
                <div class="clock">
                  <div class="hour">
                    <div class="hr" id="hr"></div>
                  </div>
                  <div class="min">
                    <div class="mn" id="mn"></div>
                  </div>
                  <div class="sec">
                    <div class="sc" id="sc"></div>
                  </div>
                </div>
              </div>
            </div>
            <li class="hideOnMobile"><a href="#">Blog</a></li>
            <li class="hideOnMobile"><a href="#">Product</a></li>
            <li class="hideOnMobile"><a href="#">About</a></li>
            <li class="hideOnMobile"><a href="#">Forum</a></li>
            <li class="hideOnMobile"><a href="#">Login</a></li>
            <li class="menu-button" onclick="showSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </nav>

    
</header>
<script>
        function showSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'flex'
        }
        function hideSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'none'
        }
    </script>

