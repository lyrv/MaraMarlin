<?php
require_once '../config.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of entidadProducto
 *
 * @author ricardo_v_r
 */
class entidadProducto {
    public $valores;
    public $buenos;
    public $modelo;
    public function __construct() {
        $this->modelo = new model_Producto();
        $this->campos = $this->modelo->getCampos();
    }
    public function conciliarProducto($param) {
        //print_r($param);
        /*
         * SELECT `codigoID`, `codigo`, `descripcion`, `preciolista`, `iva`, `existencias` 
         * 
         */
        foreach ($this->campos as $key => $value) {
            if(empty($param['datos'][$value])){
                if($value === "borrado"){
                }elseif($value === "numint"){
                }elseif($value === "codigoID"){
                }else{
                    $error["campo"]=$value;
                    $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> Dato Requerido</div>";
                    $error["div"]=$value."div";
                    $retorno['errores'][]=$error;
                }
            }else{
                $this->valores[$value]=$param['datos'][$value];
                $this->buenos[]=$value;
            }
            
        }
        if($this->validaRFC($this->valores['rfc'])){
        }else{
            $error["campo"]="rfc";
            $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> RFC Inválido</div>";
            $error["div"]="rfcdiv";
            $retorno['errores'][]=$error;
        }
        $data['where'][] = array("campo"=>"rfc","operador"=>"=","valor"=>$this->valores['rfc']);
        $rfc = $this->modelo->searchData($data);
        if($rfc['resultado']){
            $error["campo"]="rfc";
            $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> RFC ya registrado</div>";
            $error["div"]="rfcdiv";
            $retorno['errores'][]=$error;
        }
        //print "correoe:".$this->valores['correoe'];
        if (filter_var($this->valores['correoe'], FILTER_VALIDATE_EMAIL)) {
        }else{
            $error["campo"]="correoe";
            $error["motivo"]="<div class=\"alert alert-danger\" role=\"alert\"><strong>Error</strong> Correo Electrónico Inválido</div>";
            $error["div"]="correoediv";
            $retorno['errores'][]=$error;
        }
        if(count($retorno['errores'])>=1){
            return array("errores" => $retorno['errores'],"resultado" => 0,"correctos"=>$this->buenos,"datos"=>$this->valores);
        }else{
            return array("errores" => $retorno['errores'],"resultado" => 1,"correctos"=>$this->buenos,"datos"=>$this->valores);
        }
    }
    public function validaRFC($valor) {
        $valor = str_replace("-", "", $valor);
        $cuartoValor = substr($valor, 3, 1);
        //RFC Persona Moral.
        if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
            $letras = substr($valor, 0, 3);
            $numeros = substr($valor, 3, 6);
            $homoclave = substr($valor, 9, 3);
            if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
                return true;
            }
        //RFC Persona Física.
        } else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) {
            $letras = substr($valor, 0, 4);
            $numeros = substr($valor, 4, 6);
            $homoclave = substr($valor, 10, 3);
            if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
                return true;
            }
        }else {
            return false;
        }
    }
    public function agregar($param) {
        $r = $this->modelo->insert($param);
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
}
