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
$title = "Recipe List - Homemade";;
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

// get all recipes
$recipe_vw = new RecipeView();
$select = $recipe_vw->select();
$recipe_obj = json_decode($select);

// TODO: create separate source file for this functionality
// display recipes
$category = null;
foreach($recipe_obj as $recipe) {
  // display each distinct recipe category
  if ($category != $recipe->category) {
    // end last category
    if ($category != null) {
      echo '</ul></div>';
    }
    $category = $recipe->category;
    echo '<div class="'.$category.'"><p id="homelanding">'.$category.'</p><ul>';
  }
  echo '<li><p id = "homerecipe"><a href="'.LINK_WEB.'display/recipe.php?id='.$recipe->recipe_id.'" target="_blank">'.$recipe->name.'</a></p></li>';
}
// at least one recipe displayed
if (count($recipe_obj)) {
  echo '</ul></div>';
}


// footer
require_once DIR_SRC."footer.php";
?>
