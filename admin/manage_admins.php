<?php include("../includes/layouts/admin_header.php") ?>
<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php $adminSet = findAllAdmins(); ?>
<?php //fullPowerCheck(); ?>

<link rel="stylesheet" href="../stylesheets/sidebar.css">
<link rel="stylesheet" href="../stylesheets/navbar.css">


<div id="page-content-wrapper">
        <div class="container-fluid">
      </br>
      <a class="btn btn-warning" href="admin.php"><i class="fas fa-backward"></i> Main Menu</a>

      </div>
      <div id="page">
       
    <div class="container">
      <div class="row">
        <div class="col">
        <h2 class="text-center">Manage Admins</h2>
        <?php echo message(); ?>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>Username</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php while ($admin = mysqli_fetch_assoc($adminSet)) { ?>
                  <tr>
                <td>&nbsp;&nbsp;<?php echo htmlentities($admin["username"]); ?></td>
            <td><a class="btn btn-info" href="edit_admin.php?adminId= <?php echo urlencode($admin["id"]); ?>"><i class="fas fa-pen"></i> Edit</a></td>

            <td>
            <a class="btn btn-info" href="delete_admin.php?adminId=<?php echo urlencode($admin["id"]); ?>" onClick="return confirm('Are you sure?');"><i class="fas fa-eraser"></i> Delete</a>
            </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>
      </div>
      <a class="btn btn-info" href="new_admin.php"><i class="fas fa-edit"></i>Add</a>

    </div>
          <br>

      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
