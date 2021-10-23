<?php
require_once __DIR__."/../root.php";
/**
 * Class to define a database connection. 
 */
class Database {
  const CREDS = DIR_LOC."config.ini";
  private static $instance = null;
  private $conn;

  private function __construct() {
    $config = parse_ini_file($this::CREDS);
    // allow support for non-standard ports
    if (isset($config["port"])) {
      $this->conn = new mysqli($config["host"], $config["user"], $config["pass"], $config["name"], $config["port"]);
    } else {
      $this->conn = new mysqli($config["host"], $config["user"], $config["pass"], $config["name"]);
    }
    // JSON requires UTF-8
    $this->conn->set_charset('utf8');
  }

  // prevent duplication
  private function __clone() { }
   
  // create or return a single instance of a database
  public static function get_instance() {
    if (!self::$instance) {
      self::$instance = new Database();
    }

    return self::$instance;
  }

  // return the database connection
  public function get_connection() {
    return $this->conn;
  }
}
?>
