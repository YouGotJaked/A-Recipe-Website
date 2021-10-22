<?php
// constants
require_once __DIR__."/../../root.php";

// requirements
require_once DIR_SRC."recipe_view.php";
require_once DIR_SRC."recipe_ingredient_view.php";
require_once DIR_SRC."recipe_instruction_view.php";
session_start();

// verify user is logged in
if (!isset($_SESSION["login"])) {
  header("Location: ".LINK_WEB."login.php");
}

// header
ob_start();
require_once DIR_SRC."header.php";
$buffer = ob_get_contents();
ob_end_clean();
$title = "Home - Homemade";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

// get all recipes
$recipe_vw = new RecipeView();
$select = $recipe_vw->select();
$recipe_obj = json_decode($select);

// get random recipe
$recipe_rand = array_rand(json_decode($select), 1);
$recipe_obj = $recipe_obj[$recipe_rand];

// display recipe
$h1 = '<p id="homelanding">Welcome '.$_SESSION["name"].'!</p>';
$h2 = '<p id="randomrecipe">Here\'s a random recipe:</p>';
echo $h1.$h2;
'<p id="homerecipe">'.$recipe_vw->display($recipe_obj->recipe_id).'</p>';

// footer
require_once DIR_SRC."footer.php";
?>
