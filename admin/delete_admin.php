<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/admin_functions.php"); ?>
<?php findSelectedAdmin(); ?>
<?php //confirmLoggedIn(); ?>
<?php
if(!isset($_GET["adminId"]) && !isset($_POST["submit"])) {
 $_SESSION["message"] = "No current admin selected.";
 redirectTo("manage_admins.php");
 }
?>



<?php

    $id = $currentAdmin["id"];
    $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1;";
    $result = mysqli_query($connection,$query);

    if($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Delete successful.";
      redirectTo("manage_admins.php");
    } else {
      $_SESSIONS["message"] = "Subject deletion failed.";
      redirectTo("manage_admins.php?adminId={$id}");
    }

 ?>


