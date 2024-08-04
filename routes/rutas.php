<?php

//Tomando los elementos de la URL en un arreglo
$arrayRutas = explode("/",$_SERVER['REQUEST_URI']);

// Se imprime el arreglo
//echo explode("/",$_SERVER['REQUEST_URI']) . "<br>";

// Se imprime la URL
//echo $_SERVER['REQUEST_URI'] . "<br>";

// Se imprime el 3er valor del arreglo
//echo $arrayRutas[2] . "<br>";

// Se imprime cada valor del arreglo
//echo "<pre>"; print_r($arrayRutas); echo "<pre>";

// Se imprimen todos los avlores del arreglo en una sola línea.
//print_r($arrayRutas);

//echo "<br><br>";

// Hace el conteo de un arreglo sin indices vacíos.
if(count(array_filter($arrayRutas)) == 2){
    
    // Guarda en una variable un arreglo asociativo.
    $json=array(
        "detalle"=>"no encontrado"
    );
    
    // For2matea un arreglo asociativo a JSON.
    echo json_encode($json, true);

    return;
    
}else{

    if(count(array_filter($arrayRutas)) == 3){
        
        if(array_filter($arrayRutas)[3] == "cursos"){
            
            // Creando una petición POST
            // Se hará registro de informacióini a la db
            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                
                // Capturando los datoa que envía el usuario.
                // La información se manda desde body -> form-encode
                $datosCurso = array(
                    "titulo"=>$_POST["titulo"],
                    "descripcion"=>$_POST["descripcion"],
                    "instructor"=>$_POST["instructor"],
                    "imagen"=>$_POST["imagen"],
                    "precio"=>$_POST["precio"]
                );
                
                //echo "<pre>"; print_r($datos); echo "<pre>";

                // Se haraá envió de información de un nuevo curso a la db
                $cursoControlador = new ControladorCursos();
                $cursoControlador->create($datosCurso);
            }

            // Creando una petición GET
            elseif(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
                
                $cursoControlador = new ControladorCursos();
                $cursoControlador->index();

            }
        }

        if(array_filter($arrayRutas)[3] == "registros"){
            
            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
                
                $clienteRegistro = new ControladorClientes();
                $clienteRegistro->index();
            }
            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

                //Haciendo un array que toma la información que ingresa el usuario

                
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "apellido" => $_POST["apellido"],
                    "email" => $_POST["email"]
                );

                //echo "<pre>"; print_r($datos); echo "</pre>";

                $clienteRegistro = new ControladorClientes();
                $clienteRegistro->create($datos);
                

            }
        }
    }else if(array_filter($arrayRutas)[3] == "cursos" && is_numeric(array_filter($arrayRutas)[4])){
        
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
                
            $curso = new ControladorCursos();
            $curso->show(array_filter($arrayRutas)[4]);
        }

        //=========================
        // REALIZANDO PETICIÓN PUT
        //=========================
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT"){

            // Capturando los datos
            //$datos = array(); // No se usa esto para método PUT

            // Cuando se hace petición PUT, se usa este codigo para capturar los datos.
            // Este código captura toda la información que viene de la petición PUT.
            parse_str(file_get_contents('php://input'), $datos);

            //echo "<pre>"; print_r($datos); echo "</pre>";return;

            $cursoEditar = new ControladorCursos();
            $cursoEditar->editar(array_filter($arrayRutas)[4], $datos);
        }


        // CREANDO UNA PETICIÓN DELETE
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE"){

            $cursoBorrar = new ControladorCursos(); 
            $cursoBorrar->borrar(array_filter($arrayRutas)[4]);
        }
    }
}

?> 