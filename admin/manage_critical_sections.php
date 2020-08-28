<?php include("../includes/layouts/admin_header.php") ?>
<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>
<?php $critSectSet = getAllCriticalSections(); ?>
<?php //fullPowerCheck(); ?>

<link rel="stylesheet" href="../stylesheets/main.css">
<link rel="stylesheet" href="../stylesheets/sidebar.css">


<div id="page-content-wrapper">
        <div class="container-fluid">
      <a class="btn btn-warning" href="admin.php"><i class="fas fa-backward"></i> Main Menu</a>

          <h1>Manage Critical Sections</h1>
          </br><?php echo message(); ?>

    <div class="container">
    <div class="row">
        <div class="col">
        <div class="alert alert-info">
          <p>
              <b>Security Levels Explained</b>
              <ul>
                <li><b>Level 1</b> : User required to upload 1 share sent to first email linked to account</li>
                <li><b>Level 2</b> : User required to upload 2 share sent to first and second email linked to account</li>
                <li><b>Level 3</b> : User required to upload 2 shares, 1 from his first email; 2 from the page master</li>

              </ul>
          </p>
          <p>
              <b>Fast Auth</b>
              <ul>
                <li><b>On</b> : Users <b>NOT</b> required to enter challenge given, by delegating that step to our image recognition module. Allows for faster authentication.</li>
                <li><b>Off</b> : Users required to enter the challenge displayed after uploading.</li>
              </ul>
          </p>

  <p>
    <b>Page Master</b> </br>
      <h6>A remote authority acting as a gate-keeper. All pages at level 3 security level require a 2nd share from the page master.</h6>
</p>
    </div>
</div>
</div>
      <div class="row">
        <div class="col">
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th class="text-center">Page</th>
                  <th>Security Level</th>
                  <th>Fast Auth</th>
                  <th class="text-center">Page Master</th>
                  <th colspan="2" class="text-center" style="width: 150px;">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php while ($critSect = mysqli_fetch_assoc($critSectSet)) { ?>
                <tr class="text-center">
            <td>&nbsp;&nbsp;<?php echo htmlentities($critSect["page_name"]); ?></td>
            <td><?php echo htmlentities($critSect["security_level"]) ?></td>
            <td><?php echo htmlentities($critSect["fast_auth"] ? 'On' : 'Off')  ?></td>
            <td><?php echo htmlentities($critSect["page_master"]);  ?></td>
            <td><a class="btn btn-info" href="edit_critical_section.php?critSecId=<?php echo urlencode($critSect["id"]); ?>"><i class="fas fa-pen"></i> &nbsp;Edit&nbsp; </a>            
</td>
<td><a class="btn btn-info" href="delete_critical_section.php?critSecId=<?php echo urlencode($critSect["id"]); ?>" onClick="return confirm('Are you sure?');"><i class="fas fa-eraser"></i> Delete</a></td>
          </tr>

                <?php } ?>
              </tbody>
            </table>
        </div>
      </div>
      <a class="btn btn-info" href="new_critical_section.php"> <i class="fas fa-edit"></i>Add</a>

    </div>
          <br>

      </div>
    </div>

<?php include("../includes/layouts/admin_footer.php") ?>
