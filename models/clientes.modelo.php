<?php

require_once "conexion.php";

class ModeloClientes{

    static public function index($tablaClientes){

        // De esta forma se llaman los método estáticos de otra clase.
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaClientes");

        // Ejecutar lo indicado en la variable $stmt
        $stmt->execute();

        // Devolver la información pedida de la db sin duplicarla.
        // Devolver solo en contenido y las propiedades de la tabla.
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->closeCursor();

        $stmt= null;

        return $result;
    }

    static public function create($tablaClientes, $datos){

        $stmt = Conexion::conectar()->prepare("
        INSERT INTO $tablaClientes  (nombre, apellido, email, id_cliente, llave_secreta, created_at, updated_at) VALUES
                                    (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :updated_at);
        ");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
        $stmt -> bindParam(":llave_secreta", $datos["llave_secreta"], PDO::PARAM_STR);
        $stmt -> bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
        $stmt -> bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        if($stmt -> execute()){

            return "ok";
        }else{

            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt->closeCursor();
        $stmt= null;
    }

}


?>