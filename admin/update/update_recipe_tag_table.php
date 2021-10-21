<?php
require_once __DIR__."/../../root.php";
require_once DIR_SRC."recipe_tag.php";

$recipe_tag = new RecipeTag();
$update = $recipe_tag->update(['tag_id' => 53], ["recipe_id" => 72], "ii");
echo "Updated ".$update." row(s).";
?>
