<!DOCTYPE html>
<html lang="en">
  <?php 
  require('partials/head.php')
  ?>
<body>
<?php 
  require('partials/header.php')
  ?>

 <!-- ======= Get Started Section ======= -->
 <main id="main">

<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs d-flex align-items-center" style="background-image: url('images/header_img.jpg');">
  <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

    <h2>Contact</h2>
    <ol>
      <li><a href="home.php">Accueil</a></li>
      <li>Contact</li>
    </ol>

  </div>
</div><!-- End Breadcrumbs -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      <div class="col-lg-6">
        <div class="info-item  d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-map"></i>
          <h3>Nos Agences</h3>
          <p>Bd Brahim Roudani Centre « NADIA » Imm II N° 9 Casablanca</p>
          
        </div>
      </div><!-- End Info Item -->

      <div class="col-lg-3 col-md-6">
        <div class="info-item d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-envelope"></i>
          <h3>Notre Email</h3>
          <p>contact@mondialservice.ma</p>
        </div>
      </div><!-- End Info Item -->

      <div class="col-lg-3 col-md-6">
        <div class="info-item  d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-telephone"></i>
          <h3>Appelez-Nous</h3>
          <p>Tél: +(212)522.99.31.21</p>
          <p> Fax: +(212)522.98.39.59</p>
        </div>
      </div><!-- End Info Item -->

    </div>

    <div class="row gy-4 mt-1">

    <div class="col-lg-6 d-flex align-items-center" data-aos="fade-up">
            <div class="content">
              <h3>Contacter Nous</h3>
              <p>Vous avez besoin de conseils sur un produit, un service ou une destination. Vous souhaitez obtenir des informations sur un colis.</p>


              <p>Veuillez Nous Contacter</p>
            </div>
          </div>

      <div class="col-lg-6">
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row gy-4">
            <div class="col-lg-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required>
            </div>
            <div class="col-lg-6 form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Objet" required>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Obtenir un devis</button></div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>
</section><!-- End Contact Section -->

</main><!-- End #main -->



  <?php 
  require('partials/footer.php')
  ?>

 
  <?php 
  require('partials/scripts.php')
  ?>
</body>
</html>


