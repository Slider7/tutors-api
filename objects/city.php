<?php
class City
{
  private $conn;
  private $table_name = "city";

  // object properties
  public $id;
  public $name;
  public $region;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all tutors with subjects
  function read()
  {
    $query = "SELECT * FROM city ORDER BY name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

}
