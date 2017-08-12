<?php
require_once '../config.php';
foreach ($_REQUEST as $key => $value) {
    $dato[$key]=$_REQUEST[$key];
}
$cliente = new entidadCliente();
$resultado = $cliente->conciliarCliente($dato);
switch ($datos['accion']) {
    case "agregar":
        if($resultado['resultado']){
            $agregar = $cliente->agregar($resultado['datos']);
            if($agregar['resultado']){
                print json_encode($agregar);
            }else{
                print json_encode($agregar);
            }
        }else{
            print json_encode($resultado);
        }
        break;
    case "fichaCliente":
        $resultado = $cliente->buscarenVista($dato);
        if($resultado['resultado']){
            print json_encode($resultado);
        }
        break;
    default:
        print "nada";
        break;
}