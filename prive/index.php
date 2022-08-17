<?php

session_start();
if (!$_SESSION['user']) {
    header("Location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php')?>
<body>
    <?php require('partials/header.php')?>
    <h1>Welcome in Main page</h1>
    <?php require('partials/scripts.php')?>
</body>
</html>