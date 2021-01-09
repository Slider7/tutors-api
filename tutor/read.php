<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/tutor.php';

// instantiate database and tutor object
$database = new Database();
$db = $database->getConnection();
// initialize object
$tutor = new Tutor($db);

$stmt = $tutor->read();
$num = $stmt->rowCount();

if ($num > 0) {
  $tutors_arr = array();
  //$tutors_arr["records"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row - this will make $row['name'] to just $name only
    extract($row);

    $tutor_item = array(
      "id" => $id,
      "name" => $name,
      "phone" => $phone,
      "age" => $age,
      "rating" => $rating,
      "type" => $type,
      "lang" => $lang,
      "stage" => $stage,
      "city_name" => $city_name,
      "city_id" => $city_id,
      "description" => $description,
      "subjects" => $subjects,
      "created" => $created
    );

    array_push($tutors_arr, $tutor_item);
  }

  // set response code - 200 OK
  http_response_code(200);
  // show products data in json format
  echo json_encode($tutors_arr, JSON_UNESCAPED_UNICODE);
} else {
  // set response code - 404 Not found
  http_response_code(404);
  // tell the user no products found
  echo json_encode(
    array("message" => "No tutors found.")
  );
}
