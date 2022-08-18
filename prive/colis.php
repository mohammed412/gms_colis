<?php

    session_start();
    
  //   if(!isset($_SESSION['user'])){
  //     header('Location:../../login.php', true);
  // }

    require('../db/connection.php');

    require '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    

    $query = $con->prepare("SELECT date, numero_suivi, nom_destinataire, numero_commande, u.Nom Livreure, ex.nom Expediteur, vl.libelle vl_lib, stat.libelle stat_lib
    FROM colis 
    JOIN utilisateur u ON u.id_utilisateur = colis.id_utilisateur 
    JOIN expediteur ex ON ex.id_Expediteur = colis.id_utilisateur
    JOIN ville vl ON vl.id_ville = colis.id_ville
    JOIN statut stat ON stat.id_statut = colis.id_statut
    ");


    if($query->execute()){
        $colis = $query->fetchAll(PDO::FETCH_OBJ);
    }

    if(isset($_POST['upload'])){
        echo "Hello world";
        // if(isset($_FILES['excel']['name'])){
        //     echo "hello wporld";

        //     $reader =   \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['excel']['tmp_name']);
        //     $data = $reader->getActiveSheet();
        //     $data = $data->toArray();
        //     // for ($i=1; $i < count($data); $i++) {
        //     //   for ($j=0; $j < count($data[$i]); $j++) { 
        //     //     // $query = "INSERT INTO colis(id_colis, numero_suivi, code_destinataire	,nom_destinataire, id_ville, ) VALUES ";
        //     //   }
              
        //     // }
        // }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php') ?>
<body>
    <?php require('partials/header.php')?>

    

<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Table Des Colis <button style="float: right;" class="justify-content-left btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Ajouter Colis</button>
                            </div>

                            <form method="POST" style="margin: 15px;" enctype="multipart/form-data">
                                <div class="form-group" >
                                    <label for="exampleFormControlFile1">Entre Votre Fechier pour uploder</label>
                                    <input type="file" name="excel" class="form-group form-control-file" id="exampleFormControlFile1"><br>
                                    <button type="submit" name="upload" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                                
                            <div class="card-body">
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th>Date</th>
                                            <th>Numero de suivi</th>
                                            <th>Expediteur</th>
                                            <th>Destinataire</th>
                                            <th>N° Commande</th>
                                            <th>Livreure</th>
                                            <th>Ville</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <tr>
                                        <?php foreach($colis as $coli){
                                            echo "<td>$coli->date</td>";
                                            echo "<td>$coli->numero_suivi</td>";
                                            echo "<td>$coli->Expediteur</td>";
                                            echo "<td>$coli->nom_destinataire</td>";
                                            echo "<td>$coli->numero_commande</td>";
                                            echo "<td>$coli->Livreure</td>";
                                            echo "<td>$coli->stat_lib</td>";
                                            echo "<td>$coli->vl_lib</td>";
                                        }?>
                                        </tr>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                

<!--Modal Ajouter-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter une colis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="create.php">
  <!-- 2 column grid layout with text inputs for the first and last names -->
  <div class="row mb-4">
    <div class="col">
      <div class="form-outline">
        <input type="number" id="form6Example1" class="form-control" />
        <label class="form-label" for="form6Example1">Numero de suivi</label>
      </div>
    </div>
    <div class="col">
      <div class="form-outline">
        <input type="date" id="form6Example2" class="form-control" />
        <label class="form-label" for="form6Example2">Date</label>
      </div>
    </div>
  </div>

  <!-- Text input -->
  <div class="row mb-4">
    <div class="col">
  <div class="form-outline">
    <select  id="form6Example3" class="form-control">
        <?php
        $query = $con->prepare("SELECT id_Expediteur , Nom FROM expediteur ");
        if ($query->execute()) {
          $exps = $query->fetchAll(PDO::FETCH_OBJ);
          foreach($exps as $exp){
            echo '<option value="'.$exp->id_Expediteur.'">'.$exp->Nom.'</option>';
          }
        }
        ?>
    </select>
    <label class="form-label" for="form6Example3">Expediteur</label>
  </div>
</div>
<div class="col">
  <div class="form-outline ">
    <select  id="form6Example3" class="form-control">
        <?php
        $query = $con->prepare("SELECT * from utilisateur WHERE ")
        ?>
    </select>
    <label class="form-label" for="form6Example3">Livreure</label>
  </div>
  </div></div>
  <!-- Text input -->
  <div class="form-outline mb-4">
    <input type="text" id="form6Example4" class="form-control" />
    <label class="form-label" for="form6Example4">Destinataire</label>
  </div>

  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" id="form6Example5" class="form-control" />
    <label class="form-label" for="form6Example5">Numero de commande</label>
  </div>

  <div class="row mb-4">
    <div class="col">
  <div class="form-outline">
    <select name="statut"  id="form6Example3" class="form-control">

    </select>
    <label class="form-label" for="form6Example3">Statut</label>
  </div>
</div>
<div class="col">
  <div class="form-outline ">
    <select  id="form6Example3" class="form-control" name="ville">
        
    </select>
    <label class="form-label" for="form6Example3">Ville</label>
  </div>
  </div></div>

  <!-- Submit button -->
 <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>

                

    <?php require('partials/scripts.php') ?>
    
    
</body>


</html>





