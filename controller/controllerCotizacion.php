<?php
require_once '../config.php';
foreach ($_REQUEST as $key => $value) {
    $datarq['datos'][$key]=$_REQUEST[$key];
}
$cotizacion = new entidadCotizacion();
$funcion = $accion;
$funcion($datarq,$cotizacion);
function buscarCliente($param,$objeto) {
    $resultado=$objeto->buscarCliente($param);
    print json_encode($resultado['datos']);
}
function buscarProducto($param,$objeto) {
    $param['datos']['codigo'] = "%".$param['datos']['codigo']."%";
    $param['datos']['operador'] = "LIKE";
    $resultado = $objeto->buscarProducto($param);
    print json_encode($resultado['datos']);
}
function editPartida($param,$objeto) {
    mostrarPartidas($objeto->editarPartida($param['datos']['partida']));
}
function cargarPartidas($param,$objeto) {
    mostrarPartidas($objeto->cargarPartidas($param['datos']['partida']));
}
function addPartida($param,$objeto) {
    mostrarPartidas($objeto->agregarPartida($param['datos']['partida']));
}
function mostrarPartidas($param) {
    foreach ($param as $key => $value) {
        $cantidad = ((int)$param[$key]['horas']== 0) ? $param[$key]['sol']:$param[$key]['horas'];
        $importe = $cantidad * $param[$key]['preciodescuento'];
?>
<tr>
    <td class="text-center"><?= $param[$key]['sol']?>
        <input type="hidden" name="partidas[<?=$key?>][sol]" id="partidas<?=$key?>-sol" value="<?= $param[$key]['sol']?>">
    </td>
    <td class="text-center"><?= $param[$key]['horas']?>
        <input type="hidden" name="partidas[<?=$key?>][horas]" id="partidas<?=$key?>-horas" value="<?= $param[$key]['horas']?>">
    </td>
    <td class="text-center"><?= $param[$key]['codigo']?>
        <input type="hidden" name="partidas[<?=$key?>][codigo]" id="partidas<?=$key?>-codigo" value="<?= $param[$key]['codigo']?>">
        <input type="hidden" name="partidas[<?=$key?>][codigoID]" id="partidas<?=$key?>-codigoID" value="<?= $param[$key]['codigoID']?>">
    </td>
    <td><?= $param[$key]['descripcion']?>
        <input type="hidden" name="partidas[<?=$key?>][descripcion]" id="partidas<?=$key?>-descripcion" value="<?= $param[$key]['descripcion']?>">
    </td>
    <td class="text-right">$<?= number_format((float)$param[$key]['preciolista'], 2, '.', ',')?>
        <input type="hidden" name="partidas[<?=$key?>][preciolista]" id="partidas<?=$key?>-preciolista" value="<?= $param[$key]['preciolista']?>">
    </td>
    <td class="text-right">$<?= number_format((float)$param[$key]['preciodescuento'], 2, '.', ',')?>
        <input type="hidden" name="partidas[<?=$key?>][preciodescuento]" id="partidas<?=$key?>-preciodescuento" value="<?= $param[$key]['preciodescuento']?>">
    </td>
    <td class="text-right">$<?= number_format((float)$importe, 2, '.', ',')?>
        <input type="hidden" name="partidas[<?=$key?>][importe]" id="partidas<?=$key?>-importe" value="<?= $importe?>">
    </td>
    <td class="text-right">
        <button type="button" class="btn btn-default" name="editarPartida" value ="<?= $key ?>" onclick="editarpartida(<?=$key ?>);"><span class="glyphicon glyphicon-pencil"></span></button>
        <button type="button" class="btn btn-default" name="eliminarPartida" value ="<?= $key ?>" onclick="eliminarpartida(<?=$key ?>);"><span class="glyphicon glyphicon-trash"></span></button>
        
    </td>
</tr>    
<?php
    }
    //print json_encode($param);
}
function delPartida($param,$objeto){
    unset($_SESSION['partidas'][(int)$param['datos']['partida']]);
    mostrarPartidas($_SESSION['partidas']);
}
function emptyPartida($datos,$objeto){
    print json_encode($objeto->vaciarPartidas());
}
function grabarCotizacion($datos,$objeto){
    $repuesta = $objeto->addCotizacion($datos);
    print json_encode($repuesta);
}
function cargarCotizacion($datos,$objeto){
    $repuesta = $objeto->cargarCotizacion($datos['datos']['cotizacionID']);
    print json_encode($repuesta);
}
function cargarCotizaciones($datos,$objeto){
    $repuesta = $objeto->cargarCotizaciones();
    print json_encode($repuesta);
}