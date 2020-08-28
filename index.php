<?php require_once("includes/sessions.php") ?>
<?php require_once("includes/db_connections.php") ?>
<?php require_once("includes/functions.php") ?>
<?php include("includes/layouts/header.php") ?>
<?php
$publicPage = true;
findSelectedPage();
 ?>

<header>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container">

      <a href="index.php" class="navbar-brand">Visual Cryptography</a>
      
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">

      <?php echo public_navigation($currentSubject); ?>

      </div>
    </div>
  </nav>
</header>



<main role="main">
  <div class="container">
  <?php if($currentSubject) { ?>
          <h1 class="display-3"><?php echo htmlentities($currentSubject["menu_name"]); ?></h1>
          <br/>
          <p class="lead"><?php echo nl2br(htmlentities($currentSubject["content"])); ?></p>
          <p><br/><br/><br/></p>

  <?php } else { ?>
          <h1 class="display-4"><?php echo "Welcome"; ?></h1>
          <p class="lead"><?php echo "A website by group SSB18/4B"; ?></p>
  <?php } ?>
  </div>
</main>



<?php include("includes/layouts/footer.php") ?>
