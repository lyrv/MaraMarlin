<?php
require_once '../config.php';
class model_Cliente extends manejador{
    public $campos;
    public $tabla = "cat_clientes";
    public $entidad = "Cliente";
    public $vista = "vw_clientes";
    public $ID = "clienteID";
    private $rows;
    public function __construct() {
    }
    public function getCampos($anone) {
        if($anone === "vista"){
            $this->getFields($this->vista);
        }else{
            $this->getFields($this->tabla);
        }
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
       foreach ($resultadoDatos['datos'] as $key => $value) {
           foreach ($value as $key1 => $value1) {
               $resultadoDatos['datos'][$key]['direccion']=$resultadoDatos['datos'][$key]['calle']." No. ".$resultadoDatos['datos'][$key]['numext'];
               $resultadoDatos['datos'][$key]['direccion'].=(!empty($resultadoDatos['datos'][$key]['numint'])) ? " Número Interior: ".$resultadoDatos['datos'][$key]['numint']:"";
               $resultadoDatos['datos'][$key]['direccion'].=" Colonia ".$resultadoDatos['datos'][$key]['colonia']." Código Postal ".$resultadoDatos['datos'][$key]['CodigoPostal'];
               $resultadoDatos['datos'][$key]['direccion'].=" Estado ".$resultadoDatos['datos'][$key]['estadoNombre'].", ".$resultadoDatos['datos'][$key]['abreviatura']." Municipio ".$resultadoDatos['datos'][$key]['Municipio'];
               }
       }

       return $resultadoDatos;
    }
}
