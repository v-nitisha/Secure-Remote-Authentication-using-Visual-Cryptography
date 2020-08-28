
<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php include("../includes/layouts/admin_header.php") ?>

<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>

<?php
if(empty($_SESSION['veri_page'])==true){

  // Check if veri page is set, it can only be set if previous page was a page that requires token and redirected here.
  // See line 34 and 35
  redirectTo("admin.php");
}


?>
<?php $_SESSION['veri_stage'] = 1; ?>

<?php

  // 1. Generate challenge and the image
  generateChallenge();

  // 2. Call vc splitter and produce 2 shares
  // Share 1 : adminid_A.png [ User Share ]
  // Share 2 : adminid_B.png [ Server Share ]
  $captcha_path = 'vc/tmp/';
  $tmp_img_path = $captcha_path . $_SESSION['admin_id'] . ".png";


  $_SESSION['secLevel'] = getPageSecurityLevel($_SESSION["veri_page"]);

  if(getPageFastAuth($_SESSION["veri_page"])==true) {
    $_SESSION['fastAuth'] = "true";
  } else {
    $_SESSION['fastAuth'] = "false";
  }
  


  if( $_SESSION['secLevel'] == 1) {
    $output = shell_exec("C:\Python37\python.exe vc\\vc_split.py " . $tmp_img_path . " " . $_SESSION['admin_id'] . " " . escapeshellarg($captcha_path));
  } else if( $_SESSION['secLevel'] == 2 || $_SESSION['secLevel'] == 3){
    $output = shell_exec("C:\Python37\python.exe vc\\vc_split_3x3.py " . $tmp_img_path . " " . $_SESSION['admin_id'] . " " . escapeshellarg($captcha_path));
  }
  //echo $output;

  // 3. Email User Share

  if( $_SESSION['secLevel'] == 1){
  sendUserShare($_SESSION['email'],1);
  } else if( $_SESSION['secLevel'] == 2) {
    sendUserShare($_SESSION['email'],1);
    sendUserShare($_SESSION['email2'],2);
  } else if( $_SESSION['secLevel'] == 3) {
    $pageMaster = getPageMaster($_SESSION["veri_page"]);
    sendUserShare($_SESSION['email'],1);
    sendPageMaster($pageMaster,$_SESSION['username'],$_SESSION['email'],$_SESSION['veri_page']);

  }
  // 4. Clear traces of original challenge image
    // challenge image
    unlink($tmp_img_path);
    // user share image
    unlink($captcha_path . $_SESSION['admin_id'] . "_A.png");
    unlink($captcha_path . $_SESSION['admin_id'] . "_C.png");

    if($_SESSION['secLevel']==1) {
      redirectTo("veri_upload.php");
    }else if($_SESSION['secLevel']==2){
      redirectTo("veri_upload2.php");
    } else if($_SESSION['secLevel']==3){
      redirectTo("veri_upload3.php");
    }

 ?>




<?php include("../includes/layouts/admin_footer.php") ?>
