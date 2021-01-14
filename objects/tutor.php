<?php
class Tutor
{
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
  public $city_id;
  public $city_name;
  public $description;
  public $created;

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

  function readOne()
  {
    $query = "SELECT * FROM tutors_view t 
               WHERE t.id = ?
               LIMIT 0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($row['name'])) {
      // установим значения свойств объекта
      $this->name = $row['name'];
      $this->phone = $row['phone'];
      $this->age = $row['age'];
      $this->rating = $row['rating'];
      $this->lang = $row['lang'];
      $this->stage = $row['stage'];
      $this->city_id = $row['city_id'];
      $this->city_name = $row['city_name'];
      $this->description = $row['description'];
      $this->subjects = $row['subjects'];
      $this->created = $row['created'];
    }
  }

  // create tutor
  function create()
  {
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, phone=:phone, age=:age, rating=:rating, type=:type, lang=:lang, stage=:stage,
                city_id=:city_id, description=:description";

    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->age = htmlspecialchars(strip_tags($this->age));
    $this->rating = htmlspecialchars(strip_tags($this->rating));
    $this->lang = htmlspecialchars(strip_tags($this->lang));
    $this->type = htmlspecialchars(strip_tags($this->type));
    $this->stage = htmlspecialchars(strip_tags($this->stage));
    $this->city_id = htmlspecialchars(strip_tags($this->city_id));
    $this->description = htmlspecialchars(strip_tags($this->description));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":age", $this->age);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":lang", $this->lang);
    $stmt->bindParam(":type", $this->type);
    $stmt->bindParam(":stage", $this->stage);
    $stmt->bindParam(":city_id", $this->city_id);
    $stmt->bindParam(":description", $this->description);

    $last_id = 0;
    // execute query
    if ($stmt->execute()) $last_id = $this->conn->lastInsertId();
    
    return $last_id;
  }

  // метод update() - обновление тьютора 
  function update()
  {
    $query =
      "UPDATE $this->table_name " .
      "SET
          name=:name,
          phone=:phone,
          age=:age,
          rating=:rating, 
          type=:type, 
          lang=:lang, 
          stage=:stage,
          city_id=:city_id, 
          description=:description
      WHERE 
        id = :id";

    // подготовка запроса 
    $stmt = $this->conn->prepare($query);

    // очистка 
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->age = htmlspecialchars(strip_tags($this->age));
    $this->rating = htmlspecialchars(strip_tags($this->rating));
    $this->lang = htmlspecialchars(strip_tags($this->lang));
    $this->type = htmlspecialchars(strip_tags($this->type));
    $this->stage = htmlspecialchars(strip_tags($this->stage));
    $this->city_id = htmlspecialchars(strip_tags($this->city_id));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":age", $this->age);
    $stmt->bindParam(":rating", $this->rating);
    $stmt->bindParam(":lang", $this->lang);
    $stmt->bindParam(":type", $this->type);
    $stmt->bindParam(":stage", $this->stage);
    $stmt->bindParam(":city_id", $this->city_id);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(':id', $this->id);

    // выполняем запрос 
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    $stmt = $this->conn->prepare($query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // search
  function search($keywords)
  {
    $query = "SELECT * FROM tutors_view t 
              WHERE
                t.city_name LIKE ? AND t.subjects LIKE ? AND t.lang LIKE ? AND t.type LIKE ?
              ORDER BY
                t.created DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $city = sanitizeParam($keywords['city']);
    $subject = sanitizeParam($keywords['subject']);
    $lang = sanitizeParam($keywords['lang']);
    $type = sanitizeParam($keywords['type']);
    // bind
    $stmt->bindParam(1, $city);
    $stmt->bindParam(2, $subject);
    $stmt->bindParam(3, $lang);
    $stmt->bindParam(4, $type);

    // execute query
    $stmt->execute();

    return $stmt;
  }
}

function sanitizeParam($param)
{
  $cleanParam = htmlspecialchars(strip_tags($param));
  return "%{$cleanParam}%";
}
