<?php
require_once '../config.php';
class model_Cotizacion extends manejador{
    public $campos;
    public $tabla = "tbl_cotizacion";
    public $vista = "vw_cotizacion";
    public $entidad = "Cotización";
    public $ID = "cotizacionID";
    private $rows;
    public function __construct() {
    }
    public function getCampos() {
        $this->getFields($this->tabla);
        return $this->campos;
    }
    public function buscarCliente($param){
        $cliente = new entidadCliente();
        $resultado = $cliente->buscarenVista($param);
        return $resultado;
    }
    public function buscarProducto($param){
        $producto = new entidadProducto();
        $resultado = $producto->buscar($param);
        return $resultado;
    }
    
    /**
     * 
     * @param array $datos Array con los campos que seran introducitos en la tabla
     * @return bool resultado Boolean
     * @return text mensaje mensaje de error o de Ok
     * @return Int lastID Ultimo ID Insertado
     * @return text query consulta query
     */
    public function insert($datos) {
       $r= $this->insertInto($datos);
       return $r;
    }
    public function insertPartidas($partidas,$tabla) {
       $r= $this->insertOtraTabla($partidas,$tabla);
       return $r;
    }
    public function searchData($datos) {
       $r= $this->buscarEsto($datos,$this->tabla);
       return $r;
    }
    public function searchDataVista($datos) {
       $resultadoDatos= $this->buscarEsto($datos,$this->vista);
       /*
       foreach ($resultadoDatos['datos'] as $key => $value) {
           foreach ($value as $key1 => $value1) {
               $resultadoDatos['datos'][$key]['direccion']=$cliente['datos'][$key]['calle']." <b>No. </b>".$cliente['datos'][$key]['numext'];
               $resultadoDatos['datos'][$key]['direccion'].=(!empty($cliente['datos'][$key]['numint'])) ? " <b>Número Interior:</b> ".$cliente['datos'][$key]['numint']:"";
               $resultadoDatos['datos'][$key]['direccion'].=" <b>Colonia</b> ".$cliente['datos'][$key]['colonia']." <b>Código Postal</b> ".$cliente['datos'][$key]['CodigoPostal'];
               $resultadoDatos['datos'][$key]['direccion'].=" <b>Estado</b> ".$cliente['datos'][$key]['estadoNombre'].", ".$cliente['datos'][$key]['abreviatura']." <b>Municipio</b> ".$cliente['datos'][$key]['Municipio'];
               }
       }
*/
       return $resultadoDatos;
    }
    public function buscarCotizacion($id) {
       $data['where'][] = array("campo"=>$this->ID,"operador"=>"=","valor"=>$id);
       $cotizacion= $this->buscarEsto($data,$this->vista);
       $partidas= $this->buscarEstoArray($data,"vw_productos");
       $resultadoDatos['cotizacion']=$cotizacion['datos'];
       $subtotal=0;
       foreach ($partidas['datos'] as $key => $value) {
           unset($partidas['datos'][$key]['cotizacionID']);
           unset($partidas['datos'][$key]['codigoID']);
           unset($partidas['datos'][$key]['partidaID']);
           unset($partidas['datos'][$key]['iva']);
           unset($partidas['datos'][$key]['existencias']);
           $subtotal = $subtotal+$partidas['datos'][$key]['importe'];
           $partidas['datos'][$key]['preciolista'] = "$".number_format($partidas['datos'][$key]['preciolista'], 2, ".", ',');
           $partidas['datos'][$key]['preciodescuento'] = "$".number_format($partidas['datos'][$key]['preciodescuento'], 2, ".", ',');
           $partidas['datos'][$key]['importe'] = "$".number_format($partidas['datos'][$key]['importe'], 2, ".", ',');
       }
       $totales['subtotal'] = "$".number_format($subtotal, 2, ".", ',');
       $totales['iva'] = "$".number_format(($subtotal*.16), 2, ".", ',');
       $totales['total'] = "$".number_format(($subtotal*1.16), 2, ".", ',');
       $resultadoDatos['totales']=$totales;
       $resultadoDatos['partidas']=$partidas['datos'];
       return $resultadoDatos;
    }
}
