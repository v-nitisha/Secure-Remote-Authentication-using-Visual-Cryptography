<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>
<?php findSelectedCritSect() ?>
<?php //confirmLoggedIn(); ?>

<?php
  if(!isset($_GET["critSecId"]) && !isset($_POST["submit"])) {
   $_SESSION["message"] = "No crit section selected.";
   redirectTo("manage_critical_sections.php");
 }
?>


<?php
  if(isset($_POST["submit"])) {

      $requiredFields = array("page_name","security_level","fast_auth","page_master");
      validatePresence($requiredFields);
      $fieldMaxLength = array("page_name" => 24);
      getMaxLength($fieldMaxLength);

      if(empty($errors)) {

        $submittedId = (int)$currentCritSec["id"];
        $submittedPageName = safeStringSql($_POST["page_name"]);
        $submittedSecLevel = (int)safeStringSql($_POST["security_level"]);
        $submittedFastAuth = (int)safeStringSql($_POST["fast_auth"]);
        $submittedPageMaster = safeStringSql($_POST["page_master"]);



        $query = "UPDATE critical_sections SET ";
        $query .= " page_name = '{$submittedPageName}' ,";
        $query .= " security_level = {$submittedSecLevel},";
        $query .= " fast_auth = {$submittedFastAuth}, ";
        $query .= " page_master = '{$submittedPageMaster}'";

        $query .= " WHERE id = {$submittedId}";
        $query .= " LIMIT 1 ;";
        $result = mysqli_query($connection,$query);

          if($result) {
            // Success
            //$_SESSION["message"] = "Critical Section successfully updated.";
            if(mysqli_affected_rows($connection) == 0) {
              //$_SESSION["message"] .= " No changes made." . mysqli_affected_rows($connection);
            }
            redirectTo("manage_critical_sections.php");
          } else {
            $_SESSION["message"] = "Critical Section update failed: " . mysqli_error($connection);
            redirectTo("manage_critical_sections.php");
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
        <?php echo message(); ?>
          <h2 class="text-center">Admin Menu : Update</h2>

          <?php echo formErrors($errors); ?>
          <form style="width: 500px; margin: auto;" action="edit_critical_section.php?critSecId=<?php echo $currentCritSec["id"]; ?>" method="post">
          <p>
            <label><b>Page Name:</b></label>
             <input class="form-control" type="text" name="page_name" value="<?php echo $currentCritSec["page_name"]; ?>">
          </p>
          <p>
          <label><b>Security Level: </b></label>
          <select class="form-control" name="security_level">
            <option value="1" <?php if($currentCritSec["security_level"] == 1) echo "selected"; ?>>1</option>
            <option value="2" <?php if($currentCritSec["security_level"] == 2) echo "selected"; ?>>2</option>
            <option value="3" <?php if($currentCritSec["security_level"] == 3) echo "selected"; ?>>3</option>

          </select> 
          
          </p>

          <p>
          <label><b>Fast Auth: </b></label>
          <select class="form-control" name="fast_auth">
            <option value="0" <?php if($currentCritSec["fast_auth"] == 0) echo "selected"; ?>>Off</option>
            <option value="1" <?php if($currentCritSec["fast_auth"] == 1) echo "selected"; ?>>On</option>
          </select> 
          </p>

          <p>
            <label><b>Page Master:</b></label> <input class="form-control" type="text" name="page_master" value="<?php echo $currentCritSec["page_master"]; ?>">
          </p>

          <input class="btn btn-success center-block" type="submit" name="submit" value="Submit">
          <a class="btn btn-light text-secondary" href="manage_critical_sections.php">Cancel</a>

          </form>
        </br>

      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
