<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/functions.php") ?>


<?php
  // v1: Simple logout
  // Make sure session started
  //$_SESSION["admin_id"] = null;
  //$_SESSION["username"] = null;
  //redirectTo("login.php");
 ?>

 <?php
   // v2: Destroy session
   // Total removal of session
    session_start();
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    redirectTo("login.php");
  ?>
