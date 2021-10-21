<?php
require_once __DIR__."/../../../src/recipe_instruction_view.php";

$view = new RecipeInstructionView();
$select = $view->select();

header('Content-Type: application/json');
echo $select;
?>
