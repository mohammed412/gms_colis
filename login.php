<?php 
session_start();

require('db/connection.php');

$errors = [];
if (isset($_POST['login'])) {
  if (empty($_POST['email'])) {
    $errors[] = 'email required';
    
  }
  if(empty($_POST['password'])){
    $errors[] = "password required";
  
  }
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $errors[] = 'Email format invalide';
  }

  if(count($errors) === 0){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $con->prepare("SELECT * from utilisateur WHERE mail = :EMAIL ");
    if($query->execute(["EMAIL" => $email])){
      $user = $query->fetch(PDO::FETCH_OBJ);
      if ($user && password_verify($password, $user->password)) {
        $_SESSION['user'] = $user;
        header('Location:prive/index.php', true);
      }
      else{
        $errors[] = 'email or password incorrect';
      }
    }
    
  }
  
}





?>



<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php') ?>
<body>
<?php require('partials/header.php') ?>
<main>
<div class="breadcrumbs d-flex align-items-center" style="background-image: url('images/header_img.jpg');">
  <div class="container position-relative d-flex flex-column align-items-center aos-init aos-animate" data-aos="fade">

    <h2>Connexion</h2>
    <ol>
      <li><a href="home.php">Accueil</a></li>
      <li>Connexion</li>
    </ol>

  </div>
</div><!-- End Breadcrumbs -->
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="images/box (2).png"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST">
       
           <?php foreach($errors as $error){
            echo ' <div class="d-flex justify-content-between align-items-center"><div style="width:100%" class="alert alert-danger" role="alert">'.$error.'</div></div>';
           }?>
        
           
         

          

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="form3Example3" name="email" class="form-control form-control-lg"
              placeholder="Enter a valid email address" />
            <label class="form-label" for="form3Example3" >Votre Email</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" />
            <label class="form-label" for="form3Example4"  >Mot de passe</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
           
            
            <a href="#!" class="text-body">Mot de passe oublié ?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="login" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem; color:#f1a320; background-color: #2b2555;" value="Connexion" />
            
          </div>

        </form>
        
      </div>
    </div>
  </div>
  
</section>
</main>
<?php require('partials/footer.php') ?>
<?php require('partials/scripts.php') ?>

</body>
</html>