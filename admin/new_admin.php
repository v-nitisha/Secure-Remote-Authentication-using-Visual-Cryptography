<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php //confirmLoggedIn(); ?>



<?php
  if(isset($_POST["submit"])) {


      $requiredFields = array("username","password","email","email2");
      validatePresence($requiredFields);
      $fieldMaxLength = array("username" => 24);
      getMaxLength($fieldMaxLength);
      emailUnique($_POST["email"],$_POST["email2"]);

      if(empty($errors)) {

        $submittedUsername = safeStringSql($_POST["username"]);
        $hashedPassword =   passwordEncrypt($_POST["password"]);
        $submittedEmail = safeStringSql($_POST["email"]);
        $submittedEmail2 = safeStringSql($_POST["email2"]);


        $query = "INSERT into admins (";
        $query .= " username, hashed_password,FULLPOWER,email,email2) ";
        $query .= " VALUES ( ";
        $query .= "\"{$submittedUsername}\",\"{$hashedPassword}\",0,\"{$submittedEmail}\",\"{$submittedEmail2}\"";
        $query .= ");";
        $result = mysqli_query($connection,$query);

        if($result) {
          // Success
          $_SESSION["message"] = "Admin successfully added.";
          redirectTo("manage_admins.php");
        } else {
          $_SESSION["message"] = "Admin creation unsuccessful because. " . mysqli_error($connection);
          redirectTo("new_admin.php");
        }
      }
  }
?>




<?php include("../includes/layouts/admin_header.php") ?>
<link rel="stylesheet" href="../stylesheets/main.css">

  <div id="main">
      <div id="navigation">
        &nbsp;
      </div>
      <div id="page">
        <?php echo message(); ?>
          <h2 class="text-center">Admin Menu : Create Admin</h2>
          <?php echo formErrors($errors); ?>
          <form style="width: 500px; margin: auto;" action="new_admin.php" method="post">
          <p>
            <b>Username:</b> <input class="form-control" type="text" name="username" value="">
          </p>
          <p>
          <b>Password:</b>  <input class="form-control" type="password" name="password" value="">
          </p>
          <p>
          <b>First Email:</b> <input class="form-control" type="text" name="email" value="">
          </p>
          <p>
          <b>Second Email:</b> <input class="form-control" type="text" name="email2" value="">
          </p>
          <input class="btn btn-success center-block" type="submit" name="submit" value="Create Admin">
          <a class="btn btn-light text-secondary" href="manage_admins.php">Cancel</a>

          </form>
        </br>
      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
