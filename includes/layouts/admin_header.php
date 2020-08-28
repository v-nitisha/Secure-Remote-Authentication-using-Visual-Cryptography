<?php // Included at top of every page inside admin folder  ?>
<?php require_once("../includes/sessions.php") ?>
<?php require_once("../includes/db_connections.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/admin_functions.php") ?>
<?php require_once("../includes/veri_functions.php") ?>

<?php

// Get current page name.
$currentPageName = getCurrentPageName();

// Layer Check 1 : Logged In
// Check if already logged in before accessing any admin page other than login
if(basename($currentPageName != "login.php")){
  confirmLoggedIn();
}

// Layer Check 2 : Have Session Token to Access that page
// Notes : Certain pages requires a token to function

// Check if current page needs a token

if(checkPageRequireToken($currentPageName)==true){
    //echo "Page requires token. <br/>";

    // Check userr has token
    if(checkUserHasToken($currentPageName)==true) {
      //echo "You have a token. You may proceed. </br>";
    } else {
      // User does not have token. Redirecting to verify.
      //$_SESSION["message"] = "You do not have full privilege to access this.";
      $_SESSION["veri_page"] = $currentPageName;
      redirectTo("veri_init.php");
    }
} else {
    //echo "Page does not require token. <br/>";
}




 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Visual Crypto FYP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie-edge">
  <!--
    <link href="../stylesheets/sidebar.css" rel="stylesheet" media="all" type="text/css" > 
    <link href="../stylesheets/navbar.css"  rel="stylesheet" media="all" type="text/css">
    -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  </head>
  <body>
