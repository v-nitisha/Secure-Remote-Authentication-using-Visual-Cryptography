<script src="../javascripts/dropzone.js"></script>
<link href="../stylesheets/dropzone.css" rel="stylesheet" media="all" type="text/css" />

<?php   

require_once("../includes/veri_functions.php");


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


?>

