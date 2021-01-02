<?php
class Tutor
{
  // database connection and table name
  private $conn;
  private $table_name = "tutors";

  // object properties
  public $id;
  public $name;
  public $phone;
  public $stage;
  public $age;
  public $rating;
  public $lang;
  public $type;
  public $subjects;
  public $subject1;
  public $subject2;
  public $subject3;
  public $description;


  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all tutors with subjects
  function read()
  {
    $query = "SELECT * FROM tutors_view";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // используется при заполнении формы обновления товара 
  function readOne()
  {
    // запрос для чтения одной записи (тьютора) 
    $query = "SELECT * FROM tutors_view t 
               WHERE t.id = ?
               LIMIT 0,1";

    // подготовка запроса 
    $stmt = $this->conn->prepare($query);

    // привязываем id тьютора, который будет обновлен 
    $stmt->bindParam(1, $this->id);
    // выполняем запрос 
    $stmt->execute();
    // получаем извлеченную строку 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($row['name'])) {
      // установим значения свойств объекта
      $this->name = $row['name'];
      $this->phone = $row['phone'];
      $this->age = $row['age'];
      $this->rating = $row['rating'];
      $this->lang = $row['lang'];
      $this->stage = $row['stage'];
      $this->subject1 = $row['subject1'];
      $this->subject2 = $row['subject2'];
      $this->subject3 = $row['subject3'];
      $this->description = $row['description'];
      $this->subjects = $row['subjects'];
    }
  }

  // create tutor
  function create()
  {
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, phone=:phone, age=:age, rating=:rating, type=:type, lang=:lang, stage=:stage,
                subject1=:subject1, subject2=:subject2, subject3=:subject3, description=:description";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->age = htmlspecialchars(strip_tags($this->age));
    $this->rating = htmlspecialchars(strip_tags($this->rating));
    $this->lang = htmlspecialchars(strip_tags($this->lang));
    $this->type = htmlspecialchars(strip_tags($this->type));
    $this->stage = htmlspecialchars(strip_tags($this->stage));
    $this->subject1 = htmlspecialchars(strip_tags($this->subject1));
    $this->subject2 = htmlspecialchars(strip_tags($this->subject2));
    $this->subject3 = htmlspecialchars(strip_tags($this->subject3));
    $this->description = htmlspecialchars(strip_tags($this->description));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":age", $this->age);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":lang", $this->lang);
    $stmt->bindParam(":type", $this->type);
    $stmt->bindParam(":stage", $this->stage);
    $stmt->bindParam(":subject1", $this->subject1);
    $stmt->bindParam(":subject2", $this->subject2);
    $stmt->bindParam(":subject3", $this->subject3);
    $stmt->bindParam(":description", $this->description);

    // execute query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
