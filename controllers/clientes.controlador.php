<?php

class ControladorClientes{

    public function create($datosCliente){

        // Expresión regular para nombres
        if(
        isset($datosCliente["nombre"]) &&
        isset($datosCliente["apellido"]) &&
        preg_match('/^[a-zA-ZáéíóuúÁÉÍÓÚÑñ ]+$/', $datosCliente["nombre"]) && 
        preg_match('/^[a-zA-ZáéíóuúÁÉÍÓÚÑñ ]+$/', $datosCliente["apellido"])
        ){

        // Validación de correo electrónico
            if(isset($datosCliente["email"])&&
            preg_match('/^[a-z0-9_.]+@\w+\.\w{2,}$/', $datosCliente["email"])
            ){

                // Validación de email repetido
                //Se está llamando el método del modelo de clientes y pasando el nombre de la tabla
                $clientes = ModeloClientes::index("clientes");

                foreach ($clientes as $cliente) {

                    //echo $cliente->email . "\n";
                    if($cliente->email == $datosCliente["email"]){
                        $json=array(
                            "status"=>404,
                            "detalle"=>"El email ya existe"
                        );

                        echo json_encode($json, true);
                        return;
                    }
                }

                //================================================
                // Generación de credenciales de cliente
                //================================================
                $id_cliente = str_replace("$","r",crypt($datosCliente["nombre"].$datosCliente["apellido"].$datosCliente["email"], '$2y$10$.vGA1O9wmRjrwAVXD98HNOgsNpDczlqm3Jq7KnEd1rVAGv3Fykk1a'));
                $llave_secreta = str_replace("$","X",crypt($datosCliente["email"].$datosCliente["apellido"].$datosCliente["nombre"], '$2y$10$.vGA1O9wmRjrwAVXD98HNOgsNpDczlqm3Jq7KnEd1rVAGv3Fykk1a'));


                // Esto se pegará en la logica de la generación de credenciales
                $datos=array(
                    "nombre"=>$datosCliente["nombre"],
                    "apellido"=>$datosCliente["apellido"],
                    "email" => $datosCliente["email"],
                    "id_cliente"=>$id_cliente,
                    "llave_secreta"=>$llave_secreta,
                    "created_at"=>date("Y-m-d h:i:s"),
                    "updated_at"=>date("Y-m-d h:i:s")
                );

                $create = ModeloClientes::create("clientes", $datos);

                if($create == "ok"){

                    // ME QUEDÉ AQUI
                    $json=array(
                        "status"=>200,
                        "detalle"=>"Su usuario se ha registrado exitosamente.",
                        "credenciales"=>$id_cliente,
                        "llave secreta"=>$llave_secreta
                    );
                    
                    echo json_encode($json, true);
    
                    return;
                    
                }

            }else{

                $json=array(
                    "status"=>404,
                    "detalle"=>"El correo no es válido."
                );
                
                echo json_encode($json, true);

                return;
            }

        }else{

            $json=array(
                "status"=>404,
                "detalle"=>"En el nombre o apellido solo pueden ir letras y espacios."
            );
            
            echo json_encode($json, true);

            return;
        }

        /*
        echo "<pre>"; print_r($datosCliente); echo "</pre>";
        return;
        */
    }

    public function index(){

        $json=array(
            "detalle"=>"Un cliente está ingresando"
        );
        
        echo json_encode($json, true);

        return;
    }


}




?>