<?php // Users should only access this page when redirected by veri_init.php ?>



<?php require_once  ("../includes/BULLETPROOF/bulletproof.php") ?>
<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php include("../includes/layouts/admin_header.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>

<?php

  if($_SESSION['veri_stage'] == 1) {
     // making sure this page was last accessed from veri_init.php
    // only way veri stage is 1 if last page was veri_init.php'
    // Set it to 2 now that we are in upload stage.
    $_SESSION['veri_stage'] = 2;

  } else if($_SESSION['veri_stage'] == 2) {


    if(isset($_POST["submit"])) {
      $captcha_path = 'vc/tmp';

      $image = new Bulletproof\Image($_FILES);

      if($image["file"]){

        $image->setName($_SESSION['admin_id'] . "_uploaded")
              ->setMime(["png"])
              ->setLocation($captcha_path);

        $upload = $image->upload();

        if($upload){
          redirectTo("veri_prompt.php");
          //echo $upload->getFullPath(); // uploads/cat.gif
        }else{
          $_SESSION["message"] = $image->getError();
          //echo $image->getError();
        }
      }
    } else {
      // If user end up here, means he tried to refresh the page.
      // No action needed for now
    }



  } else {
      // if not stage 1, means user accessed this page illegally ( meaning not redirected from veri_init.php)
      // redirect out of here
      resetChallengeVariables();
      redirectTo("admin.php");
  }

 ?>



<link rel="stylesheet" href="../stylesheets/main.css">


<div id="main">

    &nbsp;

  <div id="page">
      <h1 class="text-center">Accessing Sensitive Page !</h1>
      <br/><br/>
      <p class="text-center"> The page, <b><?php echo $_SESSION['veri_page'] ?></b> , you are trying to access contains sensitive functions. <br/>
        We have sent a one-time share file to your email : <b><?php echo $_SESSION['email'] ?></b> </br>
        We require you to confirm your identity by uploading the file that has been sent to your email..</p>
      <br>
      <div style="width: 500px; margin: auto;" >
      <?php echo message(); ?>
      </div>
      <form post="veri_upload.php" style="width: 500px; margin: auto;" method="POST" enctype="multipart/form-data">
      
      <div class="custom-file"> 
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
        <input type="file" name="file" class="custom-file-input" id="customFile" accept="image/*"/>
        <label class="custom-file-label" for="customFile"></label>
        </div> 
       <input class="btn btn-success" name="submit" type="submit" value="Upload"/> 

      </form>





  </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


<script type="text/javascript">

$('.custom-file-input').on('change', function() { 
   let fileName = $(this).val().split('\\').pop(); 
   $(this).next('.custom-file-label').addClass("selected").html(fileName); 
});
</script>


<?php include("../includes/layouts/admin_footer.php") ?>
