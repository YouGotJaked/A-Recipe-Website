<?php
require_once "user.php";

function create_user($email, $first_name, $last_name, $password) {
  $user = new User();
  $exists = $user->select(["email" => $email], "s");
  $json_arr = json_decode($exists, true);
  
  if (is_array($json_arr) && count($json_arr) > 0) {
    echo "User already exists with email " . $email . "<br>";
    return false;
  }
  
  $json_obj = [
    "email" => $email,
    "first_name" => $first_name,
    "last_name" => $last_name,
    "password_hash" => password_hash($password, PASSWORD_BCRYPT)
  ];
  
  $add_user = $user->insert($json_obj, "ssss");
  
  if ($add_user) {
    echo "User has been added." . "<br>";
  } else {
    echo "Failed to add user." . "<br>";
    // TODO: why?
    return false;
  }
  
  return true;
}

function login($email, $password) {
  $user = new User();
  $exists = $user->select(["email" => $email], "s");
  $json_obj = json_decode($exists);
  return isset($json_obj[0]) && password_verify($password, $json_obj[0]->password_hash);
}
?>
