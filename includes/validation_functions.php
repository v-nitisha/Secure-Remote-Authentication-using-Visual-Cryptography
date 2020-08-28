<?php
$errors = array();

// Converts fieldnames into more presentable version
function fieldNameFix($fieldname) {
  $fieldname = str_replace("_"," ", $fieldname);
  $fieldname = ucfirst($fieldname);
  return $fieldname;
}

// Checks if field has been completed
// Both smaller parts of the multiple checkers
function hasPresence($value) {
  return isset($value) && $value !== "";
}

function hasMaxLength($value,$maxlength) {
  return strlen($value) <= $maxlength;
}


// Multiple field presence check
function validatePresence($requiredFields) {
  global $errors;
  foreach($requiredFields as $field) {
      $value = trim($_POST[$field]);
    if(!hasPresence($value)) {
      $errors[$field] = fieldNameFix($field) . " cant be blank";
    }
  }
}

// Multiple values max length
function getMaxLength($fields_with_max_length) {
  global $errors;

  foreach($fields_with_max_length as $field => $max) {
  $value = $_POST[$field];
  if(!hasMaxLength($value,$max)){
    $errors[$field] = fieldNameFix($field) . " can only have a max length of " . $max ;
    }
  }

}

function emailUnique($field1,$field2) {
  global $errors;
  if($field1 == $field2) {
    $errors['email'] = 'Email and Email2 must be different';
  }
}

// Checks to see if value present in variables
// e.g The @ symbol in emails
function has_inclusion($value, $array) {
  return in_array($value,$array);
}







?>
