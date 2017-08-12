<?php
require_once '../config.php';
class model_Producto extends manejador{
    public $campos;
    public $tabla = "cat_productos";
    public $entidad = "Producto";
    public $vista = "vw_productos";
    public $ID = "codigoID";
    private $rows;
    public function __construct() {
    }
    public function getCampos() {
        $this->getFields($this->tabla);
        return $this->campos;
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
}
