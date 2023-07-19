<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Importamos la Conexión a la BD y la clase
include_once '../config/database.php';
include_once '../class/users.php';

//Conexión a BD
$database = new Database();
$db = $database->getConnection();

//Variable datos
$item = new Users($db);
$data = json_decode(file_get_contents("php://input"));

//Asignación de Variables
$item->id = $data->id;

if($item->eliminar()) {
    echo json_encode("success");
} else {
    echo json_encode("error");
}