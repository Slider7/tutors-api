<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../config/database.php';
include_once '../objects/tutor.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$tutor = new Tutor($db);

// установим свойство ID записи для чтения 
$tutor->id = isset($_GET['id']) ? $_GET['id'] : die();

// прочитаем детали товара для редактирования 
$tutor->readOne();

if ($tutor->name != null) {
  // создание массива 
  $tutor_arr = array(
    "id" => $tutor->id,
    "name" => $tutor->name,
    "phone" => $tutor->phone,
    "age" => $tutor->age,
    "rating" => $tutor->rating,
    "type" => $tutor->type,
    "lang" => $tutor->lang,
    "stage" => $tutor->stage,
    "city_name" => $city_name,
    "city_id" => $city_id,
    "description" => $tutor->description,
    "subjects" => $tutor->subjects,
    "created" => $tutor->created
  );
  // код ответа - 200 OK 
  http_response_code(200);

  // вывод в формате json 
  echo json_encode($tutor_arr);
} else {
  // код ответа - 404 Не найдено 
  http_response_code(404);

  // сообщим пользователю, что тьютор не существует 
  echo json_encode(array("message" => "Преподаватель не существует."), JSON_UNESCAPED_UNICODE);
}
