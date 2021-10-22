<?php
require_once __DIR__."/../../../src/database.php";

$query = "CREATE TABLE IF NOT EXISTS `recipe_ingredient` (
`recipe_ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`ingredient_id` int(11) NOT NULL,
`amount` varchar(255) DEFAULT NULL,
PRIMARY KEY (`recipe_ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;
";

$db = Database::get_instance();
$mysqli = $db->get_connection();

if ($mysqli->query($query)) {
  echo "Table `recipe_ingredient` created successfully.";
} else {
  echo "Error creating table `recipe_ingredient`: " . $mysqli->error;
}
?>
