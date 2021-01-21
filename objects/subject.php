<?php
class Subject
{
  private $conn;
  private $table_name = "subject";

  // object properties
  public $id;
  public $name;
  public $info;
  public $type;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all tutors with subjects
  function read()
  {
    $query = "SELECT * FROM subjects ORDER BY name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

}
