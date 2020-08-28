<?php

// Check if user still logged in.
// By checking if admin_id is still set
function loggedIn() {
  return isset($_SESSION['admin_id']);
}

// Enforces make sure its logged in.
// If not redirect to login page
function confirmLoggedIn() {
  if(!loggedIn()) {
    redirectTo("login.php");
  }
}

// Get current page name
// Returns string in format currentpage.php
function getCurrentPageName(){
  return basename($_SERVER['PHP_SELF']);
}


// Redirects to new page through HEADER change
// Neater way to redirect rather than calling header everytime need to redirect
function redirectTo($newLocation) {
  header("Location: " . $newLocation);
  exit;
}

// Convenient mysqli_real_escape_string in a function
function safeStringSql($string) {
  global $connection;
  $safeString = mysqli_real_escape_string($connection,$string);
  return $safeString;

}

// Check if query successful . Kills query if fail
function confirmQuery($result_set) {
  global $connection;

  if(!$result_set) {
      die("Database query failed. " . mysqli_error($connection));
    }
}

// When errors exist in array passed
// Will display it in a clean presentable list.
function formErrors($errors=array()) {
  $output = "";
  if(!empty($errors)) {

  $output .= "<div class=\"errors\" ?>";

  $output .= "Please fix the following errors : ";
  $output .= "<ul>";
    foreach ($errors as $key => $error) {
    $output .= "<li>";
    $output .= htmlentities($error);
    $output .= "</li>";
    }
  $output .= "</ul>";
  $output .= "</div>";
        }
          return $output;
}

// Find a list of existing security questions
function findAllSecurityQuestions() {
  global $connection;
  $query = "SELECT * FROM security_questions";
  $query .= " ORDER BY id ASC";
  $security_questions = mysqli_query($connection, $query);
  confirmQuery($security_questions);
  return $security_questions;
}

// Retrieves ALL SUBJECTS from db and returns it in associative array.
function findAllSubjects() {
  global $connection;
  $query = "SELECT * FROM subjects";
  $query .= " ORDER BY position ASC";
  $subject_set = mysqli_query($connection, $query);
  confirmQuery($subject_set);
  return $subject_set;
}

// Gets attributes and values of subject from its ID.
function findSubjectById($subject_id) {
  global $connection;

  if(empty($subject_id) || !is_numeric($subject_id)){
    $subject_id=0;
  }
  $safe_subject_id = mysqli_real_escape_string($connection,$subject_id);


  $query = "SELECT * FROM subjects";
  $query .= " WHERE id = {$safe_subject_id}";
  $query .= " LIMIT 1";
  $query .= ";";
  $subject_set = mysqli_query($connection, $query);
  confirmQuery($subject_set);
      // If mysql_fetch doesnt get a value ,it returns false.
      if ($subject = mysqli_fetch_assoc($subject_set)) {
          return $subject;
      } else {
          return null;
      }
}


// If user clicks a link from navigation, the GET variable for 'subject' is set.
// If one is set, it sets its $currentX variable to an associative array of all its data.
function findSelectedPage() {
  global $currentSubject;
  global $publicPage;
  if(isset($_GET["subject"])) {
      $currentSubject = findSubjectById($_GET["subject"]);
  } 
   else {
      $currentSubject = null;
  }
}




// Navigations takes
// - selected Subject ID array or null ( if any )
function admin_navigation($subject_array) {

      $output = "<ul class =\"subjects\">";
      $subject_set = findAllSubjects();
        while($subject = mysqli_fetch_assoc($subject_set)) {
          $output .= "<li";
          if($subject_array && $subject["id"] == $subject_array["id"]) {
          $output .= " class =\"selected\" ";
          }

         $output .= ">";
         $output .= "<a href=\"manage_content.php?subject=";
         $output .= urlencode($subject["id"]);
         $output .= "\">";
         $output .= htmlentities($subject["menu_name"]);
         $output .= "</a>";
      }
  mysqli_free_result($subject_set);
  $output .= "</ul>";
  return $output;
}



// ** Public Functions
// Retrieves all subjects from db and returns it in associative array.
function findAllVisibleSubjects() {
  global $connection;
  $query = "SELECT * FROM subjects";
  $query .= " WHERE visible = 1";
  $query .= " ORDER BY position ASC;";
  $subject_set = mysqli_query($connection, $query);
  confirmQuery($subject_set);
  return $subject_set;
}



// Difference vs admin_navigation is the links. This links to content rather than editing/adding
function public_navigation2($subject_array) {

      $output = "<ul class =\"subjects\">";
      $subject_set = findAllVisibleSubjects();
        while($subject = mysqli_fetch_assoc($subject_set)) {
          $output .= "<li";
          if($subject_array && $subject["id"] == $subject_array["id"]) {
          $output .= " class =\"selected\" ";
          }

         $output .= ">";
         $output .= "<a href=\"index.php?subject=";
         $output .= urlencode($subject["id"]);
         $output .= "\">";
         $output .= htmlentities($subject["menu_name"]);
         $output .= "</a>";

          $output .= "</li>"; // end of subject List tag
      }
  mysqli_free_result($subject_set);
  $output .= "</ul>";
  return $output;
}


function public_navigation($subject_array)
{
    $subject_set = findAllVisibleSubjects();
    $output = "";
    while ($subject = mysqli_fetch_assoc($subject_set)) {
      $output .= "<li class=\"nav-item";
        if ($subject_array && $subject["id"] == $subject_array["id"]) {
            $output .= " selected";
        }
            $output .= "\">";
            $output .= "<a href=\"index.php?subject=";
            $output .= urlencode($subject["id"]);
            $output .= "\"";
            $output .= " class=\"nav-link\">";
            $output .= htmlentities($subject["menu_name"]);
            $output .= "</a>";

            $output .= "</li>"; // end of subject List tag
        }
        mysqli_free_result($subject_set);
        $output .= "</ul>";
        return $output;
    }



 ?>
