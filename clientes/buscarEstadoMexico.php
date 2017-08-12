<?php
header("Content-Type: text/html;charset=utf-8");
require_once '../config.php';
$obj_estadosmexico = new estadomexico();
$param['where'][1]['campo'] = "nombre";
$param['where'][1]['valor'] = $nombre."%";
$param['where'][1]['operador'] = "LIKE";
$estado = $obj_estadosmexico->listadoEstado($param);
if($estado['resultado']){
    foreach ($estado['datos'] as $key => $value) {
        $es[$key]['label'] = strtoupper($estado['datos'][$key]['nombre'].", ".$estado['datos'][$key]['abreviatura']);
        //$es[$key]['value'] = $key;
        $es[$key]['id'] = strtoupper($key);
        //print_r(array_keys($value));
        /*
        foreach (array_keys($value) as $key1 => $value2) {
            //$es[$key][$value2] = $estado['datos'][$key][$value2];
            $es[$key][$value2] = $estado['datos'][$key][$value2];
        }*/
    }
}
//print_r($estado);
if($ajax){
    if($codigopostal['resultado']){
?>
      <div class="alert alert-info" role="alert">
        <strong>Colonias:</strong>
        
<?php
        foreach (explode(";", $es['Colonia']) as $key => $value) {
?>
        <button type="button" class="btn btn-info" onclick="seleccionar(this)" value="<?= strtoupper($value) ?>"><?= $value ?></button>        
<?php
        }
?>        
      </div>
<?php
    }
}else{
    print json_encode($es);/*
    foreach ($es as $key => $value) {
        print json_encode($value);
    }*/
}
