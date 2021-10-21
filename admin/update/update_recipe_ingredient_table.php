<?php
require_once __DIR__."/../../root.php";
require_once DIR_SRC."recipe_ingredient.php";

$recipe_ingredient = new RecipeIngredient();

// update Cucumber
#$update = $recipe_ingredient->update(["amount" => "1"], ["recipe_ingredient_id" => 47], "si");

// update Cucumber salad
/*
$rows = 0;
$rows += $recipe_ingredient->update(["amount" => "1"], ["recipe_ingredient_id" => 52], "si");
$rows += $recipe_ingredient->update(["amount" => "1 tbsp"], ["recipe_ingredient_id" => 54], "si");
 */

// update baked oatmeal
$update = $recipe_ingredient->update(["amount" => "2"], ["recipe_ingredient_id" => 38], "si");

echo "Updated ".$update." row(s).";
?>
