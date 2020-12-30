<?php
class Tutor{
    // database connection and table name
    private $conn;
    private $table_name = "tutors";
  
    // object properties
    public $id;
    public $name;
    public $subj_id;
    public $age;
    public $rating;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        // select all query
        $query = "SELECT
                    s.subj_name as subj_name, t.t_id as id, t.t_name as name, t.age, t.rating, t.subj_id
                FROM
                    " . $this->table_name . " t
                    LEFT JOIN
                        subjects s
                            ON t.subj_id = s.subj_id
                ORDER BY
                    t.t_name";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create tutor
    function create(){
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                t_name=:name, age=:age, subj_id=:subj_id, rating=:rating";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->age=htmlspecialchars(strip_tags($this->age));
    $this->rating=htmlspecialchars(strip_tags($this->rating));
    $this->subj_id=htmlspecialchars(strip_tags($this->subj_id));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":age", $this->age);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":subj_id", $this->subj_id);
 
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
}
?>