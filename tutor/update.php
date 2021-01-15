<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом tutor 
include_once '../config/database.php';
include_once '../objects/tutor.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$tutor = new Tutor($db);

// получаем id тьютора для редактирования 
$data = $_POST;
// установим id свойства тьютора для редактирования 
$tutor->id = $data['id'];

// установим значения свойств тьютора 
$tutor->name = $data['name'];
$tutor->phone = $data['phone'];
$tutor->age = $data['age'];
$tutor->lang = $data['lang'];
$tutor->type = $data['type'];
$tutor->stage = $data['stage'];
$tutor->city_id = $data['city_id'];
$tutor->description = isset($data['description']) ? $data['description'] : "";

// обновление тьютора 
if ($tutor->update()) {

  // установим код ответа - 200 ok 
  http_response_code(200);

  // сообщим пользователю 
  echo json_encode(array("message" => "Тьютор был обновлён."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить тьютор, сообщим пользователю 
else {

  // код ответа - 503 Сервис не доступен 
  http_response_code(503);

  // сообщение пользователю 
  echo json_encode(array("message" => "Невозможно обновить тьютора."), JSON_UNESCAPED_UNICODE);
}
