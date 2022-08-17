<?php
require('../db/connection.php');


$id = $_GET["id"]; 


//search for user
$query = $con->prepare("SELECT * FROM remarques WHERE id_remarques = :id");
if($query->execute(['id'=>$id])){
  $remarque = $query->fetch(PDO::FETCH_OBJ);
  
}

// errors array
$errors =[];





  //Enregistrer action
  if (isset($_POST['enregistrer'])) {
        
    if(empty($_POST['libelle']))
        $errors[] = "libelle required";
    
    $stm = "UPDATE remarques set libelle = :libelle WHERE id_remarques = :id";
    $libelle = filter_var($_POST['libelle'], FILTER_SANITIZE_STRING);
    
            
    $params =["libelle"=>$libelle, "id"=>$remarque->id_remarques];
    
    
    if(count($errors) === 0){
        $query = $con->prepare($stm);
        if ($query->execute($params)) {
            header("Location:remarque.php");
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

  <div class="form-outline mb-4">
    <label class="form-label"  for="form6Example4">Nom</label>
    <input type="text" name="libelle" value="<?= $remarque->libelle ?>" id="nom" class="form-control" />
    
  </div>

  
  <!-- Submit button -->
 <div class="modal-footer">
    
        <a href="remarque.php" style="margin-right: 10px;"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button></a>
        <button type="submit" name="enregistrer" class="btn btn-primary">Enregistrer</button>
      </div>
</form>
</div>
<?php require('partials/scripts.php')?>
</body>
</html>