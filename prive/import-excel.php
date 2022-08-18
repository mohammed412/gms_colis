<?php
require '../vendor/autoload.php';
require "../db/connection.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_POST['import'])){
    if(isset($_FILES['excel']['name'])){

        $reader =   \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['excel']['tmp_name']);
        $data = $reader->getActiveSheet();
        $data = $data->toArray();
        $query ="";
        $ville = "";
        for ($i=1; $i < count($data); $i++) {
          for ($j=0; $j < count($data[$i]); $j++) { 
            $query = $con
            $query = $con->prepare("INSERT INTO colis(id_colis, numero_suivi, code_destinataire	,nom_destinataire, adresse_destinataire
            ,id_ville, numero_commande, montant, centre_id, date, tel) VALUES (default, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            echo $data[$i][$j]."     ";
          }
          echo "<br>";
        }
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
    return confirm('êtes-vous sûr de supprimer cet statut ?');
}
</script>


<?php require('partials/header.php') ?>
    
    <div class="container">
    


                 <form method="POST" class="form-inline row" style="margin-top: 300px;" enctype="multipart/form-data"> 
                 <label  class="form-label" for="customFile">Importer Votre Fichier Excel</label>
                 <div class="row">
                <input style="width: 90%; margin-right: 10px;" type="file" class="form-control col-auto" id="customFile" name="excel"/>
                <button name="import" class="fom-control col-auto btn btn-primary">Importer</button>
                </div>
                </form>
                 
    </div>
<?php require('partials/scripts.php') ?>
</body>
</html>