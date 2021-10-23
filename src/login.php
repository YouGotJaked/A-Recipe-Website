<?php
require_once "user.php";

function user_exists($email) {
  $user = new User();
  $exists = $user->select(["email" => $email], "s");
  $json_arr = json_decode($exists);
  return $json_arr ?: false;
}

function create_user($email, $first_name, $last_name, $password) {
  $user = new User();
  
  if (user_exists($email)) {
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
  $user = user_exists($email);
  return $user && password_verify($password, $user[0]->password_hash);
}

if (isset($_POST["function"])) {
  switch ($_POST["function"]) {
    case "user_exists":
      echo user_exists($_POST["email"]) ? true : false;
      break;
    default:
      echo 0;
  }
}
?>
