<?php

// Se llama el archivo de conexión a los modelos
// Los modelos tendrán la lógica de conexión directa con la db.
require_once "conexion.php";

class modeloCursos{

    // Este método hará la conexión con la tabla en la db
    static public function index($tablaCursos, $tablaClientes){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaCursos");

        // De esta forma se llaman los método estáticos de otra clase.
        /*
        $stmt = Conexion::conectar()->prepare(
            "SELECT 
            $tablaCursos.id, $tablaCursos.titulo, $tablaCursos.descripcion,
            $tablaCursos.instructor, $tablaCursos.imagen, $tablaCursos.precio, 
            $tablaCursos.id_creador,
            $tablaClientes.nombre, $tablaClientes.apellido 
            FROM $tablaCursos INNER JOIN $tablaClientes ON
            $tablaCursos.id_creador = $tablaClientes.id
            ");
            */

        // Ejecutar lo indicado en la variable $stmt
        $stmt->execute();

        // Devolver la información pedida de la db sin duplicarla.
        // Devolver solo en contenido y las propiedades de la tabla.
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $stmt= null;
        return $result;
    }

    static public function create($tablaCursos, $datos){

        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tablaCursos(
                titulo, descripcion, instructor, imagen, precio, created_at, updated_at)
            VALUES(
                :titulo, :descripcion, :instructor, :imagen, :precio, :created_at, :updated_at)"
        );

        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt -> bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
        $stmt -> bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);
    
        // Esta respuesta se envía al controlador donde se llama este método
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt -> closeCursor();

        $stmt = null;
    }

    static public function show($tablaCursos, $id){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaCursos WHERE id = :id");

        //:id se enlaca con $id
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $stmt= null;
        return $result;
    }

    static public function editar($tablaCursos, $datos){

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tablaCursos SET
            titulo=:titulo, 
            descripcion=:descripcion,
            instructor=:instructor,
            imagen=:imagen,
            precio=:precio,
            updated_at=:updated_at WHERE id=:id");

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt -> bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        // Esta respuesta se envía al controlador donde se llama este método
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt -> closeCursor();
        $stmt = null;
    }

    static public function borrar($tablaCursos, $id){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tablaCursos WHERE id=:id");

        //:id se enlaca con $id
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt->closeCursor();
        $stmt = null;
    }

}


?>