<?php
require_once __DIR__."/../../../src/database.php";

$query = "CREATE TABLE IF NOT EXISTS `recipe` (
`recipe_id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`serving_size` int(11) NOT NULL,
`recipe_category_id` int(11) NOT NULL,
PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=63;
";

$db = Database::get_instance();
$mysqli = $db->get_connection();

if ($mysqli->query($query)) {
  echo "Table `recipe` created successfully.";
} else {
  echo "Error creating table `recipe`: " . $mysqli->error;
}
?>
