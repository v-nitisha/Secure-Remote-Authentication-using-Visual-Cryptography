<?php // This page is a single page submission
      //  Basically combination of create_subject + new_subject ?>
<?php require_once("../includes/sessions.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php findSelectedPage(); ?>
<?php //confirmLoggedIn(); ?>
 <!-- If submitted chunk -->
<?php
  if(!$currentSubject) {
    // Since this is a edit subject page, you shouldnt be here if subject id doesnt exist
    redirectTo("manage_content.php");
  }
?>

<link rel="stylesheet" href="../stylesheets/sidebar.css">


<?php
  if(isset($_POST["submit"])) {

    // validation
    $requiredFields = array("menu_name", "position" , "visible");
    validatePresence($requiredFields);
    $fieldMaxLength = array("menu_name" => 30);
    getMaxLength($fieldMaxLength);

    // If error array is empty, perform update
    if(empty($errors)) {

      $id = $currentSubject["id"];
      $menu_name = safeStringSql($_POST["menu_name"]);
      $position = (int)$_POST["position"];
      $visible = (int)$_POST["visible"];
      $content = safeStringSql($_POST["content"]);


      //Query
      $query = "UPDATE subjects SET";
      $query .= " menu_name = '{$menu_name}', ";
      $query .= " position = {$position}, ";
      $query .= " visible = {$visible}, ";
      $query .= " content = '{$content}'";
      $query .= " WHERE id = {$id}";
      $query .= " LIMIT 1;";
      $result = mysqli_query($connection,$query);

      // Check if query was successful and changes noticed
      if($result && mysqli_affected_rows($connection) <= 1) {
        // Success
        $_SESSION["message"] = "Subject updated.";
        redirectTo("manage_content.php");
      } else {
        $message = "Subject update failed. " . mysqli_error($connection);
      } // end of else
} // end of if $errors empty
  } // end of submit validation
 ?>



<?php include("../includes/layouts/admin_header.php") ?>
<div id="wrapper">
  <!--Sidebar-->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <h4 class = "text-center">
          Welcome, <?php echo htmlentities(ucfirst($_SESSION["username"])) ?>!</h4>
        </li>
        <li>
        <?php echo admin_navigation($currentSubject); ?>
        </li>
      </ul>
    </div>
    <div id="page-content-wrapper">
      <?php
      // Doesnt use session, if something wrong detected from above, fills up $message
      // Possible because validation and processing done on same page as actual form.
      if(!empty($message)) {
        echo "<div class=\"message\">" . htmlentities($message) . "</div>";
        }
      ?>

        <h1>Edit Subject: <?php echo htmlentities($currentSubject["menu_name"]); ?></h1>
              <?php echo formErrors($errors); ?>
        <form class="form-horizontal" action="edit_subject.php?subject=<?php echo urlencode($currentSubject["id"]); ?>" method="post">
          <div class="form-group">
            <p><strong>Menu Name: </strong></br>
              <input type="text" class="form-control" name="menu_name" value="<?php echo htmlentities($currentSubject["menu_name"]); ?>"/>
            </p>
          </div>
          <div class="form-group">
           <p><strong>Position: </strong></br>
              <select class="form-control form-control-lg" name="position">
                <?php
                  $subjectSet = findAllSubjects();
                  $subjectCount = mysqli_num_rows($subjectSet);
                // Only list the position equal to the numbeo of subjects available
                  for($x=1; $x <= $subjectCount; $x++){
                    echo "<option value=\"{$x}\"";
                    if($x == $currentSubject["position"]) {
                      echo " selected=\"selected\"";
                    }
                    echo " >{$x}</option>";

                  }
                ?>
              </select>
            </p>
          </div>
          <div class="form-group">
            <p><strong>Visible: </strong></br>
              <input type="radio" name="visible" value="0" <?php if($currentSubject["visible"] == 0) echo "checked"; ?>> No
              &nbsp;
              <input type="radio" name="visible" value="1" <?php if($currentSubject["visible"] == 1) echo "checked"; ?>> Yes
            </p>
          </div>
          <div class="form-group">
            <p><strong>Content: </strong></p><p>
              <textarea style="width: 100%; color:black" rows="10" name="content"><?php echo htmlentities($currentSubject["content"]); ?></textarea>
            </p>
            </div>
            <div class="form-group">
            <input type="submit" name="submit" class="btn btn-success center-block" value="Update Subject" >
          </div>
        </form>
      </br>
      <div class="btn-toolbar">
        <div class="col-sm-12">
            <a id="btnDelete" class="btn btn-light" class="text-danger" href="delete_subject.php?subject=<?php echo urlencode($currentSubject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Subject</a>
          &nbsp;
          &nbsp;

            <a id="btnCancel" class="btn btn-light" class="text-secondary" href="manage_content.php">Cancel</a>

          
          <br/>
          <br/>
          <br/>
        </div>
      </div>
    </div>
</div>


<?php include("../includes/layouts/admin_footer.php") ?>
