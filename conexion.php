<?php
// Archivo de conexión a la base de datos
class Conexion{

    static public function conectar(){


$database = 'DATABASE_NAME';
$user = 'USERNAME';
$password = 'PASSWORD';
$hostname = 'HOSTNAME';
$port = 'PORT_NUMBER';

// Conexión a la base de datos
$conn_string = "DATABASE=$database;HOSTNAME=$hostname;PORT=$port;PROTOCOL=TCPIP;UID=$user;PWD=$password;";
$conn = db2_connect($conn_string, '', '');

if ($conn) {
    echo "Conexión exitosa a la base de datos DB2.\n";
} else {
    echo "Error en la conexión: " . db2_conn_errormsg() . "\n";
}

// Realizar una consulta
$sql = "SELECT * FROM mi_tabla";
$stmt = db2_exec($conn, $sql);

if ($stmt) {
    while ($row = db2_fetch_assoc($stmt)) {
        print_r($row);
    }
} else {
    echo "Error en la consulta: " . db2_stmt_errormsg() . "\n";
}

// Cerrar la conexión
db2_close($conn);


/*
        // Objeto para lograr la conexión con la base de datos mysql
        $link = new PDO("mysql:host=127.0.0.1:3306;dbname=apirest","root" ,"");

        $link->exec("set names utf8");

        return $link;
    }
}

?>