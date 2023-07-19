<?php

class Users
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

    //Operaciones Usuarios

    //Obtener todos los registros
    public function obtenerTodos()
    {
        $sqlQuery = "SELECT * FROM " . $this->tabla_bd . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    //Obtener un solo registro
    public function obtenerUno()
    {
        $sqlQuery = "SELECT * FROM " . $this->tabla_bd . " WHERE id=? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);

        //Bind
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        //Relación de datos a Variables
        $filaDato = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nombre = $filaDato['nombre'];
        $this->apellido = $filaDato['apellido'];
        $this->email = $filaDato['email'];
        $this->cargo = $filaDato['cargo'];
        $this->contraseña = $filaDato['contraseña'];
    }

    //Registrar Usuario
    public function register()
    {
        $sqlQuery = "INSERT INTO " . $this->tabla_bd . "
        SET 
        nombre=:nombre,
        apellido=:apellido,
        email=:email,
        cargo=:cargo,
        contraseña=:password";

        $stmt = $this->conn->prepare($sqlQuery);


        //Sanitizazión
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cargo = htmlspecialchars(strip_tags($this->cargo));
        $this->contraseña = htmlspecialchars(strip_tags($this->contraseña));
        

        //Bind
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cargo", $this->cargo);
        $stmt->bindValue(":password", password_hash($this->contraseña, PASSWORD_BCRYPT));

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Actualizar Usuario
    public function updateUser()
    {
        $sqlQuery = "UPDATE " . $this->tabla_bd . "
        SET
        nombre=:nombre,
        apellido=:apellido,
        email=:email,
        cargo=:cargo,
        contraseña=:password
        WHERE id=:id";

        $stmt = $this->conn->prepare($sqlQuery);

        //Sanitización
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cargo = htmlspecialchars(strip_tags($this->cargo));
        $this->contraseña = htmlspecialchars(strip_tags($this->contraseña));
        $this->id = htmlspecialchars(strip_tags($this->id));


        //Bind - Enlazar variables
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cargo", $this->cargo);
        $stmt->bindValue(":password", password_hash($this->contraseña, PASSWORD_BCRYPT));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function eliminar()
    {
        $sqlQuery = "DELETE FROM " . $this->tabla_bd . " WHERE id=?";
        $stmt = $this->conn->prepare($sqlQuery);

        //Sanitización
        $this->id=htmlspecialchars(strip_tags($this->id));

        //Bind - Enlazar Variables
        $stmt->bindParam(1,$this->id);


        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
