<?php
require_once '../config.php';
$obj_cliente = new cliente();
$param['clienteID'] = $id;
$param['where'][1]['campo'] = "clienteNombre";
$param['where'][1]['valor'] = $nombre."%";
$param['where'][1]['operador'] = "LIKE";
$cliente = $obj_cliente->listadoVWCliente($param);
//print_r($cliente);
if($cliente['resultado']){
    
    
    foreach ($cliente['datos'] as $key => $value) {
        $cliente['datos'][$key]['direccion']=$cliente['datos'][$key]['calle']." No. ".$cliente['datos'][$key]['numext'];
        $cliente['datos'][$key]['direccion'].=(!empty($cliente['datos'][$key]['numint'])) ? " Número Interior: ".$cliente['datos'][$key]['numint']:"";
        $cliente['datos'][$key]['direccion'].=" Colonia ".$cliente['datos'][$key]['colonia']." Código Postal ".$cliente['datos'][$key]['CodigoPostal'];
        $cliente['datos'][$key]['direccion'].=" Estado ".$cliente['datos'][$key]['estadoNombre'].", ".$cliente['datos'][$key]['abreviatura']." Municipio ".$cliente['datos'][$key]['Municipio'];
    }
    foreach ($cliente['datos'] as $key => $value) {
        foreach (array_keys($value) as $key1 => $value2) {
            $clientaeID[$key][$value2]=$cliente['datos'][$key][$value2];
            $clientaeID[$key]['label']=$cliente['datos'][$key]['clienteNombre'];
            //$clientaeID[$key]['value']=$cliente['datos'][$key]['clienteID'];
        }
    }
}
if($ajax){
    if($cliente['resultado']){
        print "si";
    }else{
        print "no";
    }
}else{
    print json_encode($clientaeID);
}