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
    if(!empty($_GET['id'])){
        
        
        $query = $con->prepare("DELETE FROM remarques WHERE id_remarques = :ID");
        if ($query->execute(["ID"=>$_GET['id']])) {
            header("Location:remarque.php", true);
            exit();
        }

}

    //pagination
define("PER_PAGE", 20);

$query = $con->prepare("SELECT COUNT(id_remarques) as count FROM remarques");

$query->execute();

$usersCount = (int) $query->fetch(PDO::FETCH_OBJ)->count;

$sortable  = [ 'libelle'];


$stm = "SELECT * FROM remarques";
$params = [];




//Organisation



if(isset($_GET['search']) && !empty($_GET['textSearch'])){
    $stm .= " WHERE libelle LIKE :text";
    $query = $con->prepare("SELECT COUNT(id_remarques) as count FROM remarques  WHERE libelle = :text");
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

$remarques = $query->fetchAll(PDO::FETCH_OBJ);


$pages = ceil($usersCount/PER_PAGE);


    
        //Ajouter action
    
    if(isset($_POST['cree'])){
        $query = $con->prepare("INSERT INTO remarques (id_remarques) values (default)");
        if($query->execute()){
            $id = $con->lastInsertId();
            header("Location:remarque-edit.php?id=".$id);
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
    return confirm('êtes-vous sûr de supprimer cet remarque ?');
}
</script>


<?php require('partials/header.php') ?>
    
    <div class="container">
    <main>
         <div class="container-fluid px-4">
             
             
             <div class="card mb-4">
                 <div class="card-header ">
                     <i class="fas fa-table me-1"></i>
                     Liste Des remarques 
                     <form  method="post">
                         <button type="submit" name="cree" style="margin-top: 10px; margin-bottom: 10px;" class="justify-content-left btn btn-success">Ajouter remarque</button>
                 </form>


                 <form class="form-inline row" > 
                 <input type="text" style="width: 350px; margin-right: 12px; height: 39px;" class="form-control col-auto" id="exampleInputEmail1" name="textSearch" aria-describedby="emailHelp" placeholder="Rechercher">
                 <button name="search" type="submit" class="btn btn-primary mb-2 col-auto">Rechercher</button>
                </form>
                 </div>

                 
                     
                            <div class="card-body">
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th>Libelle</th>
                                           
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($remarques as $remarque){
                                        echo "<tr>";
                                            echo "<td>$remarque->libelle</td>";
                                           
                                            
                                            
                                            echo '<th>
                                            <a href="remarque-edit.php?id='.$remarque->id_remarques.'" title="Modifier"><img src="../images/icons8-edit-32.png" ></a>
                                            <a onclick="return checkDelete()" href="remarque.php?id='.$remarque->id_remarques.'" title="Supprimer"><img src="../images/icons8-delete-30.png" alt="DELETE"></a>
                                            
                                            </th>';
                                        
                                        
                                        echo "</tr>";
                                        }?>
                                        
                                    </tbody>
                                    
                                </table>
                                <?php if($pages > 1 && $page > 1): ?>
                                    <a href="remarque.php?<?= URLHelper::withParam("p", $page - 1); ?>" class="btn btn-primary">Page Précedent</a>
                                <?php endif ?>
                                <?php if($pages > 1 && $page < $pages): ?>
                                    <a href="remarque.php?<?= URLHelper::withParam("p", $page + 1); ?>" class="btn btn-primary">Page Suivant</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </main>

<?php require('partials/scripts.php') ?>
</body>
</html>