<?php
require('../db/connection.php');


$id = $_GET["id"]; 


//search for user
$query = $con->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id");
if($query->execute(['id'=>$id])){
  $utilisateur = $query->fetch(PDO::FETCH_OBJ);
}

// errors array
$errors =[];

//form fields
$fields = ['nom', 'tele', 'mail', 'prenom'];


//Importe expediteurs 

$query = $con->prepare("SELECT Nom, id_Expediteur id From expediteur");
if ($query->execute()) {
    $expediteurs = $query->fetchAll(PDO::FETCH_OBJ);
    
}

//modifier action

  //Ajouter action
  if (isset($_POST['enregistrer'])) {
        
        
    foreach($fields as $field){
        if(empty($_POST[$field])){
            $errors[] = $field.' is required';
        }
        
    }
    $stm = "UPDATE utilisateur set Nom = :nom, prenom = :prenom, mail = :mail, tel = :tel , livreur = :livreur, id_Expediteur = :id_Exp, Expediteur =:exp, photo=:photo WHERE id_utilisateur = :id";
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $mail = $_POST['mail'];
    $tele = $_POST['tele'];
    echo $tele;
    
    $expe = 0;
    $liv = 0;
    $id_expe = 0;
    $photoname = $utilisateur;

    if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
        $tempname = $_FILES["photo"]["tmp_name"];
        
        $photoname = file_get_contents($tempname); 
        
    }
    
    
    
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format invalide";
    }
    
    
    
       
        
    if( !empty($_POST["type_livreur"])){
               $liv = 1;
            }
    if( !empty($_POST["type_expediteur"])){
                $count = 0;
                $expCount = count($expediteurs);
                foreach($expediteurs as $expediteur){
                    ++$count;
                    if($expediteur->id == $_POST['expediteur']){
                        $expe = 1;
                        $id_expe = $_POST['expediteurs'];
                        break;
                    }
                    if($count === $expCount){
                        $errors[]="expediteur invalide";
                    }
                }
            }
            
    $params =["nom"=>$nom, "prenom"=>$prenom, "mail"=>$mail, "tel"=>$tele, "id" => $utilisateur->id_utilisateur, "exp"=>$expe, "id_Exp"=>$id_expe, "livreur"=>$liv, "photo"=>$photoname];
    
    
    if(count($errors) === 0){
        $query = $con->prepare($stm);
        if ($query->execute($params)) {
            header("Location:utilisateur.php");
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
    <input type="text" name="nom" value="<?= $utilisateur->Nom ?>" id="nom" class="form-control" />
    
  </div>

  <!-- Email input -->
  <div class="form-outline mb-4">
    <label class="form-label" for="form6Example5">Prenom</label>
    <input name="prenom" type="text" value="<?= $utilisateur->prenom ?>" id="prenom" class="form-control" />
    
  </div>

  <div class="form-outline mb-4">
    <label class="form-label" for="form6Example5">Tél</label>
    <input type="text" name="tele" value="<?= $utilisateur->tel ?>" id="adress" class="form-control" />
    
  </div>

  <div class="form-outline mb-4">
    <label class="form-label" for="form6Example5">Adress E-Mail</label>
    <input type="email" name="mail" value="<?= $utilisateur->mail ?>" id="mail" class="form-control" />
    
  </div>

  <div class="row">
  <div class="form-check form-check-inline col-auto">
    <label class="form-check-label"  for="inlineRadio1">Livreur</label>
    <input class="form-check-input" <?php if($utilisateur->livreur == 1) echo "checked"?> type="checkbox"  id="inlineRadio1" name="type_livreur" value="livreur">
    

</div>
<div class="form-check form-check-inline col-auto">
  <input class="form-check-input" type="checkbox"  id="inlineRadio2" name="inactif" value="inactif">
  <label class="form-check-label" for="inlineRadio2">Inactif</label>
</div>
<div class="form-check form-check-inline col-auto">
  <input class="form-check-input" <?php if($utilisateur->Expediteur == 1) echo "checked"?>  type="checkbox" id="inlineRadio3" name="type_expediteur" value="expediteur" >
  <label class="form-check-label"  for="inlineRadio3">Expéditeur</label>
</div>
<div class="col-auto col-auto">
      <label class="mr-sm-2" for="inlineFormCustomSelect">Expéditeurs</label>
      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="expediteurs">
        <option>Expéditeur</option>
        <?php
       
        foreach($expediteurs as $expediteur):?>
                <option <?php if($utilisateur->id_Expediteur == $expediteur->id) echo 'selected'?> value="<?=$expediteur->id?>"><?=$expediteur->Nom ?></option>;
            
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group col-auto">
    <label for="exampleFormControlFile1">Photo </label>
    <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1">
  </div>
</div>
  <!-- Submit button -->
 <div class="modal-footer">
    
        <a href="utilisateur.php" style="margin-right: 10px;"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button></a>
        <button type="submit" name="enregistrer" class="btn btn-primary">Enregistrer</button>
      </div>
</form>
</div>
<?php require('partials/scripts.php')?>
</body>
</html>