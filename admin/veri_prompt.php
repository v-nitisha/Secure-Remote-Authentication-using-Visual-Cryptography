<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php include("../includes/layouts/admin_header.php") ?>

<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>

<?php


  if($_SESSION['veri_stage'] == 2) {
    // only way veri stage is 2 if last page was veri_upload.php'
    // Set it to 2 now that we are in prompt5 stage.
    $_SESSION['veri_stage'] = 3;
  } else if($_SESSION['veri_stage'] == 3) {

    // If challenge submitted
    if(isset($_POST["submit"])) {

      // Get challenge from db
       $challenge = getUserChallenge();


       // Check user input is the correct challenge
       //if($_POST["userInput"] == $challenge){
        if(password_verify($_POST["userInput"],$challenge)){

         // correct challenge
         $_SESSION["message"] = "Access Granted.";
         // redirect to the requested page
         // Set the token
         $session_token_name = $_SESSION["veri_page"] . "_token";
         $_SESSION[$session_token_name] = "allowed";

         // Clean up
         resetChallengeInDb();
         clearChallengeImages();
         redirectTo($_SESSION["veri_page"]);






       } else {
         // Wrong challenge
         $_SESSION["message"] = "Access Denied. Incorrect Challenge";
         resetChallengeVariables();
         clearChallengeImages();
         redirectTo("admin.php");
       }


    }
  } else {
    // if not stage 2, means user accessed this page illegally ( meaning not redirected from veri_upload.php)
    // redirect out of hebre
    resetChallengeVariables();
    redirectTo("admin.php");
  }

 ?>



<?php



$captcha_path = 'vc/tmp/';

// User Share Share
if ($_SESSION['secLevel']==1) {
  // User Share
    $share1 = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_uploaded.png");
    // Server Share
    $share2 = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_B.png");

  // Combine
  $output = shell_exec("C:\Python37\python.exe vc\\vc_combine.py " . $share1 . " " . $share2 . " " .  $_SESSION['admin_id'] . " " . escapeshellarg($captcha_path));


} else if($_SESSION['secLevel']==2 || $_SESSION['secLevel']==3){

  // User Share 1
  $share1 = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_uploaded1.png");
  // Server Share
  $share2 = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_B.png");
  // User Share 2
  $share3 = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_uploaded2.png");

  // Combine
  $output = shell_exec("C:\Python37\python.exe vc\\vc_combine_3x3.py " . $share1 . " " . $share2 . " " . $share3 . " " .  $_SESSION['admin_id'] . " " . escapeshellarg($captcha_path));

}


// If fast auth is on, activate image recognition script to skip this step.
if($_SESSION['fastAuth']=='true'){

  $combinedImage = escapeshellarg($captcha_path . $_SESSION['admin_id'] . "_JOINED.png");


  $readString = shell_exec("C:\Python37\python.exe vc\\image_reader.py " .  $combinedImage);

  $readString = trim($readString);
  $challenge = getUserChallenge();

        if(password_verify($readString,$challenge)){

         // correct challenge
         $_SESSION["message"] = "Access Granted.";
         // redirect to the requested page
         // Set the token
         $session_token_name = $_SESSION["veri_page"] . "_token";
         $_SESSION[$session_token_name] = "allowed";

         // Clean up
         resetChallengeInDb();
         clearChallengeImages();
         redirectTo($_SESSION["veri_page"]);


       } else {
         // Wrong challenge
         $_SESSION["message"] = "Access Denied. Incorrect Challenge. (" . $readString . ")" ;
         resetChallengeVariables();
         //clearChallengeImages();
         redirectTo("admin.php");
       }


}


?>

<link rel="stylesheet" href="../stylesheets/main.css">


<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">

<div class="text-center">
<h1 class"text-center>Enter the challenge displayed !</h2>
<br/>
        <b class="text-danger">NOTE: </b><br/>
        <ol class="center text-danger">
          <li>If the picture below does not appear readable, you have uploaded the wrong share file.</li>
          <li>The challenge string is case sensitive.</li>
        </ol>
        <span class="image-container">
         <img src="<?php echo $captcha_path . $_SESSION['admin_id'] . "_JOINED.png";?> ">
        </span>
</div>

   </br>
         <div class="captcha">
           <form action="veri_prompt.php" method="post" style="width: 500px; margin: auto;" >
             Enter challenge : <input class="form-control" type="text" name="userInput"></br>
             <input type="submit" class="btn btn-info" name="submit" value="Confirm Challenge">
           </form>
         </div>



  </div>
</div>




<?php include("../includes/layouts/admin_footer.php") ?>
