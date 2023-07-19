<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Importamos la COnexión a la BD y la clase
include_once '../../config/database.php';
include_once '../../class/login.php';

//Conexión a BD
$database = new Database();
$db = $database->getConnection();

//Variable Datos
$item = new Login($db);

if($_SESSION['loggedin']) {
    $userProfile = array(
        "nombre" => $_SESSION['nombre'],
        "apellido" => $_SESSION['apellido'],
        "email" =>$_SESSION['email'],
        "cargo" => $_SESSION['cargo']
    );

    http_response_code(200);
    echo json_encode($userProfile);
} else {
    http_response_code(404);
    echo json_encode(array("msg" => "Ups! Houston, tenemos un problema"));
}