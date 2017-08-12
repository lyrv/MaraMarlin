<?php
require_once '../config.php';
$objt_productos = new producto();
//$param['codigoID'] = $id;
$param['where'][1]['campo'] = "codigo";
$param['where'][1]['valor'] = $codigo."%";
$param['where'][1]['operador'] = "LIKE";
$producto = $objt_productos->listadoProducto($param);
if($producto['resultado']){
    foreach ($producto['datos'] as $key => $value) {
        foreach (array_keys($value) as $key1 => $value2) {
            $productoID[$key][$value2]=$producto['datos'][$key][$value2];
            $productoID[$key]['label']=$producto['datos'][$key]['codigo'];
            //$clientaeID[$key]['value']=$cliente['datos'][$key]['clienteID'];
        }
    }
}
if($ajax){
}else{
    //print_r($producto);
    print json_encode($productoID);
}