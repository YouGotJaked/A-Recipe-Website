<?php
require_once __DIR__."/../root.php";
require_once DIR_SRC."recipe.php";
require_once DIR_SRC."recipe_category.php";
require_once DIR_SRC."tag.php";
require_once DIR_SRC."recipe_tag.php";
require_once DIR_SRC."ingredient.php";
require_once DIR_SRC."recipe_ingredient.php";
require_once DIR_SRC."recipe_instruction.php";

// get recipe categories as HTML option elements
function get_category_options() {
  $recipe_category = new RecipeCategory();
  $categories = $recipe_category->select();
  $categories = json_decode($categories);
  $html = "";
  
  foreach($categories as $cat) {
    $html .= '<option value="'.$cat->recipe_category_id.'">'.$cat->category.'</option>';
  }

  return $html;
}

// get recipe tags as HTML option elements
function get_tag_options() {
  $tag = new Tag();
  $tags = $tag->select();
  $tags = json_decode($tags);
  $html = "";
  
  foreach($tags as $t) {
    $html .= '<option value="'.$t->tag_id.'">'.$t->descr.'</option>';
  }

  return $html;
}

// prerequisite: form submit button is pressed
function submit_recipe() {
  // insert into recipe table
  $recipe = new Recipe();
  $recipe_str = '{"name":"'.$_POST["recipeName"].'",
                  "serving_size":"'.$_POST["servingSize"].'",
                  "recipe_category_id":"'.$_POST["category"].'"}';
  $recipe_arr = json_decode($recipe_str, true);
  $recipe_id = $recipe->insert($recipe_arr, "sii");
  
  // insert into recipe tag table
  // optional field so check if set
  if (isset($_POST["tag"])) {
    $recipe_tag = new RecipeTag();
    foreach ($_POST["tag"] as $tag_id) {
      $recipe_tag_str = '{"recipe_id":"'.$recipe_id.'",
                          "tag_id":"'.$tag_id.'"}';
      $recipe_tag_arr = json_decode($recipe_tag_str, true);
      $recipe_tag->insert($recipe_tag_arr, "ii"); 
    }
  }
  
  // insert into ingredient and recipe ingredient table
  $ingredient = new Ingredient();
  $recipe_ingredient = new RecipeIngredient();
  foreach ($_POST["ingredients"] as $ingr) {
    preg_match(INGR_REGEX, $ingr, $matches);
    $ingr_str = $ingredient->select(["name" => $matches["ingredient"]], "s");
    $ingr_obj = json_decode($ingr_str)[0];
    
    // ingredient does not exist
    if ($ingr_obj) {
      $ingr_id = $ingr_obj->ingredient_id;
    } else {
      $ingr_id = $ingredient->insert(["name" => $matches["ingredient"]], "s");
    }
    
    $params_arr = ["recipe_id" => $recipe_id,
                   "ingredient_id" => $ingr_id];
    $types = "ii";

    // only skip if both match groups are empty
    if (!(empty($matches["quantity"]) || empty($matches["unit"]))) {
      $params_arr["amount"] = trim($matches["quantity"]." ".$matches["unit"]);
      $types .= "s";
    }
    
    $recipe_ingredient->insert($params_arr, $types);
  }
  
  // insert into recipe instruction table
  $recipe_instruction = new RecipeInstruction();
  foreach ($_POST["instructions"] as $idx=>$instr) {
    $recipe_instruction->insert(["recipe_id" => $recipe_id, "step" => $instr, "step_index" => $idx], "isi");
  }
  
  // redirect to recipe
  header("Location: ".LINK_WEB."display/recipe.php?id=".$recipe_id);
}
?>
