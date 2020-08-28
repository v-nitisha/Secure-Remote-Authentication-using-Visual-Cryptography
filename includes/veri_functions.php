<?php
// php mailer includes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer/src/Exception.php';
require '../includes/PHPMailer/src/PHPMailer.php';
require '../includes/PHPMailer/src/SMTP.php';

?>

<?php
// Retrieves all pages that require tokens from db
function getAllCriticalSections() {
    global $connection;
    $output = "SELECT * from critical_sections";
    $output .= ";";
    $pgSecSet = mysqli_query($connection,$output);
    confirmQuery($pgSecSet);
    return $pgSecSet;
}

// With obtained GET data , retrieves the row from ID
function findSelectedCritSect() {
  global $currentCritSec;
  if(isset($_GET["critSecId"])) {
      $currentCritSec = findCritSecById($_GET["critSecId"]);
    }
}
function findCritSecById($id) {
  global $connection;
  $safeCritSecId = safeStringSql($id);


  $output = "SELECT * from critical_sections";
  $output .= " WHERE id = {$safeCritSecId}";
  $output .= " LIMIT 1";
  $output .= ";";
  $critSectSet = mysqli_query($connection,$output);
  confirmQuery($critSectSet);
  if($oneCritSect = mysqli_fetch_assoc($critSectSet)){
    return $oneCritSect;
  } else {
    return null;
  }
    return $critSectSet;
}

function getPageSecurityLevel($pageName){

    global $connection;
    $safePageName = safeStringSql($pageName);

    $output = "SELECT security_level from critical_sections";
    $output .= " WHERE page_name = '{$safePageName}'";
    $output .= " LIMIT 1";
    $output .= ";";
    $pageSec = mysqli_query($connection,$output);
    confirmQuery($pageSec);
    if($pgSec = mysqli_fetch_assoc($pageSec)){
      foreach($pgSec as $key => $value){
        return $value;
      }
    } else {
      return null;
    }
}

function getPageMaster($pageName){

  global $connection;
  $safePageName = safeStringSql($pageName);

  $output = "SELECT page_master from critical_sections";
  $output .= " WHERE page_name = '{$safePageName}'";
  $output .= " LIMIT 1";
  $output .= ";";
  $pageMaster = mysqli_query($connection,$output);
  confirmQuery($pageMaster);
  if($pgMaster = mysqli_fetch_assoc($pageMaster)){
    foreach($pgMaster as $key => $value){
      return $value;
    }
  } else {
    return null;
  }
}


function getPageFastAuth($pageName){

  global $connection;
  $safePageName = safeStringSql($pageName);

  $output = "SELECT fast_auth from critical_sections";
  $output .= " WHERE page_name = '{$safePageName}'";
  $output .= " LIMIT 1";
  $output .= ";";
  $pageSec = mysqli_query($connection,$output);
  confirmQuery($pageSec);
  if($pgSec = mysqli_fetch_assoc($pageSec)){
    foreach($pgSec as $key => $value){
      return $value;
    }
  } else {
    return null;
  }
}


// Check if current page requires token
function checkPageRequireToken($pageName) {

  global $connection;
  $require = false;
  $set = getAllCriticalSections();

  while($pgSec = mysqli_fetch_assoc($set)){

  if($pgSec['page_name'] == $pageName){
    $require = true;
    break;
    }
  }

  return $require;
}

// Check if user has token for that page
// Only used after checking that a page needs a token
function checkUserHasToken($pageName){


  $session_token_name = $pageName . "_token";

  if($_SESSION[$session_token_name] == "allowed"){
    // Got token
    return true;
  } else {
    // No token
    return false;
  }

}

// Generate challenge strring and its image form
function generateChallenge(){

  // Image Dimensions
  $width = 110;
  $height = 50;

  // String length
  $challengeLength = 6;


  // Where temp server shares will be held
  $captcha_path = 'vc/tmp/';

  // Create folder if doesnt exist
  if (!file_exists($captcha_path)) {
    mkdir($captcha_path, 0777, true);
  }

  // temp userid
  $_SESSION['admin_id'] = 1;

  // Get font
  $parent = dirname(__DIR__, 1);
  $font = $parent . "\includes\\fonts\consola.ttf";

 

  echo $font;
  // ====================================================

  echo "Generating challenge ..<br/>";
  // 1. Generate blank image
  $image = imagecreate($width, $height);

  // 2. Fill blank with white color
  $bgCol = imagecolorallocate($image, 255, 255, 255);


  // ====================================================================================
  // 4. Generate random string
  $letters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
  $len = strlen($letters);
  $letter = $letters[rand(0, $len-1)];
  $text_color = imagecolorallocate($image, 0,0,0);

  $challengeWord = "";

  for ($i = 0; $i< $challengeLength;$i++) {
    $letter = $letters[rand(0, $len-1)];
    // bool imagestring ( resource $image , int $font , int $x , int $y , string $string , int $color )
    //imagestring($image, 5,  20+($i*30), 20, $letter, $text_color);


    imagettftext($image,20,0,10+($i*15), 30,$text_color,$font,$letter);

    $challengeWord.=$letter;
  }

  $hashedChallenge = password_hash($challengeWord, PASSWORD_DEFAULT);

  // Stores the challenge word into session_start
  // TBD : Store hashed version in database
  //$_SESSION['challenge'] = $challengeWord;
  global $connection;
  //Query
  $query = "UPDATE admins set";
  $query .= " hashed_challenge = '{$hashedChallenge}' ";
  $query .= " WHERE id= {$_SESSION['admin_id']}";
  $query .= " LIMIT 1;";
  $result = mysqli_query($connection,$query);

  // Save location
  $tmp_img_path = $captcha_path . $_SESSION['admin_id'] . ".png";
  // Saves image
  imagepng($image, $tmp_img_path);

  imagedestroy($image);

  //echo "Challenge word into CAPTCHA form : </br>";
  //echo "<img src=\"" . $tmp_img_path . "\">";
  //echo "<br/>";


  //echo "<hr/>";



}

// Get user's challenge from database
function getUserChallenge(){
  global $connection;
  $safeUser = safeStringSql($_SESSION['admin_id']);


  $output = "SELECT hashed_challenge from admins";
  $output .= " WHERE id = '{$safeUser}'";
  $output .= " LIMIT 1";
  $output .= ";";
  $adminSet = mysqli_query($connection,$output);
  confirmQuery($adminSet);



  if($oneChallenge = mysqli_fetch_assoc($adminSet)){
      foreach($oneChallenge as $key => $value){
        return $value;
      }
  } else {
    return null;
  }
}

// Sends the user share to their email
function sendUserShare($email,$share_number){
  $recipient_email = $email;
  $recipient_name = "Users";
  $captcha_path = "vc/tmp/";

  if($share_number==1){
      $file_name = $_SESSION['admin_id'] . "_A.png";
  }else if($share_number==2) {
    $file_name = $_SESSION['admin_id'] . "_C.png";
  }
  $new_name = "user_share" . $share_number . ".png";
  //$bcc_admin = "";


  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'ss18.4b@gmail.com';                 // SMTP username
      $mail->Password = 'testin123';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('ss18.4b@gmail.com', 'VC FYP Team');
      $mail->addAddress($recipient_email, $recipient_name);     // Add a recipient
      //$mail->addCC('cc@example.com');
      //$mail->addBCC('bcc@example.com');

      //Attachments
      $mail->addAttachment($captcha_path . $file_name, $new_name);         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'User Share ';
      $mail->Body    = 'This is your requested share. Upload when requested. Please do not share it with anyone else';
      $mail->AltBody = 'This is your requested share. Upload when requested. Please do not share it with anyone else';

      $mail->send();
      //echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
}

// Send 2nd share to page master
function sendPageMaster($email,$requester,$requester_email,$page){

  $recipient_email = $email;
  $recipient_name = "Users";
  $captcha_path = "vc/tmp/";


    $file_name = $_SESSION['admin_id'] . "_C.png";
  
  $new_name = "user_share2.png";
  //$bcc_admin = "";


  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'ss18.4b@gmail.com';                 // SMTP username
      $mail->Password = 'testin123';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('ss18.4b@gmail.com', 'VC FYP Team');
      $mail->addAddress($recipient_email, $recipient_name);     // Add a recipient
      //$mail->addCC('cc@example.com');
      //$mail->addBCC('bcc@example.com');

      //Attachments
      $mail->addAttachment($captcha_path . $file_name, $new_name);         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Request for Access from ' . $requester;
      $mail->Body    = 'The user ' . $requester . ' is requesting access to ' . $page . '. If you approve this request, please forward the share file to his email at : ' . $requester_email;
      $mail->AltBody = 'The user ' . $requester . ' is requesting access to ' . $page . '. If you approve this request, please forward the share file to his email at : ' . $requester_email;

      $mail->send();
      //echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }

}
// ==============================================================
// Garbage Clearance Functions
// ==============================================================

// Resets user's challenge inside database to empty field
function resetChallengeInDb(){
  global $connection;
    $safeUser = safeStringSql($_SESSION['admin_id']);

  $query = "UPDATE admins SET ";
  $query .= " hashed_challenge = ''";
  $query .= " WHERE id = {$safeUser}";
  $query .= " LIMIT 1 ;";
  $result = mysqli_query($connection,$query);
}

// Delete all traces of challenge images based on the user.
function clearChallengeImages(){
  $share_paths = "vc/tmp/" . $_SESSION['admin_id'];

  if (file_exists($share_paths . "_A.png")) {
      unlink($share_paths . "_A.png");
  }

  if (file_exists($share_paths . "_B.png")) {
    unlink($share_paths . "_B.png");
  }

  if (file_exists($share_paths . "_uploaded.png")) {
    unlink($share_paths . "_uploaded.png");
  }

  if (file_exists($share_paths . "_uploaded1.png")) {
    unlink($share_paths . "_uploaded1.png");
  }

  if (file_exists($share_paths . "_uploaded2.png")) {
    unlink($share_paths . "_uploaded2.png");
  }
  if (file_exists($share_paths . "_JOINED.png")) {
    unlink($share_paths . "_JOINED.png");
  }
}

// Resets all challenge variables
function resetChallengeVariables(){
  $_SESSION['veri_page'] = "";
  $_SESSION['veri_stage'] = 0;
  $_SESSION['secLevel'] = 0;
  $_SESSION['fastAuth'] = "";
  resetChallengeInDb();
}

// Resets veri stage session variable if user leaves any of the veri pages
function resetVeriStage(){
  // Add pages that are verification pages here
  $pages = array("veri_upload.php","veri_upload2.php","veri_upload3.php", "veri_prompt.php", "veri_init.php");

  $currentPageName = getCurrentPageName();
  $pageCount = count($pages);
  $isVeriPage = false;
  for($i=0;$i<$pageCount;$i++){
      if($currentPageName == $pages[i]){
        $isVeriPage = true;
        break;
      }
  }

  // If the current page is not any of the veri page, reset veri stage.
  if($isVeriPage != true) {
      $_SESSION['veri_stage'] = 0;
  }
}

 ?>
