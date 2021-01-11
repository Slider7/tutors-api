<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/city.php';

$database = new Database();
$db = $database->getConnection();
// initialize object
$city = new City($db);

$stmt = $city->read();
$num = $stmt->rowCount();

if ($num > 0) {
  $cities_arr = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row - this will make $row['name'] to just $name only
    extract($row);

    $city_item = array(
      "id" => $id,
      "name" => $name,
      "region" => $region
    );

    array_push($cities_arr, $city_item);
  }

  // set response code - 200 OK
  http_response_code(200);
  // show products data in json format
  echo json_encode($cities_arr, JSON_UNESCAPED_UNICODE);
} else {
  // set response code - 404 Not found
  http_response_code(404);
  // tell the user no products found
  echo json_encode(
    array("message" => "No cities found.")
  );
}
