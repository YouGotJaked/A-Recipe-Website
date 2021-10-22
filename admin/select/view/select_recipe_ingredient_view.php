<?php
require_once __DIR__."/../../../src/recipe_ingredient_view.php";

$view = new RecipeIngredientView();
$select = $view->select();

header('Content-Type: application/json');
echo $select;
?>
