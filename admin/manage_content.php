<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php include("../includes/layouts/admin_header.php") ?>
<?php findSelectedPage(); ?>
<?php //confirmLoggedIn(); ?>

<link rel="stylesheet" href="../stylesheets/sidebar.css">


<div id="wrapper">
  <!--Sidebar-->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <h4 class = "text-center">
          <br/> 
          Welcome, <?php echo htmlentities(ucfirst($_SESSION["username"])) ?>!</h4>
        </li>
        <li>
        <?php echo admin_navigation($currentSubject); ?>
        </li>
        <li class="nav-item">
          <a class="nav-link pl-0" href="new_subject.php"><i class="fa fa-heart-o fa-fw"></i>+ Add New Subject</a></li>
        <li class="nav-item">
          <a class ="nav-link pl-0" href="admin.php"><i class="fa fa-heart-o fa-fw"></i>&laquo;  Main Menu</a></li>
      </ul>
    </div>

      <div id="page-content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
            <a href="#menu-toggle" style="font-size:30px !Important; color: grey" aria-hidden="true" aria-hidden="true" class="fa fa-bars" id="menu-toggle"></a>
              <?php echo message(); ?>
                <?php if($currentSubject) { ?>
                <h1>Manage Subjects</h1>
                </br>
                <p><b>Menu Name: </b><span> <?php echo htmlentities($currentSubject["menu_name"]); ?> </br></span></p></br>
                <p><b>Position: </b><span><?php echo $currentSubject["position"]; ?> </br></span></p></br>
                <p><b>Visible: </b><span><?php echo $currentSubject["visible"] == 1 ? 'Yes' : 'No';?> </br></br></span></p>
                <p><b>Content: </b></span><?php echo htmlentities($currentSubject["content"]); ?></span></p>
                <div class="view-content">
                </div>
                </br>
                <a class="btn btn-light center-block" href="edit_subject.php?subject=<?php echo urlencode($currentSubject["id"]); ?>"><i class="fas fa-edit"></i>Edit Subject</a>

                <?php } else { ?>
                <h1>Manage Website Content</h1>
                  <p>Please select subject.</p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>


<?php include("../includes/layouts/admin_footer.php") ?>
