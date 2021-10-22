<?php
// constants
require_once __DIR__."/../root.php";

// requirements
require_once(DIR_SRC."login.php");
require_once(DIR_SRC."user.php");

// session info
ini_set("session.gc.maxlifetime", 3600); // keep session data for 1 hour
ini_set("session.cookie_secure", 1); // https://www.php.net/manual/en/function.setcookie.php#125241
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
  try {
    $_SESSION["login"] = login($_POST["email"], $_POST["password"]);   
    // login successful
    if ($_SESSION["login"]) {
      $user = new User();
      $json_obj = json_decode($user->select(["email" => $_POST["email"]], "s"))[0];
      // track user info
      $_SESSION["email"] = $json_obj->email;
      $_SESSION["name"] = $json_obj->first_name;
      $_SESSION["user"] = $json_obj->user_id;
      // redirect to home page
      header("Location: ".LINK_WEB."display/home.php");
    } else {
      echo '<p id="login-error">Invalid email or password.</p>'."<br>";
      unset($_SESSION["login"]);
    }
  } catch (Exception $e) {
    echo $e . "<br>";
  }
}
?>
<main>
  <div class="signin_container">
    <p id="signin">Sign into your account</p>
      <p id="signinfo"><a href="signup.php">Need an account? <b>Create one.</b></a></p>
    <div class="rectangle">
      <form method="POST" action="login.php">
        <p id="signID" for="email">E-mail</p>
        <input type="email" name="email" id="id" placeholder="Your e-mail address" required>
        <p id="signID" for="password">Password</p>
        <input type="password" name="password" id="id" placeholder="Your password" required>
        <!--$input id="signBtn" type="submit" name="submit" value="SIGN IN"-->
        <button id="signsubmit" type="submit" name="submit">SIGN IN</button>
      </form>
    </div>
  </div>
</main>
<?php require_once DIR_SRC."footer.php"; ?>
