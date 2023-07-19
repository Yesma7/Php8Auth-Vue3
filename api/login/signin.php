<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Importamos la Conexión a la BD y la clase
include_once '../../config/database.php';
include_once '../../class/login.php';

//Conexión a BD
$database = new Database();
$db = $database->getConnection();

//Variables Datos
$item = new Login($db);
$data = json_decode(file_get_contents("php://input"));

//Asignación de Variables
$item->email = $data->email;
$item->contraseña = $data->contraseña;

if($item->authenticate()) {
    http_response_code(200);

    $userProfile = array(
        "nombre" => $_SESSION['nombre'],
        "apellido" => $_SESSION['apellido'],
        "email" =>$_SESSION['email'],
        "cargo" => $_SESSION['cargo']
    );
    echo json_encode(array("success", $userProfile));
} else {
    http_response_code(404);
    echo json_encode("error");
}