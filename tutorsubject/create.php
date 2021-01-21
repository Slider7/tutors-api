<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../objects/tutorsubject.php';

$database = new Database();
$db = $database->getConnection();

$tutorsubject = new TutorSubject($db);

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

// make sure data is not empty
if (
  !empty($data['tutor_id']) &&
  !empty($data['subject_id'])
) {
  $tutorsubject->tutor_id = $data['tutor_id'];
  $tutorsubject->subject_id = $data['subject_id'];

  // create the tutor
  $last_id = $tutorsubject->create();
  
  if ($last_id > 0) {
    // set response code - 201 created
    http_response_code(201);
    echo json_encode(array("message" => $last_id));
  } else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Не удалось сохранить связь с предметом. Возможно, уже существует."));
  }
} else {
  // set response code - 400 bad request
  http_response_code(400);
  echo json_encode(array("message" => "Невозможно сохранить связь с предметом. Недостаточно данных/ошибка."));
}
