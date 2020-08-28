<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/admin_functions.php"); ?>
<?php require_once("../includes/veri_functions.php") ?>
<?php findSelectedCritSect() ?>
<?php
if(!isset($_GET["critSecId"]) && !isset($_POST["submit"])) {
 $_SESSION["message"] = "No current critical section selected.";
 redirectTo("manage_critical_sections.php");
 }
?>


<?php

    $id = $currentCritSec["id"];
    $query = "DELETE FROM critical_sections WHERE id = {$id} LIMIT 1;";
    $result = mysqli_query($connection,$query);

    if($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Delete successful.";
      redirectTo("manage_critical_sections.php");
    } else {
      $_SESSIONS["message"] = "Subject deletion failed.";
      redirectTo("manage_critical_sections.php");
    }

 ?>
