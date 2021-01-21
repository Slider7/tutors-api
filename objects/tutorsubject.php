<?php
class TutorSubject
{
  private $conn;
  private $table_name = "tutorsubject";

  // object properties
  public $id;
  public $tutor_id;
  public $subject_id;
  public $info;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all tutors with subjects
  function create()
  {
	$query = "INSERT INTO
                " . $this->table_name . "
            SET tutor_id=:tutor_id, subject_id=:subject_id";

    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->tutor_id = htmlspecialchars(strip_tags($this->tutor_id));
	$this->subject_id = htmlspecialchars(strip_tags($this->subject_id));

    // bind values
    $stmt->bindParam(":tutor_id", $this->tutor_id);
    $stmt->bindParam(":subject_id", $this->subject_id);

    $last_id = 0;
    // execute query
    if ($stmt->execute()) $last_id = $this->conn->lastInsertId();
    
    return $last_id;
  }

}
