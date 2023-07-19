<?php
session_start();

class Login 
{
    //Variable Conexión
    private $conn;

    //Nombre de la Tabla
    private $tabla_bd = "users";

    //Columnas de la Tabla
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $cargo;
    public $contraseña;

    //Conexión a BD
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Operciones Login
    public function authenticate()
    {
        $sqlQuery = "SELECT * FROM " . $this->tabla_bd . " WHERE email=:email";
        $stmt = $this->conn->prepare($sqlQuery);

        //Sanitización
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contraseña = htmlspecialchars(strip_tags($this->contraseña));

        //Bind
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        //Relación de datos a Variables
        $filaDato = $stmt->fetch(PDO::FETCH_ASSOC);

        if($this->email == $filaDato['email']) {
            if(password_verify($this->contraseña,$filaDato['contraseña'])) {
                session_regenerate_id();

                $_SESSION['loggedin'] = true;
                $_SESSION['nombre'] = $filaDato['nombre'];
                $_SESSION['apellido'] = $filaDato['apellido'];
                $_SESSION['email'] = $filaDato['email'];
                $_SESSION['cargo'] = $filaDato['cargo'];

                return true;
            }
        } else {
            echo "error";
        }
    }
}