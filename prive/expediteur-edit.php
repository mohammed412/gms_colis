<?php
require('../db/connection.php');


$id = $_GET["id"]; 


//search for user
$query = $con->prepare("SELECT * FROM expediteur WHERE id_Expediteur = :id");
if($query->execute(['id'=>$id])){
  $expediteur = $query->fetch(PDO::FETCH_OBJ);
}

// errors array
$errors =[];

//form fields
$fields = ['nom', 'mail'];



  //Ajouter action
  if (isset($_POST['enregistrer'])) {
        
        
    foreach($fields as $field){
        if(empty($_POST[$field])){
            $errors[] = $field.' is required';
        }
        
    }
    $stm = "UPDATE expediteur set Nom = :nom,  mail = :mail WHERE id_Expediteur = :id";
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $mail = $_POST['mail'];
   
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format invalide";
    }
    
            
    $params =["nom"=>$nom,  "mail"=>$mail, "id"=>$expediteur->id_Expediteur];
    
    
    if(count($errors) === 0){
        $query = $con->prepare($stm);
        if ($query->execute($params)) {
            header("Location:expediteur.php");
        }
    }
    else{
        foreach($errors as $error){
            echo $error;
        }
    }

    }


?>
<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php')?>
<body>
    

<?php require('partials/header.php')?>
<div class="container">
<form method="POST" style="margin-top: 30px;" enctype="multipart/form-data">
  <!-- 2 column grid layout with text inputs for the first and last names -->
  

  <!-- Text input -->
  
  <!-- Text input -->
  <div class="form-outline mb-4">
    <label class="form-label"  for="form6Example4">Nom</label>
    <input type="text" name="nom" value="<?= $expediteur->Nom ?>" id="nom" class="form-control" />
    
  </div>

  <!-- Email input -->

  <div class="form-outline mb-4">
    <label class="form-label" for="form6Example5">Adress E-Mail</label>
    <input type="email" name="mail" value="<?= $expediteur->mail ?>" id="mail" class="form-control" />
    
  </div>
  <!-- Submit button -->
 <div class="modal-footer">
    
        <a href="expediteur.php" style="margin-right: 10px;"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button></a>
        <button type="submit" name="enregistrer" class="btn btn-primary">Enregistrer</button>
      </div>
</form>
</div>
<?php require('partials/scripts.php')?>
</body>
</html>