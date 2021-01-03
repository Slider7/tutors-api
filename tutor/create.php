<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../objects/tutor.php';

$database = new Database();
$db = $database->getConnection();

$tutor = new Tutor($db);

//$data = json_decode(file_get_contents('php://input'));
$data = $_POST;

// make sure data is not empty
if (
  !empty($data['name']) &&
  !empty($data['phone']) &&
  !empty($data['age']) &&
  !empty($data['type']) &&
  !empty($data['lang']) &&
  !empty($data['city_id'])
) {
  $tutor->name = $data['name'];
  $tutor->phone = $data['phone'];
  $tutor->age = $data['age'];
  $tutor->rating = 0;
  $tutor->lang = $data['lang'];
  $tutor->type = $data['type'];
  $tutor->stage = $data['stage'];
  $tutor->city_id = $data['city_id'];
  $tutor->description = isset($data['description']) ? $data['description'] : "";

  // create the tutor
  if ($tutor->create()) {
    // set response code - 201 created
    http_response_code(201);
    echo json_encode(array("message" => "tutor was created."));
  } else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to create tutor."));
  }
} else {
  // set response code - 400 bad request
  http_response_code(400);
  echo json_encode(array("message" => "Unable to create tutor. Data is incomplete."));
}
