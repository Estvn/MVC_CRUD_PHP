<?php

//required_once se usa para incluir un archivo en otro, para poder usar sus métodos
//required_once funciona como el import en java
require_once "controllers/rutas.controlador.php";
require_once "controllers/cursos.controlador.php";
require_once "controllers/clientes.controlador.php";
require_once "models/clientes.modelo.php";
require_once "models/cursos.modelo.php";

$rutas = new ControladorRutas();

//En lugar de usar un punto para usar un método de objeto, se usa la flecha "->".
$rutas->inicio();


?>