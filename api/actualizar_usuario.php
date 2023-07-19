<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//Importamos la Conexión a la BD y la clase
include_once '../config/database.php';
include_once '../class/users.php';

//Conexión a BD
$database = new Database();
$db = $database->getConnection();

//Variable Datos
$item = new Users($db);
$data = json_decode(file_get_contents("php://input"));

//Asignación de Variables
$item->id = $data->id;
$item->nombre = $data->nombre;
$item->apellido = $data->apellido;
$item->email = $data->email;
$item->cargo = $data->cargo;
$item->contraseña = $data->contraseña;

if($item->updateUser())
{
    http_response_code(200);
    echo json_encode('success');
} else {
    http_response_code(404);
    echo json_encode('error');
}