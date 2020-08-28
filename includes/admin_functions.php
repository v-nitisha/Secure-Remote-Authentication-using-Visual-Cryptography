
<?php
require_once("functions.php");



// With obtained GET data , retrieves the row from ID
function findSelectedAdmin() {
  global $currentAdmin;
  if(isset($_GET["adminId"])) {
      $currentAdmin = findAdminById($_GET["adminId"]);
    }
}

// Old way to limit page based on fullPower variable in database
function fullPowerCheck() {
  if($_SESSION['fullpower'] != 1){
    $_SESSION["message"] = "You do not have full privilege to access this.";
    redirectTo("manage_content.php");
  }
}

// Find security question by ID
function findSecQuestionById($id){
  global $connection;
  $safeSecId = safeStringSql($id);


  $output = "SELECT question from security_questions";
  $output .= " WHERE id = {$safeSecId}";
  $output .= " LIMIT 1";
  $output .= ";";
  $secQuestionSet = mysqli_query($connection,$output);
  confirmQuery($secQuestionSet);
  if($oneSec = mysqli_fetch_assoc($secQuestionSet)){
    return $oneSec;
  } else {
    return null;
  }
}

// Find admin by ID
function findAdminById($id) {
  global $connection;
  $safeAdminId = safeStringSql($id);


  $output = "SELECT * from admins";
  $output .= " WHERE id = {$safeAdminId}";
  $output .= " LIMIT 1";
  $output .= ";";
  $adminSet = mysqli_query($connection,$output);
  confirmQuery($adminSet);
  if($oneAdmin = mysqli_fetch_assoc($adminSet)){
    return $oneAdmin;
  } else {
    return null;
  }
    return $adminSet;
}
// Find admin by user
function findAdminByUser($username) {
  global $connection;
  $safeUser = safeStringSql($username);


  $output = "SELECT * from admins";
  $output .= " WHERE username = '{$safeUser}'";
  $output .= " LIMIT 1";
  $output .= ";";
  $adminSet = mysqli_query($connection,$output);
  confirmQuery($adminSet);
  if($oneAdmin = mysqli_fetch_assoc($adminSet)){
    return $oneAdmin;
  } else {
    return null;
  }
}


// Retrieves all admin rows
// Used by manage_admins which list all current admins
function findAllAdmins() {
    global $connection;
    $output = "SELECT * from admins";
    $output .= ";";
    $adminSet = mysqli_query($connection,$output);
    confirmQuery($adminSet);
    return $adminSet;
}



// ====================================================
// Password Functions
// ====================================================

function generateSalt($length) {
  // MD5 returns 32char. Not 100% unique or random but enoguh for a salt
  $uniqueRandomString = md5(uniqid(mt_rand(), true));
  // Valid characters for salt
  $base64String = base64_encode($uniqueRandomString);
  // But not '+' which is considered valid in base64 encoding
  $modifiedBase64String = str_replace('+','.', $base64String);

  //Truncate string to correct length
  $salt = substr($modifiedBase64String,0,$length);
  return $salt;

}

// now builtin as password_hash()
function passwordEncrypt($password) {
    $hashFormat = "$2y$10$";
    $saltLength = 22;
    $salt = generateSalt($saltLength);
    $formatAndSalt = $hashFormat . $salt;
    $hash = crypt($password, $formatAndSalt);
    return $hash;
}

// now builtin as password_verify()
// - hashes submitted password , then compares with hash found in db
function passwordCheck($password,$existingHash) {
  $hash = crypt($password, $existingHash);
  if($hash == $existingHash) {
    return true;
  } else {
    return false;
  }
}

function attemptLogin($un,$pw) {
    $admin = findAdminByUser($un);
  if($admin) {
      // Admin found
      if(passwordCheck($pw,$admin["hashed_password"])) {
        // If password matches, returns the row of admin info
        return $admin;
      } else {
        // Found but password doesnt match
        return false;

      }
  } else {
      // Admin not found
      return false;

    }
}



 ?>
