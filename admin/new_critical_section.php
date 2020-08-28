<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>

<?php //confirmLoggedIn(); ?>



<?php
  if(isset($_POST["submit"])) {


    $requiredFields = array("page_name","security_level","fast_auth","page_master");
      validatePresence($requiredFields);
      $fieldMaxLength = array("page_name" => 24);
      getMaxLength($fieldMaxLength);

      if(empty($errors)) {

        $submittedPageName = safeStringSql($_POST["page_name"]);
        $submittedSecLevel = (int)safeStringSql($_POST["security_level"]);
        $submittedFastAuth = (int)safeStringSql($_POST["fast_auth"]);
        $submittedPageMaster = safeStringSql($_POST["page_master"]);


        $query = "INSERT into critical_sections (";
        $query .= " page_name, security_level, fast_auth,page_master) ";
        $query .= " VALUES ( ";
        $query .= "\"{$submittedPageName}\",$submittedSecLevel,$submittedFastAuth, \"{$submittedPageMaster}\"";
        $query .= ");";
        $result = mysqli_query($connection,$query);

        if($result) {
          // Success
          $_SESSION["message"] = "Critical Section successfully added.";
          redirectTo("manage_critical_sections.php");
        } else {
          $_SESSION["message"] = "Critical Section creation unsuccessful because. " . mysqli_error($connection);
          redirectTo("manage_critical_sections.php");
        }
      }
  }
?>




<?php include("../includes/layouts/admin_header.php") ?>
<link rel="stylesheet" href="../stylesheets/main.css">
<div>
    
<br/>
          <h2 class="text-center">Admin Menu : New Critical Section</h2>
          <?php echo message(); ?>
          <form style="width: 500px; margin: auto;" action="new_critical_section.php" method="post">
          <p>
         <?php echo formErrors($errors); ?>
          </p>
          <p>
          <label for="page_name"><b>Page Name: </b></label>
            <input class="form-control" type="text" name="page_name" id="page_name" value="">
          </p>

          <p>
          <label for="security_level"><b>Security Level: </b></label>
          <select class="form-control" name="security_level" id="security_level">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

          </select> 
          
          </p>

          <p>
          Fast Auth: 
          <select class="form-control" name="fast_auth">
            <option value="0">Off</option>
            <option value="1">On</option>
          </select> 
          
          </p>
          <p>
          Page Master: <input class="form-control" type="text" name="page_master" value="">
          </p>
          <input class="btn btn-success center-block"  type="submit" name="submit" value="Create Critical Section">
          <a class="btn btn-light text-secondary" href="manage_critical_sections.php">Cancel</a>

          </form>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
