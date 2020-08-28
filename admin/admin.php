<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/sessions.php") ?>
<?php //confirmLoggedIn(); ?>

<?php include("../includes/layouts/admin_header.php") ?>

<!--<link href="../stylesheets/sidebar.css" rel="stylesheet" media="all" type="text/css" > -->
<link href="../stylesheets/navbar.css"  rel="stylesheet" media="all" type="text/css">


<br/> 
<h1 class="text-center">Admin Menu</h1>
<?php echo message(); ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
      <div class="container">
        <p class="navbar-brand mx-auto">Welcome to the admin area, <?php echo htmlentities(ucfirst($_SESSION["username"])) ?>.</p>

        <!--
        <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="manage_content.php">Manage Website Content</a>
              </li>
             <li class="nav-item">
                <a class="nav-link" href="manage_admins.php">Manage Admin Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manage_critical_sections.php">Manage Critical Sections</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
              </ul>
              -->
      </div>
    </nav>

<br/>
<a href="manage_content.php" class="card bg-primary text-white mb-3 text-center mx-auto" style="width:50%">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-tasks"></i> Manage Website Content</h3>
                <p class="card-text">Allows you to manage the front-end content of the website.</p>
            </div>
        </a>
<a href="manage_admins.php" class="card bg-primary text-white mb-3 mx-auto text-center" style="width:50%">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-users"></i> Manage Admins</h3>
                <p class="card-text">Allows you to manage admin users.</p>
            </div>
        </a>
        <a href="manage_critical_sections.php" class="card bg-primary text-white mb-3 mx-auto text-center" style="width:50%">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-unlock"></i> Manage Critical Sections</h3>
                <p class="card-text">Allows you to manage critical sections in system requiring additional protection.</p>
            </div>
        </a>

        <a href="logout.php" class="card bg-primary text-white mb-3 mx-auto text-center" style="width:50%">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-sign-out-alt"></i> Logout</h3>
                <p class="card-text">Logout from system.</p>
            </div>
        </a>


<?php include("../includes/layouts/admin_footer.php") ?>
