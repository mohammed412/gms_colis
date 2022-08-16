<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="home.php" class="logo-gms d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <img src="images/logo.png" alt="logo">
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar" style="margin-bottom: 75px;">
        <ul>
          <li><a id="home" href="home.php">Accueil</a></li>
          <li><a id="about" href="presentation.php">Présentation</a></li>
          <li><a id="mission" href="missions.php">Nos Missions</a></li>
          <li><a id="contact" href="contact.php">Contact</a></li>
          <li><a id="auth"  href="login.php">Se connecter</a></li>
         
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  
  
  
  <script>
  var path = window.location.pathname;
  var page = path.split("/").pop();
  // console.log(page+ "hey");
  switch(page){
    case 'contact.php':
      document.getElementById('contact').className = "active";
      break;
    case 'about.php':
      document.getElementById('about').className = "active";
      break;
    case '':
      document.getElementById('home').className = "active"
      break;
    case 'mission.php':
      document.getElementById('mission').className = "active"
      break;
    case 'login.php':
      document.getElementById('auth').className = "active"

  }
</script>