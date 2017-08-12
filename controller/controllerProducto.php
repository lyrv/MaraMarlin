<?php
require_once '../config.php';
if(isset($partida)){
    if($partida['funcion'] ==="addPartida"){
        $param['sol']=(float)$partida['sol'];
        $param['horas']=(float)$partida['horas'];
        if((!empty($param['sol'])) and ($param['sol']>= 0)){
            $cantidad = $param['sol'];
        }else{
            $cantidad = $param['horas'];
        }
        $param['codigo']=$partida['codigo'];
        $param['codigoID']=(int)$partida['codigoID'];
        $param['descripcion']=$partida['descripcion'];
        $importe = $partida['preciodescuento']*$cantidad;
        $param['preciolista']="$".number_format((float)$partida['preciolista'], 2, '.', ',');
        $param['preciodescuento']="$".number_format((float)$partida['preciodescuento'], 2, '.', ',');
        $param['importe']="$".number_format((float)$importe, 2, '.', ',');
        if(empty($partida['sol'])){
        }else{
            $item = ordenarPartidas();
            $_SESSION['partidas'][$item]=$param;
        }
        $rule = mostrarPartidas($_SESSION['partidas']);
    }elseif ($partida['funcion'] ==="delPartida") {
        //print "<br>".$partida['partida'];
        unset($_SESSION['partidas'][(int)$partida['partida']]);
        $item = ordenarPartidas();
        $rule = mostrarPartidas($_SESSION['partidas']);
    }elseif ($partida['funcion'] ==="emptyPartida") {
        unset($_SESSION['partidas']);
        $rule = vaciarPartidas($_SESSION['partidas']);
    }
    //print_r($_SESSION['partidas']);
}
if($forma){
    //print_r($datos);
    unset($datos['clienteID']);
    unset($datos['presupuesto']);
    foreach ($datos as $key => $value) {
        if(empty($value)){
            $error["campo"]=$key;
            $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> Se requiere este dato</div>";
            $error["div"]=$key."div";
            $retorno['errores'][]=$error;
        }else{
            $bien["campo"]=$key;
            $bien["motivo"]="-";
            $bien["div"]=$key."div";
            $retorno['bien'][]=$bien;
        }
    }
    if(count($partidas)==0){
        $error["campo"]="partidas";
        $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> No hay partidas</div>";
        $error["div"]="partidasdiv";
        $retorno['errores'][]=$error;
    }
    $retorno['partidas']=$_SESSION['partidas'];
    if(count($retorno['errores'])>=1){
        $retorno['resultado']=0;
    }else{
        $retorno['resultado']=1;
    }
    $retorno['cotizacionID']=112;
    
    print json_encode($retorno);
}
function addCliente() {
    
}
function ordenarPartidas(){
    $item = 1;
    foreach ($_SESSION['partidas'] as $key => $value) {
        $partidanew[$item]=$_SESSION['partidas'][$key];
        $item++;
    }
    unset($_SESSION['partidas']);
    $_SESSION['partidas']=$partidanew;
    return $item;
}
function mostrarPartidas($param) {
    foreach ($param as $key => $value) {
?>
<tr>
    <td><?= $param[$key]['sol']?>
        <input type="hidden" name="partidas[<?=$key?>][sol]" value="<?= $param[$key]['sol']?>">
    </td>
    <td><?= $param[$key]['horas']?>
        <input type="hidden" name="partidas[<?=$key?>][horas]" value="<?= $param[$key]['horas']?>">
    </td>
    <td><?= $param[$key]['codigo']?>
        <input type="hidden" name="partidas[<?=$key?>][codigo]" value="<?= $param[$key]['codigo']?>">
        <input type="hidden" name="partidas[<?=$key?>][codigoID]" value="<?= $param[$key]['codigoID']?>">
    </td>
    <td><?= $param[$key]['descripcion']?>
        <input type="hidden" name="partidas[<?=$key?>][descripcion]" value="<?= $param[$key]['descripcion']?>">
    </td>
    <td><?= $param[$key]['preciolista']?>
        <input type="hidden" name="partidas[<?=$key?>][preciolista]" value="<?= $param[$key]['preciolista']?>">
    </td>
    <td><?= $param[$key]['preciodescuento']?>
        <input type="hidden" name="partidas[<?=$key?>][preciodescuento]" value="<?= $param[$key]['preciodescuento']?>">
    </td>
    <td><?= $param[$key]['importe']?>
        <input type="hidden" name="partidas[<?=$key?>][importe]" value="<?= $param[$key]['importe']?>">
    </td>
    <td>
        <button type="button" class="botone btn btn-default" name="editarPartida" value ="<?= $key ?>" onclick="editarPartida(<?=$key ?>);"><span class="glyphicon glyphicon-pencil"></span></button>
        <button type="button" class="botonel btn btn-default" name="eliminarPartida" value ="<?= $key ?>" onclick="eliminarpartida(<?=$key ?>);"><span class="glyphicon glyphicon-trash"></span></button>
    </td>
</tr>    
<?php
    }
    //print json_encode($param);
}
function eliminarPartida($param) {
    print json_encode($param);
}
function vaciarPartidas($param) {
    print "0";    
}