<?php
require_once __DIR__."/../../src/database.php";

$database = Database::get_instance();
$mysqli = $database->get_connection();
echo $mysqli->server_version;
?>
