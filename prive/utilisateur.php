<?php

session_start();
if (!$_SESSION['user']) {
    header("Location:../login.php");
    exit();
}

use App\URLHelper;

require '../vendor/autoload.php';

    require('../db/connection.php');

    // if(!isset($_SESSION['user'])){
    //     header("Location:../login.php");
    //     exit();
    // }

    //Delete
    $messages = [];
    if(isset($_GET['id'])){
        // $query = $con->prepare("SELECT * FROM colis WHERE id_utilisateur = :ID");
        // if($query ->execute(['ID'=>$_GET['id']])){
        //     $colis = $query->fetchAll(PDO::FETCH_OBJ);
        //     if($colis){
        //         $message[] = "l'utilisateur a des colis";
        //     }
        //     if($_SESSION['user']->id_utilisateur == $_GET['id'] && count($message) == 0){
        //         //supprimer l'utilisateur et 
        //     }
        //     if(count($messages) > 0){
        //         $query = $con->prepare("SELECT (photo) FROM utilisateur WHERE id_utilisateur = :ID");
        //     if($query->execute(["ID" => $_GET['id']])){
        //         $utilisateur = $query->fetch(PDO::FETCH_OBJ);
        //         unlink("user_images/".$utilisateur->photo);
        //     }
        //     $query = $con->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :ID");
        //     if ($query->execute(["ID"=>$_GET['id']])) {
        //         header("Location:utilisateur.php", true);
        //         exit();
        //     }
        //     }
        // }
        $query = $con->prepare("SELECT (photo) FROM utilisateur WHERE id_utilisateur = :ID");
        if($query->execute(["ID" => $_GET['id']])){
            $utilisateur = $query->fetch(PDO::FETCH_OBJ);
            unlink("user_images/".$utilisateur->photo);
        }
        $query = $con->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :ID");
        if ($query->execute(["ID"=>$_GET['id']])) {
            header("Location:utilisateur.php", true);
            exit();
        }

}

    //pagination
define("PER_PAGE", 20);

$query = $con->prepare("SELECT COUNT(id_utilisateur) as count FROM utilisateur");

$query->execute();

$usersCount = (int) $query->fetch(PDO::FETCH_OBJ)->count;

$sortable  = [ 'nom', 'prenom', 'adress_mail'];


$stm = "SELECT * FROM utilisateur";
$params = [];


// if(!empty($_GET['ville'])){
//     $stm .= " WHERE city LIKE  :VL";
//     $params["VL"] = '%' .$_GET['ville']. '%';
    
// }

//Organisation

if(!empty($_GET['sort']) && in_array($_GET['sort'], $sortable)){
    $dir = $_GET['dir'] ?? "asc";
    if(!in_array($dir, ['asc', 'des'])){
        $dir = 'asc';
    }
    $stm .= "ORDER BY ";
}

if(isset($_GET['search']) && !empty($_GET['textSearch'])){
    $stm .= " WHERE ".$_GET['field']." LIKE :text";
    $query = $con->prepare("SELECT COUNT(id_utilisateur) as count FROM utilisateur  WHERE ".$_GET['field']." = :text");
    if($query->execute(["text"=>$_GET['textSearch']]))
        $usersCount = $query->fetch(PDO::FETCH_OBJ)->count;
    $params["text"] = "%".$_GET["textSearch"]."%";
}

//Pagination
$page = (int)($_GET['p'] ?? 1);

$offset = ($page - 1) * PER_PAGE;

$searchFields = ["Nom"=>"Nom", "Prenom"=>"prenom", "Adress Email"=>"mail"];


$stm .= " LIMIT ".PER_PAGE." OFFSET $offset";

$query = $con->prepare($stm);

$query->execute($params);



var_dump($params);

$utilisateurs = $query->fetchAll(PDO::FETCH_OBJ);


$pages = ceil($usersCount/PER_PAGE);


    
    // $query = $con->prepare("SELECT id_utilisateur id, Nom, prenom, mail, photo FROM utilisateur");
    // if ($query->execute()) {
    //     $utilisateurs = $query->fetchAll(PDO::FETCH_OBJ);
    // }


   


        //Ajouter action
    
    if(isset($_POST['cree'])){
        $query = $con->prepare("INSERT INTO utilisateur (id_utilisateur) values (default)");
        if($query->execute()){
            $id = $con->lastInsertId();
            header("Location:utilisateur-edit.php?id=".$id);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php') ?>
<body>

<!-- confirmation script -->
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('êtes-vous sûr de supprimer cet Utilisateur ?');
}
</script>


<?php require('partials/header.php') ?>
    
    <div class="container">
    <main>
         <div class="container-fluid px-4">
             
             
             <div class="card mb-4">
                 <div class="card-header ">
                     <i class="fas fa-table me-1"></i>
                     Liste Des Utilisateurs 
                     <form  method="post">
                         <button type="submit" name="cree" style="margin-top: 10px; margin-bottom: 10px;" class="justify-content-left btn btn-success">Ajouter Utilisateur</button>
                 </form>


                 <form class="form-inline row" > 
                    <label  class="col-auto mt-2">Recherche par</label>
                 <select style="width: 150px; margin-right: 20px;" name="field" class="col-auto mb-2">
                    <?php
                    foreach ($searchFields as $key => $value) {
                        echo "<option value='$value'>$key</option>";
                    }
                    ?>
                 </select>
                 <input type="text" style="width: 350px; margin-right: 12px; height: 39px;" class="form-control col-auto" id="exampleInputEmail1" name="textSearch" aria-describedby="emailHelp" placeholder="Rechercher">
                 <button name="search" type="submit" class="btn btn-primary mb-2 col-auto">Rechercher</button>
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
                                            <a href="utilisateur-edit.php?id='.$utilisateur->id_utilisateur.'" title="Modifier"><img src="../images/icons8-edit-32.png" ></a>
                                            <a onclick="return checkDelete()" href="utilisateur.php?id='.$utilisateur->id_utilisateur.'" title="Supprimer"><img src="../images/icons8-delete-30.png" alt="DELETE"></a>
                                            
                                            </th>';
                                        
                                        
                                        echo "</tr>";
                                        }?>
                                        
                                    </tbody>
                                    
                                </table>
                                <?php if($pages > 1 && $page > 1): ?>
                                    <a href="utilisateur.php?<?= URLHelper::withParam("p", $page - 1); ?>" class="btn btn-primary">Page Précedent</a>
                                <?php endif ?>
                                <?php if($pages > 1 && $page < $pages): ?>
                                    <a href="utilisateur.php?<?= URLHelper::withParam("p", $page + 1); ?>" class="btn btn-primary">Page Suivant</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </main>
                <a href="" onclick="script:confirm('Ehllo world')">click</a>

<?php require('partials/scripts.php') ?>
</body>
</html>