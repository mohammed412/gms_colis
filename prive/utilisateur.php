<?php
    require('../db/connection.php');

    // if(!isset($_SESSION['user'])){
    //     header("Location:../login.php");
    //     exit();
    // }

    //Delete
    if(isset($_GET['id'])){
    $query = $con->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :ID");
    if ($query->execute(["ID"=>$_GET['id']])) {
        header("Location:utilisateur.php", true);
    }
}

    //pagination

    if(isset($_POST['cree'])){
        $query = $con->prepare("INSERT INTO utilisateur (id_utilisateur) values (default)");
        if($query->execute()){
            $id = $con->lastInsertId();
            header("Location:utilisateur-edit.php?id=".$id);
        }
    }

    
    $query = $con->prepare("SELECT id_utilisateur id, Nom, prenom, mail, photo FROM utilisateur");
    if ($query->execute()) {
        $utilisateurs = $query->fetchAll(PDO::FETCH_OBJ);
    }

    $errors =[];
    $fields = ['nom', 'tele', 'mail', 'prenom'];

    //users type

    $users_type = ['livreur', 'expediteur', 'inactif'];

    //Importe expediteurs 

    $query = $con->prepare("SELECT Nom, id_Expediteur id From expediteur");
        if ($query->execute()) {
            $expediteurs = $query->fetchAll(PDO::FETCH_OBJ);
            
        }


        //Ajouter action
    if (isset($_POST['ajouter'])) {
        
        
        foreach($fields as $field){
            if(empty($_POST[$field])){
                $errors[] = $field.' is required';
            }
            
        }
        $stm = "";
        $params =[];
        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
        $mail = $_POST['mail'];
        $tele = $_POST['tele'];
        $userType = $_POST['user_type'];
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email format invalide";
        }
        if (!filter_var($tele, FILTER_VALIDATE_INT)) {
            $errors[] = "Numero de telephon invalide";
        }
        if(!isset($_POST['user_type']) || !in_array($userType, $users_type)){
            $errors[] = "invalide utilisateur type";
        }
        else{
            $params = ["nom"=>$nom, "prenom"=>$prenom, "mail"=>$mail, "tel"=>$tele];
            switch($userType){
                case "livreur":
                    $stm = "INSERT INTO utilisateur(id_utilisateur, Nom, prenom, mail, tel, livreur) VALUES (default, :nom, :prenom, :mail, :tel, :livreur)";
                    $params["livreur"] = 1;
                    var_dump($params);
                    break;
                case "expediteur":
                    $count = 0;
                    $expCount = count($expediteurs);
                    foreach($expediteurs as $expediteur){
                        ++$count;
                        if($expediteur->id == $_POST['expediteur']){
                            $stm = "INSERT INTO utilisateur(id_utilisateur, Nom, prenom, mail, tel, Expediteur, id_Expediteur) VALUES (default,:nom, :prenom, :mail, :tel, :expediteur, :id_exp)";
                            $params["expediteur"] = 1;
                            $params["id_exp"] = $_POST['expiditeur'];
                            
                            break;
                        }
                        if($count === $expCount){
                            $errors[]="expediteur invalide";
                        }
                    }

            }
        }
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
<?php require('partials/head.php') ?>
<body>
<?php require('partials/header.php') ?>

    <div class="container">
    <main>
         <div class="container-fluid px-4">
             
             
             <div class="card mb-4">
                 <div class="card-header">
                     <i class="fas fa-table me-1"></i>
                     Liste Des Utilisateurs 
                     <form  method="post">
                         <button type="submit" name="cree" style="margin-top: 10px; margin-bottom: 10px;" class="justify-content-left btn btn-success">Ajouter Utilisateur</button>
                 </form>
                 </div>

                 
                     
                            <div class="card-body">
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Adresse Mail</th>
                                           
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($utilisateurs as $utilisateur){
                                        echo "<tr>";
                                            echo "<td><img style='height:60px' src='user_images/$utilisateur->photo' alt='photo'></td>";
                                            echo "<td>$utilisateur->Nom</td>";
                                            echo "<td>$utilisateur->prenom</td>";
                                            echo "<td>$utilisateur->mail</td>";
                                            
                                            echo '<th>
                                            <a href="utilisateur-edit.php?id='.$utilisateur->id.'" title="Modifier"><img src="../images/icons8-edit-32.png" ></a>
                                            <a href="utilisateur.php?id='.$utilisateur->id.'" title="Supprimer"><img src="../images/icons8-delete-30.png" alt="DELETE"></a>
                                            
                                            </th>';
                                        
                                        
                                        echo "</tr>";
                                        }?>
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                

<?php require('partials/scripts.php') ?>
</body>
</html>