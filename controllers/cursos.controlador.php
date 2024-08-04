<?php

class ControladorCursos{

    public function index(){

        //====================================================
        // Se hará validación de las credenciales del cliente
        //====================================================

        //base64_encode hace que los datos sean un 33% más largos. Más seguridad.

        if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"])){

            $clientes = ModeloClientes::index("clientes");

            foreach ($clientes as $cliente) {

                $arrayValoresCliente = (array) $cliente;

                if($_SERVER["PHP_AUTH_USER"] . ":" . $_SERVER["PHP_AUTH_PW"] == $arrayValoresCliente["id_cliente"] . ":" . $arrayValoresCliente["llave_secreta"]){

                    $cursos = ModeloCursos::index("cursos", null);

                    $json = array(

                        "status" => 200,
                        "total_registros" => count($cursos),
                        "detalle" => $cursos
                    );

                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }


    public function create($datosCurso){
        

        // LA LÓGICA COMENTADA ES LA VALIDACIÓN DE LAS CREDENCIALES DEL CLIENTE
/*        
        $clientes = ModeloClientes::index("clientes");

        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach ($clientes as $key => $valueCliente) {

                if(
                base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP:AUTH_PW']) ==
                base64_encode($valueCliente['id_cliente'].":".$valueCliente['llave_secreta'])
                ){

                    foreach ($datosCurso as $key => $valueDatos) {
                        if(isset($valueDatos) &&
                        /!preg_match('/^[(//)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.
                            \\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)
                        ){

                            $json = array(

                                "status"=>404,
                                "detalle"=>"Error en el campo ".$key
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }
                }
            }
        }
        */

        // Validando que el contenido que se va a guardar no esté nulo
        foreach ($datosCurso as $key => $valueDatos) {

            if(!isset($valueDatos)){

                $json = array(

                    "status"=>404,
                    "detalle"=>"Error en el campo ".$key
                );

                echo json_encode($json, true);
                return;
            }
        }

        // Validar que el título o la descripción no estén repetidos
        // Se han deshabilitado estas validaciones porque se ha modificado el método index

        /*
        $cursos = modeloCursos::index("cursos");

        foreach ($cursos as $key => $valueCurso) {
            
            if($valueCurso->titulo == $datosCurso['titulo']){

                $json = array(
                    "status"=>404,
                    "detalle"=>"El título ya está en la base de datos"
                );

                echo json_encode($json, true);
                return;
            }

            if($valueCurso->descripcion == $datosCurso['descripcion']){

                $json = array(
                    "status"=>404,
                    "detalle"=>"La descripción ya está en la base de datos"
                );

                echo json_encode($json, true);
                return;
            }
        }
        */

        // LÓGICA PARA ENVIAR LA INFORMACIÓN AL MODELO
        $datos= array(
            "titulo"=>$datosCurso["titulo"],
            "descripcion"=>$datosCurso["descripcion"],
            "instructor"=>$datosCurso["instructor"],
            "imagen"=>$datosCurso["imagen"],
            "precio"=>$datosCurso["precio"],
            //"id_creador"=>$valueCliente["id"],
            "created_at"=>date("Y-m-d h:i:s"),
            "updated_at"=>date("Y-m-d h:i:s"));

            $create = modeloCursos::create("cursos", $datos);

            //=============================================
            // Respuesta de la insersión de datos en la DB
            //=============================================
            if($create == "ok"){

                $json = array(
                    "status"=>200,
                    "detalle"=>"Registro exitoso, su curso ha sido guardado."
                );

                echo json_encode($json, true);
                return;
            }

        $json=array(
            "detalle"=>"estas creando un curso!"
        );
        
        echo json_encode($json, true);
        return;  
    }


    public function show($nCurso){

        // SE DEBEN VALIDAR LAS CREDENCIALES DEL CLIENTE
        // Recordar ver los vídeos para la validación de credenciales de los clientes.
/*
        $clientes = ModeloClientes::index("clientes");

        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
            foreach ($clientes as $key => $valueCliente) {
                if(
                    base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP:AUTH_PW']) ==
                    base64_encode($valueCliente['id_cliente'].":".$valueCliente['llave_secreta'])
                    ){

                        // Aquí dentro también van validaciones anti-script
                    }
            }
        }
        */

        $curso = modeloCursos::show("cursos", $nCurso);

        if(empty($curso)){
            
            $json=array(
                "status"=>404,
                "detalle"=>"El curso no existe."
            );

            echo json_encode($json, true);
            return;

        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$curso
            );

            echo json_encode($json, true);
            return;
        }
        
    }

    public function editar($nCurso, $datosCurso){

        // Se debe validar las credenciales del cliente
        //Solo es la lógica de abajo dentro de los if de validación de los método de arriba.

        /*
        $clientes = ModeloClientes::index("clientes");

        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
            foreach ($clientes as $key => $valueCliente) {
                if(
                    base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP:AUTH_PW']) ==
                    base64_encode($valueCliente['id_cliente'].":".$valueCliente['llave_secreta'])
                    ){

                        // Mostrar todos los cursos
                    }
            }
        }
        */

        // Validad el ID del creador
        //$curso = modeloCursos::show("cursos", $nCurso);

        /*
        foreach ($curso as $key => $valueCurso) {

            if($valueCurso->id_creador == $valueCliente["id"]){

                //Llevar datos al modelo
            }
        }
        */

        //========================
        // Llevar datos al modelo
        //========================
        $datos= array(
            "id"=>$nCurso,
            "titulo"=>$datosCurso["titulo"],
            "descripcion"=>$datosCurso["descripcion"],
            "instructor"=>$datosCurso["instructor"],
            "imagen"=>$datosCurso["imagen"],
            "precio"=>$datosCurso["precio"],
            "updated_at"=>date("Y-m-d h:i:s"));

            //echo "<pre>"; print_r($datos); echo "</pre>";return;

        // En este update se recibe el mensaje "ok" del modelo
        $update = modeloCursos::editar("cursos", $datos);

        if($update == "ok"){

            $json = array(
                "status" => 200,
                "detalles" => "La edición de los datos ha sido exitosa."
            );

            echo json_encode($json, true);
            return;

        }else{

            $json = array(
                "status" => 404,
                "detalles" => "No está autorizado para modficar este curso."
            );

            echo json_encode($json, true);
            return;

        }
    }

    public function borrar($nCurso){

        //Como en todos los métodos del controlador, se validan credenciales del cliente.
        /*
        $clientes = ModeloClientes::index("clientes");

        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
            foreach ($clientes as $key => $valueCliente) {
                if(
                    base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP:AUTH_PW']) ==
                    base64_encode($valueCliente['id_cliente'].":".$valueCliente['llave_secreta'])
                    ){
                        $curso = modeloCursos::show("cursos", $nCurso);

                        foreach ($curso as $key => $valueCurso) {
                            if($valueCurso->id_creador == $valueCliente["id"]){
                                
                                //Llevar datos al modelo
                            }
                        }
                        }
            }
        }*/

        //Llevar datos al modelo
        $delete = modeloCursos::borrar("cursos", $nCurso);

        if($delete == "ok"){

            $json = array(
                "status"=> 200,
                "detalles"=>"El curso se ha eliminado correctamente"
            );
    
            echo json_encode($json, true);
            return;
        
        }else{

            $json = array(
                "status"=>404,
                "detalles"=>"No tiene permiso de eliminar este curso."
            );
    
            echo json_encode($json, true);
            return;
        }
    }

}


?>