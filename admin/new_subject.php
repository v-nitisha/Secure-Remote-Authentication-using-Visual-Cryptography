<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php include("../includes/layouts/admin_header.php") ?>
<?php findSelectedPage(); ?>
<?php //confirmLoggedIn(); ?>

<link rel="stylesheet" href="../stylesheets/sidebar.css">

<?php

if(isset($_POST["submit"])) {
    // Sets up retrieved variables
    $menu_name = safeStringSql($_POST["menu_name"]);
    $position = (int)$_POST["position"];
    $visible = (int)$_POST["visible"];
    $content = safeStringSql($_POST["content"]);


    // validation
    $requiredFields = array("menu_name", "position" , "visible");
    validatePresence($requiredFields);
    $fieldMaxLength = array("menu_name" => 30);
    getMaxLength($fieldMaxLength);


    // If $error is present , redirect back to new_subject.
    // Necessary to store in session because going back to another page.
    if(!empty($errors)) {
      $_SESSION["errorMsg"] = $errors;
      redirectTo("new_subject.php");
    }

    //Query
    $query = "INSERT INTO subjects (";
    $query .= "menu_name,position,visible,content)";
    $query .= " VALUES ( ";
    $query .= " '{$menu_name}',{$position},{$visible},'{$content}'";
    $query .= ");";
    $result = mysqli_query($connection,$query);

    if($result) {
      // Success
      $_SESSION["message"] = "Subject created.";
      redirectTo("manage_content.php");
    } else {
      $_SESSION["message"] = "Subject creation failed.";
      redirectTo("new_subject.php");
    }





  }

?>

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
      <?php echo message(); ?>
        <h1>Create Subject</h1>

          <?php $errors = errorMsg()  ?>
          <?php echo formErrors($errors)  ?>

        <form action="new_subject.php" method="post">
        <div class="form-group">
          <p><strong>Menu Name:</strong>
            <input type="text" class="form-control" name="menu_name" value=" "/>
          </p>
          </div>
          <div class="form-group">
            <p><strong>Position: </strong>
              <select name="position" class="form-control form-control-lg">
                <?php
                  $subjectSet = findAllSubjects();
                  $subjectCount = mysqli_num_rows($subjectSet);
                // Only list the position equal to the numbeo of subjects available
                  for($x=1; $x <= ($subjectCount + 1); $x++){
                    echo "<option value=\"{$x}\">{$x}</option>";
                  }
                ?>
              </select>
            </p>
            </div>
            <div class="form-group">
              <p><strong>Visible: </strong></br>
                <input type="radio" name="visible" value="0"> No
                &nbsp;
                <input type="radio" name="visible" value="1"> Yes
              </p>
            </div>
            <div class="form-group">
              <p><strong>Content: </strong></p><p>
                <textarea style="width: 100%;" cols="80" rows="9" name="content"><?php echo htmlentities($currentSubject["content"]); ?></textarea>
                </p>
              </div>

          <div class="field is-grouped">
            <p class="control">
              <input type="submit" name="submit" class="btn btn-success center-block" value="Create Subject">
              </p>
            <p class="control">
                <a class="btn btn-light center-block" href="manage_content.php">Cancel</a>
              </p>
          </div>
        </form>
      </br>
     
      </br>
      </br>
      </br>
    </div>
</div>

<?php include("../includes/layouts/admin_footer.php") ?>
