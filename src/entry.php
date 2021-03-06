<?php
require_once "database.php";
require_once "selectable.php";
require_once "insertable.php";
require_once "updatable.php";
require_once "removable.php";
/**
 * Class to define an entry in a database.
 */
class Entry implements Selectable, Insertable, Updatable, Removable {
  public $table;
  public $database;

  public function __construct($table) {
    $this->table = $table;
    $this->database = Database::get_instance();
  }

  public function select($params=null, $types=null) {
    $query = "SELECT * FROM $this->table";
    
    if ($params != null) {
      $clause = " WHERE ";
      $clause .= implode(array_map(function ($elem) { return $elem . "=?"; },
                         array_keys($params)), " AND ");
      $query .= $clause;
      $stmt = $this->database->get_connection()->prepare($query);
      $stmt->bind_param($types, ...array_values($params));
    } else {
      $stmt = $this->database->get_connection()->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    
    return empty($rows) ? null : json_encode($rows, JSON_PRETTY_PRINT);
  }

  public function insert_id() {
    return $this->database->get_connection()->insert_id;
  }

  public function insert($params, $types) {
    $fields = "(" . implode(array_keys($params), ", ") . ")";
    $qmarks = "(" . implode(array_fill(0, count($params), "?"), ", ") . ")";
    $query = "INSERT INTO $this->table " . $fields . " VALUES " . $qmarks;
    $stmt = $this->database->get_connection()->prepare($query);
    $stmt->bind_param($types, ...array_values($params));
    $stmt->execute();
    return $this->insert_id();
  }

  // $where is an associative array of length 1
  public function update($params, $where, $types) {
    $fields = implode(array_map(function ($elem) { return $elem . "=?"; },
                      array_keys($params)), ", ");
    $query = "UPDATE $this->table SET ".$fields." WHERE ".array_keys($where)[0]."=?";
    $stmt = $this->database->get_connection()->prepare($query);
    $stmt->bind_param($types, ...array_merge(array_values($params), array_values($where)));
    $stmt->execute();
    return $stmt->affected_rows;
  }

  public function remove($params=null, $types=null) {
    $query = "DELETE FROM $this->table";
    
    if ($params != null) {
      $clause = " WHERE ";
      $clause .= implode(array_map(function ($elem) { return $elem . "=?"; },
                         array_keys($params)), " AND ");
      $query .= $clause;
      $stmt = $this->database->get_connection()->prepare($query);
      $stmt->bind_param($types, ...array_values($params));
    } else {
      $stmt = $this->database->get_connection()->prepare($query);
    }

    $stmt->execute();
    return $stmt->affected_rows;
  }
}
?>
