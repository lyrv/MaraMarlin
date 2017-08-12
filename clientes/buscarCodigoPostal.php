<?php
header("Content-Type: text/html;charset=utf-8");
require_once '../config.php';
$obj_codigospostales = new codigospostales();
$paasd['CodigoPostal'] = $id;
$codigopostal = $obj_codigospostales->listadoCodigosPostales($paasd);
if($codigopostal['resultado']){
    foreach ($codigopostal['datos'] as $key => $value) {
        //print_r(array_keys($value));
        foreach (array_keys($value) as $key1 => $value2) {
            $cp[$value2] = $codigopostal['datos'][$key][$value2];
        }
    }
}
if($ajax){
    if($codigopostal['resultado']){
?>
      <div class="alert alert-info" role="alert">
        <strong>Colonias:</strong>
        
<?php
        foreach (explode(";", $cp['Colonia']) as $key => $value) {
?>
        <button type="button" class="btn btn-info" onclick="seleccionar(this,'<?= strtoupper($cp['Municipio']) ?>','<?= strtoupper($cp['Estado']) ?>')" value="<?= strtoupper($value) ?>"><?= $value ?></button>
<?php
        }
?>        
      </div>
<?php
    }
}else{
    print json_encode($cp);
}