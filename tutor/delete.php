<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/tutor.php';

$database = new Database();
$db = $database->getConnection();

$tutor = new Tutor($db);

$data = $_POST;

$tutor->id = $data['id'];

if ($tutor->delete()) {
  http_response_code(200);

  echo json_encode(array("message" => "Преподаватель был удалён."), JSON_UNESCAPED_UNICODE);
} else {
  http_response_code(503);
  echo json_encode(array("message" => "Не удалось удалить преподавателя."));
}
