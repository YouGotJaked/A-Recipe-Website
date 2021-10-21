<?php
require_once __DIR__."/../../root.php";
require_once DIR_SRC."tag.php";

$tag = new Tag();
// update health
$update = $tag->update(["descr" => "Healthy"], ["descr" => "Health"], "ss");
echo "Updated ".$update." row(s).";
?>
