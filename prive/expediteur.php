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
    if(isset($_GET['id'])){
        $query = $con->prepare("DELETE FROM expediteur WHERE id_Expediteur = :ID");
        if ($query->execute(["ID"=>$_GET['id']])) {
            header("Location:expediteur.php", true);
            exit();
        }

}

    //pagination
define("PER_PAGE", 20);

$query = $con->prepare("SELECT COUNT(id_Expediteur) as count FROM expediteur");

$query->execute();

$usersCount = (int) $query->fetch(PDO::FETCH_OBJ)->count;

$stm = "SELECT * FROM expediteur";
$params = [];


// if(!empty($_GET['ville'])){
//     $stm .= " WHERE city LIKE  :VL";
//     $params["VL"] = '%' .$_GET['ville']. '%';
    
// }


if(isset($_GET['search']) && !empty($_GET['textSearch'])){
    $stm .= " WHERE ".$_GET['field']." LIKE :text";
    $query = $con->prepare("SELECT COUNT(id_Expediteur) as count FROM expediteur  WHERE ".$_GET['field']." = :text");
    if($query->execute(["text"=>$_GET['textSearch']]))
        $usersCount = $query->fetch(PDO::FETCH_OBJ)->count;
    $params["text"] = "%".$_GET["textSearch"]."%";
}

//Pagination
$page = (int)($_GET['p'] ?? 1);

$offset = ($page - 1) * PER_PAGE;

$searchFields = ["Nom"=>"Nom",  "Adress Email"=>"mail"];


$stm .= " LIMIT ".PER_PAGE." OFFSET $offset";

$query = $con->prepare($stm);

$query->execute($params);




$expediteurs = $query->fetchAll(PDO::FETCH_OBJ);


$pages = ceil($usersCount/PER_PAGE);


    
    // $query = $con->prepare("SELECT id_Expediteur id, Nom, prenom, mail, photo FROM expediteur");
    // if ($query->execute()) {
    //     $expediteurs = $query->fetchAll(PDO::FETCH_OBJ);
    // }


   


        //Ajouter action
    
    if(isset($_POST['cree'])){
        $query = $con->prepare("INSERT INTO expediteur (id_Expediteur) values (default)");
        if($query->execute()){
            $id = $con->lastInsertId();
            header("Location:expediteur-edit.php?id=".$id);
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
    return confirm('êtes-vous sûr de supprimer cet expediteur ?');
}
</script>


<?php require('partials/header.php') ?>
    
    <div class="container">
    <main>
         <div class="container-fluid px-4">
             
             
             <div class="card mb-4">
                 <div class="card-header ">
                     <i class="fas fa-table me-1"></i>
                     Liste Des expediteurs 
                     <form  method="post">
                         <button type="submit" name="cree" style="margin-top: 10px; margin-bottom: 10px;" class="justify-content-left btn btn-success">Ajouter expediteur</button>
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
                                        
                                        <th>Nom</th>
                                            <th>Adresse Mail</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($expediteurs as $expediteur){
                                        echo "<tr>";
                                            echo "<td>$expediteur->Nom</td>";
                                            echo "<td>$expediteur->mail</td>";
                                            
                                            echo '<th>
                                            <a href="expediteur-edit.php?id='.$expediteur->id_Expediteur.'" title="Modifier"><img src="../images/icons8-edit-32.png" ></a>
                                            <a onclick="return checkDelete()" href="expediteur.php?id='.$expediteur->id_Expediteur.'" title="Supprimer"><img src="../images/icons8-delete-30.png" alt="DELETE"></a>
                                            
                                            </th>';
                                        
                                        
                                        echo "</tr>";
                                        }?>
                                        
                                    </tbody>
                                    
                                </table>
                                <?php if($pages > 1 && $page > 1): ?>
                                    <a href="expediteur.php?<?= URLHelper::withParam("p", $page - 1); ?>" class="btn btn-primary">Page Précedent</a>
                                <?php endif ?>
                                <?php if($pages > 1 && $page < $pages): ?>
                                    <a href="expediteur.php?<?= URLHelper::withParam("p", $page + 1); ?>" class="btn btn-primary">Page Suivant</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </main>
                

<?php require('partials/scripts.php') ?>
</body>
</html>