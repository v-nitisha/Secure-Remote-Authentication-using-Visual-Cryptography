<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php include("../includes/layouts/admin_header.php") ?>


<?php
$user = "";
  if(isset($_POST["submit"])) {

      $requiredFields = array("username","password");
      validatePresence($requiredFields);

      if(empty($errors)) {

        $user = $_POST["username"];
        $password = $_POST["password"];
        // Attempt Login
        $foundAdmin = attemptLogin($user,$password);
        if($foundAdmin) {
          // Login successfully
          $_SESSION["admin_id"] = $foundAdmin["id"];
          $_SESSION["username"] = $foundAdmin["username"];
          $_SESSION["fullpower"] = $foundAdmin["FULLPOWER"];
          $_SESSION["security_question_id"] = $foundAdmin["security_question_id"];
          $_SESSION["security_question_answer"] = $foundAdmin["security_question_answer"];
          $_SESSION["email"] = $foundAdmin["email"];
          $_SESSION["email2"] = $foundAdmin["email2"];




          redirectTo("admin.php");
        } else {
          // Login failed
          $_SESSION["message"] = "Login failed.";
        }
      } // end of no validation error
  } // end of if submit pressed
?>






    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card mt-5">
            <div class="card-header">
              <h4>Admin Login</h4>
            </div>
            <div class="card-body">
              <?php echo message(); ?>
            <?php echo formErrors($errors); ?>
              <form action="login.php" method="post">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo htmlentities($user);?>">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" value="">
                </div>
                <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>




<?php include("../includes/layouts/admin_footer.php") ?>
