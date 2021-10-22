<?php
require_once __DIR__."/../../../src/recipe_tag_view.php";

$view = new RecipeTagView();
$select = $view->select();

header('Content-Type: application/json');
echo $select;
?>
