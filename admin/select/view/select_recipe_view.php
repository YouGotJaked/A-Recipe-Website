<?php
require_once __DIR__."/../../../src/recipe_view.php";

$view = new RecipeView();
$select = $view->select();

header('Content-Type: application/json');
echo $select;
?>
