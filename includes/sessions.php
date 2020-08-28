<?php
session_start();

// For displaying informative messages
function message() {
  if(isset($_SESSION["message"])) {
    $output = "<div style=\"width: 500px; margin: auto;\" class=\"alert alert-dark\" role=\"alert\">";
    $output .= htmlentities($_SESSION["message"]);
    $output .= "</div>";

    $_SESSION["message"] = null;
    return $output;
  }
}


// Retrieves all errors set to $_Session["errorMsg"];
// Returns array made of fielname=>
function errorMsg() {

  if(isset($_SESSION["errorMsg"])) {
    $errors = $_SESSION["errorMsg"];

    // Clear message after use
    $_SESSION["errorMsg"] = null;
    return $errors;
  }
}

 ?>
