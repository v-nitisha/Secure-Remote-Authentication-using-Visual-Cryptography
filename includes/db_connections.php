<?php
// DB Connections
  define("DB_SERVER", "localhost");
  define("DB_USER","fyp");
  define("DB_PASS","distinction");
  define("DB_NAME","fyp_portal");

  $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME);

  // Test if connection was successful.
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " ()" . mysqli_connect_errno() . ")"
    );
  }
?>
