<?php
require_once __DIR__."/../../../src/database.php";

$query = "CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL AUTO_INCREMENT,
`first_name` varchar(255) DEFAULT NULL,
`last_name` varchar(255) DEFAULT NULL,
`email` varchar(255) NOT NULL UNIQUE,
`password_hash` char(60) NOT NULL,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=37;
";

$db = Database::get_instance();
$mysqli = $db->get_connection();

if ($mysqli->query($query)) {
  echo "Table `user` created successfully.";
} else {
  echo "Error creating table `user`: " . $mysqli->error;
}
?>
