<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/tutor.php';

$database = new Database();
$db = $database->getConnection();

$tutor = new Tutor($db);

// get keywords
$keywords = array();
$keywords['city'] = isset($_GET['city']) ? $_GET['city'] : '';
$keywords['subject'] = isset($_GET['subject']) ? $_GET['subject'] : '';
$keywords['lang'] = isset($_GET['lang']) ? $_GET['lang'] : '';
$keywords['type'] = isset($_GET['type']) ? $_GET['type'] : '';

// query tutors
$stmt = $tutor->search($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

  $tutors_arr = array();
  $tutors_arr["records"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

    array_push($tutors_arr["records"], $tutor_item);
  }

  http_response_code(200);
  echo json_encode($tutors_arr);
} else {
  http_response_code(404);
  echo json_encode(
    array("message" => "Преподаватели не найдены.")
  );
}
