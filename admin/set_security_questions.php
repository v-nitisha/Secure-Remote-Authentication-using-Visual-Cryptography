<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php findSelectedAdmin() ?>

<?php //confirmLoggedIn(); ?>


<?php
  if(isset($_POST["submit"])) {

      $requiredFields = array("secQuestion","secAnswer");
      validatePresence($requiredFields);
      //$fieldMaxLength = array("username" => 24);
      //getMaxLength($fieldMaxLength);

      if(empty($errors)) {

        $submittedId = (int)$_SESSION["admin_id"];
        //$submittedUsername = safeStringSql($_POST["username"]);
        //$hashedPassword = passwordEncrypt($_POST["password"]);
        $selectedSecQuestion = safeStringSql($_POST["secQuestion"]);
        $submittedSecAnswer = safeStringSql($_POST["secAnswer"]);

        $query = "UPDATE admins SET ";
        //$query .= " username = '{$submittedUsername}' ,";
        //$query .= " hashed_password = '{$hashedPassword}'";
        $query .= " security_question_id = {$selectedSecQuestion} ,";
        $query .= " security_question_answer = '{$submittedSecAnswer}'";
        $query .= " WHERE id = {$submittedId}";
        $query .= " LIMIT 1 ;";
        $result = mysqli_query($connection,$query);

          if($result) {
            // Success
            $_SESSION["message"] = "Security questions successfully saved.";
            if(mysqli_affected_rows($connection) == 0) {
              $_SESSION["message"] .= " No changes made.";
            }
            redirectTo("admin.php");
          } else {
            $_SESSION["message"] = "Profile update failed: " . mysqli_error($connection);
            redirectTo("edit_profile.php");
          }
      } // end of If no validation errors
  } else {

  }// end of after submitted
?>




<?php include("../includes/layouts/admin_header.php") ?>
  <div id="main">
      <div id="navigation">
        &nbsp;
      </div>
      <div id="page">
        <?php echo message(); ?>
          <h2>Edit Admin Profile</h2>

          <?php echo formErrors($errors); ?>
          <form action="set_security_questions.php" method="post">

          <p>Security Question:
            <select name="secQuestion">
              <?php
                $secSet = findAllSecurityQuestions();
                $secCount = mysqli_num_rows($secSet);
              // Only list the position equal to the numbeo of subjects available
                for($x=1; $x <= $secCount; $x++){
                  echo "<option value=\"{$x}\"";
                  if($x == $_SESSION["security_question_id"]) {
                    echo " selected=\"selected\"";
                  }
                  $secQuest = findSecQuestionById($x);
                  echo " >{$secQuest["question"]}</option>";

                }
               ?>
            </select>
          </p>
          <p>
            Security Answer:  <input type="text" name="secAnswer" value="">
          </p>

          <input type="submit" name="submit" value="Save Profile">

          </form>
        </br>
        <a href="manage_admins.php">Cancel</a>

      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
