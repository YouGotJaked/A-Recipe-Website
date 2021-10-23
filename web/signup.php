<?php
// constants
require_once __DIR__."/../root.php";

// requirements
require_once(DIR_SRC."login.php");
require_once(DIR_SRC."user.php");

// session info
ini_set("session.gc.maxlifetime", 3600); // keep session data for 1 hour
if (isset($_SERVER["https"])) {
  ini_set("session.cookie_secure", 1); // https://www.php.net/manual/en/function.setcookie.php#125241
}
session_set_cookie_params(3600); // clients remember session id for 1 hour
session_start();
session_regenerate_id(true);
    
// redirect if already logged in 
if (isset($_SESSION["login"])) {
  header("Location: ".LINK_WEB."display/home.php");
}

// header
require_once DIR_SRC."header_nonmember.php";
    
// when user clicks submit button
if (isset($_POST["submit"])) {
  $user = new User();
  // verify passwords match
  if ($_POST["password"] != $_POST["confirmPassword"]) {
    echo "Passwords must match. Please try again." . "<br>";
    return;
  }
  // don't redirect if user was not created
  if (!create_user($_POST["email"], $_POST["firstName"], $_POST["lastName"], $_POST["password"])) {
    return;
  }
  $json_obj = json_decode($user->select(["email" => $_POST["email"]], "s"))[0];
  // track user info
  $_SESSION["login"] = login($_POST["email"], $_POST["password"]);
  $_SESSION["email"] = $json_obj->email;
  $_SESSION["name"] = $json_obj->first_name;
  $_SESSION["user"] = $json_obj->user_id;
  // redirect to home page
  header("Location: ".LINK_WEB."display/home.php");
}
?>
<div class="signupContainer">
<p id = "signup1">Sign up for an account</p>
<div class="rectangle_signup">
<form method="POST" action="signup.php">
  <p id = "signID">Email</p><input id = "id" type="email" name="email" placeholder="bbronco@scu.edu" required>
  <p id = "signID">First name</p><input id = "id" type="text" name="firstName" placeholder="Bucky" required>
  <p id = "signID">Last name</p><input id = "id" type="text" name="lastName" placeholder="Bronco" required>
  <p id = "signID">Password</p><input id = "id" type="password" name="password" placeholder="ScoCos1851!" required>
  <p id = "signID">Confirm password</p><input id = "id" type="password" name="confirmPassword" placeholder="ScoCos1851!" required>
  <button id = "signupsubmit" name="submit">SIGN UP</button>
  <!--input type="submit" name="submit" value="Submit"-->
</form>
</div></div>
<?php require_once DIR_SRC."footer.php"; ?>
