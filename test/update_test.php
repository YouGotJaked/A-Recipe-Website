<?php
require_once "../src/entry.php";

$entry = new Entry("fake_table");
$update = $entry->update(array("id"=>0, "first"=>"Jake", "last"=>"Day"));

echo $update;
?>
