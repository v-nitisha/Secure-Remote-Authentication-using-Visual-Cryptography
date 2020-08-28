<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php findSelectedAdmin() ?>
<?php //confirmLoggedIn(); ?>

<?php
  if(!isset($_GET["adminId"]) && !isset($_POST["submit"])) {
   $_SESSION["message"] = "No current admin selected.";
   redirectTo("manage_admins.php");
 }
?>


<?php


  if(isset($_POST["submit"])) {

      $requiredFields = array("username","password");
      validatePresence($requiredFields);
      $fieldMaxLength = array("username" => 24);
      getMaxLength($fieldMaxLength);

      if(empty($errors)) {

        $submittedId = (int)$currentAdmin["id"];
        $submittedUsername = safeStringSql($_POST["username"]);
        $hashedPassword = passwordEncrypt(safeStringSql($_POST["password"]));



        $query = "UPDATE admins SET ";
        $query .= " username = '{$submittedUsername}' ,";
        $query .= " hashed_password = '{$hashedPassword} '";
        $query .= " WHERE id = {$submittedId}";
        $query .= " LIMIT 1 ;";
        $result = mysqli_query($connection,$query);

          if($result) {
            // Success
            $_SESSION["message"] = "Admin successfully updated.";
            if(mysqli_affected_rows($connection) == 0) {
              $_SESSION["message"] .= " No changes made." . mysqli_affected_rows($connection);
            }
            redirectTo("manage_admins.php");
          } else {
            $_SESSION["message"] = "Admin update failed: " . mysqli_error($connection);
            redirectTo("edit_admin.php");
          }
      } // end of If no validation errors
  } else {

  }// end of after submitted
?>




<?php include("../includes/layouts/admin_header.php") ?>
<link rel="stylesheet" href="../stylesheets/main.css">

  <div id="main">
      <div id="navigation">
        &nbsp;
      </div>
      <div id="page">
          <h2 class="text-center">Admin Menu : Update</h2>

          <?php echo formErrors($errors); ?>
          <?php echo message(); ?>
          <form style="width: 500px; margin: auto;" action="edit_admin.php?adminId=<?php echo $currentAdmin["id"] ?>" method="post">
          <p>
            Username: <input class="form-control" type="text" name="username" value="<?php echo $currentAdmin["username"]; ?>">
          </p>
          <p>
            New Password:  <input class="form-control" type="password" name="password" value="">
          </p>
          <input class="btn btn-success center-block"  type="submit" name="submit" value="Login">
          <a class="btn btn-light text-secondary" href="manage_admins.php">Cancel</a>

          </form>

      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
