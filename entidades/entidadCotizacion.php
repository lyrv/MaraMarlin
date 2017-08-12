<?php
require_once '../config.php';
class entidadCotizacion {
    public $valores;
    public $buenos;
    public $modelo;
    public function __construct() {
        $this->modelo = new model_Cotizacion();
        $this->campos = $this->modelo->getCampos();
    }
    public function conciliarCotizacion($param) {
        //print_r($param);
        /*
         * SELECT `cotizacionID`, `clienteID`, `solicito`, `direccion`, `telefono`, `motor`, `lancha`, `requisicion`, `horas`, `presupuesto`, `fecha`, `estatus` FROM `tbl_cotizacion` WHERE 1 
         * 
         */
        //print_r($param);
        foreach ($this->campos as $key => $value) {
            if(empty($param[$value])){
                if($value === "cotizacionID"){
                }elseif($value === "estatus"){
                }elseif($value === "codigoID"){
                }elseif($value === "horas"){
                }elseif($value === "motor"){
                }elseif($value === "requisicion"){
                }elseif($value === "lancha"){
                }else{
                    $error["campo"]=$value;
                    $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> Dato Requerido</div>";
                    $error["div"]=$value."div";
                    $retorno['errores'][]=$error;
                }
            }else{
                $this->valores[$value]=$param[$value];
                $this->buenos[]=$value;
            }
            
        }
        if(count($retorno['errores'])>=1){
            return array("errores" => $retorno['errores'],"resultado" => 0,"correctos"=>$this->buenos,"datos"=>$this->valores);
        }else{
            return array("errores" => $retorno['errores'],"resultado" => 1,"correctos"=>$this->buenos,"datos"=>$this->valores);
        }
    }
    public function agregar($cotizacion) {
        $r = $this->modelo->insert($cotizacion);
        return $r;
    }
    public function buscarenVista($param) {
        foreach ($this->campos as $key => $value) {
            if(array_key_exists($value, $param['datos'])){
                $data['where'][] = array("campo"=>$value,"operador"=>$param['datos']['operador'],"valor"=>$param['datos'][$value]);
            }            
        }
        return $this->modelo->searchDataVista($data);
    }
    public function buscar($param) {
        foreach ($this->campos as $key => $value) {
            if(array_key_exists($value, $param['datos'])){
                $data['where'][] = array("campo"=>$value,"operador"=>$param['datos']['operador'],"valor"=>$param['datos'][$value]);
            }            
        }
        return $this->modelo->searchData($data);
    }
    /**
     * Funcion Agregar Partida
     * @param array Arreglo con los detalles de la partida
     */
    public function agregarPartida($param) {
        if(array_key_exists($param['codigoID'], $_SESSION['partidas'])){
            foreach ($_SESSION['partidas'] as $key => $value) {
                if($key==$param['codigoID']){
                    $param['sol']= $_SESSION['partidas'][$param['codigoID']]['sol']+$param['sol'];
                    $_SESSION['partidas'][$param['codigoID']]=$param;
                }//checar aqui si hay errores al sumar horas o sol
                if($key==$param['codigoID']){
                    $param['horas']= $_SESSION['partidas'][$param['codigoID']]['horas']+$param['horas'];
                    $_SESSION['partidas'][$param['codigoID']]=$param;
                }
            }
        }else{
            $_SESSION['partidas'][$param['codigoID']]=$param;
        }
        return $_SESSION['partidas'];
    }
    public function editarPartida($param) {
        foreach ($_SESSION['partidas'] as $key => $value) {
            if($key==$param['codigoID']){
                unset($_SESSION['partidas'][$param['codigoID']]);
                $_SESSION['partidas'][$param['codigoID']]=$param;
            }
        }
        return $_SESSION['partidas'];
    }
    public function vaciarPartidas($param) {
        unset($_SESSION['partidas']);
        return 0;
    }
    public function cargarPartidas($param) {
        return $_SESSION['partidas'];
    }
    public function addCotizacion($param) {
        $partidas = $param['datos']['partidas'];
        $cotizacion = $param['datos']['datos'];
        $r = $this->conciliarCotizacion($cotizacion);
        //print_r($resultado);
        if($r['resultado']){
            $resultado['cotizacion'] = $this->agregar($r['datos']);
            $cotizacionID = $resultado['cotizacion']['lastID'];
            //$jolin[]=$cotizacionID;
            foreach ($partidas as $key => $value) {
                $partidas[$key]['cotizacionID'] = $cotizacionID;
                unset($partidas[$key]['codigo']);
                unset($partidas[$key]['descripcion']);
                $resultado['partidas'][] = $this->modelo->insertPartidas($partidas[$key],"tbl_partidas_cotizacion");
            }
            $this->vaciarPartidas($param);
            //aqui comprobar errores con la insercion de partidas
        }else{
            $resultado = $r;
        }
        $resultado['cotizacionID']= $cotizacionID;
        return $resultado;
    }
    /**
     * Funcion Buscar Cliente
     * @param array Arreglo con los detalles de la partida
     */
    public function buscarCliente($param) {
        return $this->modelo->buscarCliente($param);
    }
    public function buscarProducto($param) {
        return $this->modelo->buscarProducto($param);
    }
    public function cargarCotizacion($id) {
        return $this->modelo->buscarCotizacion($id);
    }
}
