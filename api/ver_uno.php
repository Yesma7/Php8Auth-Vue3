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

//Variables Datos
$item = new Users($db);
$item->id = isset($_GET['id']) ? $_GET['id'] : die();

//Invocamos al método
$item->obtenerUno();

if($item->nombre != null)
{
    //Array para almacenar los Usuarios
    $userData = array(
        "id" => $item->id,
        "nombre" => $item->nombre,
        "apellido" => $item->apellido,
        "email" => $item->email,
        "cargo" => $item->cargo,
        "contraseña" => $item->contraseña
    );

    http_response_code(200);
    echo json_encode($userData);
} else {
    http_response_code(404);
    echo json_encode(array("msg" => "Ups! Algo salió mal"));
}