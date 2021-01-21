<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/subject.php';

// instantiate database and subject object
$database = new Database();
$db = $database->getConnection();
// initialize object
$subject = new subject($db);

$stmt = $subject->read();
$num = $stmt->rowCount();

if ($num > 0) {
  $subjects_arr = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $subject_item = array(
      "id" => $id,
      "name" => $name,
	  "info" => $info,
      "type" => $type
    );

    array_push($subjects_arr, $subject_item);
  }

  // set response code - 200 OK
  http_response_code(200);
  // show products data in json format
  echo json_encode($subjects_arr, JSON_UNESCAPED_UNICODE);
} else {
  // set response code - 404 Not found
  http_response_code(404);
  echo json_encode(
    array("message" => "Дисциплины не найдены.")
  );
}
