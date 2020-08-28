<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php //confirmLoggedIn(); ?>
<?php // Page processes deletion on database ?>


<?php
  $currentSubject = findSubjectById($_GET["subject"]);
  if(!$currentSubject) {
    // Since this is a edit subject page, you shouldnt be here if subject id doesnt exist
    redirectTo("manage_content.php");

  }

    $id = $currentSubject["id"];
    $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1;";
    $result = mysqli_query($connection,$query);

    if($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Delete successful.";
      redirectTo("manage_content.php");
    } else {
      $_SESSIONS["message"] = "Subject deletion failed.";
      redirectTo("manage_content.php?subject={$id}");
    }

 ?>
