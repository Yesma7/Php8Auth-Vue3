<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Importamos la Conexión a la BD y la clase
include_once '../config/database.php';
include_once '../class/users.php';

//Conexión a BD
$database = new Database();
$db = $database->getConnection();

//Variables Datos
$items = new Users($db);

//Invocamos el método
$stmt = $items->obtenerTodos();
$itemConteo = $stmt->rowCount();

if ($itemConteo > 0) {
    $userList = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        //Array para almacenar datos
        $e = array(
            "id" => $id,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "email" => $email,
            "cargo" => $cargo,
            "contraseña" => $contraseña
        );

        array_push($userList, $e);
    }

    echo json_encode($userList);
} else {
    http_response_code(404);
    echo json_encode(array("msg" => "Oh no! No encontré nada"));
}
