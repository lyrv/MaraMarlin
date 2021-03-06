<?php
header("Content-Type: text/html;charset=utf-8");
class estadomexico {
    private $mysqli;
    public $lastID;
    public $mensaje;
    public $campos;
    public $tabla = "cat_estados";
    public $vista = "vw_estados";
    private $rows;
    
    public function __construct() {
        $this->conexion(1);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
        if (!$this->mysqli->set_charset("utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", $this->mysqli->error);
        }
        $this->rows=$_SESSION['resultados'];
        $this->getFields();
        $this->conexion(0);
    }
    protected function conexion($accion=1) {
        if($accion===1){
            $this->mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
        }else{
            $this->mysqli->close();
        }
    }
    public function rows() {
        $this->conexion(1);
        $query = "SELECT * FROM `".$this->tabla."`;";
        try {
            if ($result = $this->mysqli->query($query)) {
                if ($result->num_rows === 0){
                    throw new Exception("No hay Registros");
                }
                $filas = $result->num_rows;
                $result->close();
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return 0;
        }
        $this->conexion(0);
        return $filas;
    }
    protected function getFields() {
        $this->conexion(1);
        $query ="SELECT * FROM `".$this->tabla."`";
        try {
            if ($result = $this->mysqli->query($query)) {
                while ($finfo = $result->fetch_field()) {
                    $this->campos[]=$finfo->name;
                }
                $result->close();
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
        }
        $this->conexion(0);
    }
    public function listadoEstado($param=null) {
        $this->conexion(1);
        //print_r($param);
        if(!empty($param)){
            if(count($param['where'])>=1){
                //print count($param['where']);
                $where=" WHERE ";
                //print_r($param['where']);
                foreach ($param['where'] as $key => $value) {
                    if(strlen($where)>=8){
                        $where.= " AND ";
                    }
                    $where.= "`".$param['where'][$key]['campo']."` ".$param['where'][$key]['operador']." '".$param['where'][$key]['valor']."'";
                }
            }
            /*
            if(empty($param['municipioID'])){
                print "estadoID: ".$param['estadoID'];                
            }else{
                print "municipioID: ".$param['municipioID']." and estadoID: ".$param['estadoID'];
            }*/
            if(isset($param['inicio']) and $this->rows!=="all"){
                $limit = "LIMIT ".$param['inicio'].",".$this->rows;
            }
            //print_r($param);
        }
        if(empty($where)){
            $query = "SELECT * FROM `".$this->tabla."` ORDER BY `estadoID` ASC $limit;";
        }else{
            $query = "SELECT * FROM `".$this->tabla."` ".$where." ORDER BY `estadoID` ASC $limit;";
        }
        try {
            if ($result = $this->mysqli->query($query)) {
                if ($result->num_rows === 0){
                    throw new Exception("No hay Registros");
                }
                while ($finfo = $result->fetch_field()) {
                    $campos[]=$finfo->name;
                }
                while ($row = $result->fetch_array()){
                    foreach ($campos as $key => $value) {
                        $datos[$row['estadoID']][$value]=$row[$value];
                    }
                }
                $result->close();
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("datos"=>$datos,"consulta"=>$query,"resultado"=>false,"mensaje"=>$this->mensaje);
        }
        $this->conexion(0);
        return array("datos"=>$datos,"consulta"=>$query,"resultado"=>true,"mensaje"=>$this->mensaje);
    }
    public function listadoVWCliente($param=null) {
        $this->conexion(1);
        if(!empty($param)){
            if($param['clienteID']<>0 and !empty($param['clienteID'])){
                $where=" WHERE ";
                $where.= "clienteID = ".$param['clienteID'];
            }
            if($param['estadoID']<>0 and !empty($param['estadoID'])){
                print "estadoID: ".$param['estadoID'];
            }/*
            if(empty($param['municipioID'])){
                print "estadoID: ".$param['estadoID'];                
            }else{
                print "municipioID: ".$param['municipioID']." and estadoID: ".$param['estadoID'];
            }*/
            if(isset($param['inicio']) and $this->rows!=="all"){
                $limit = "LIMIT ".$param['inicio'].",".$this->rows;
            }
            //print_r($param);
        }
        if(empty($where)){
            $query = "SELECT * FROM `".$this->vista."` ORDER BY `clienteID` ASC $limit;";
        }else{
            $query = "SELECT * FROM `".$this->vista."` ".$where." ORDER BY `clienteID` ASC $limit;";
        }
        try {
            if ($result = $this->mysqli->query($query)) {
                if ($result->num_rows === 0){
                    throw new Exception("No hay Registros");
                }
                while ($finfo = $result->fetch_field()) {
                    $campos[]=$finfo->name;
                }
                while ($row = $result->fetch_array()){
                    foreach ($campos as $key => $value) {
                        $datos[$row['clienteID']][$value]=$row[$value];
                    }
                }
                $result->close();
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("datos"=>$datos,"consulta"=>$query,"resultado"=>false,"mensaje"=>$this->mensaje);
        }
        $this->conexion(0);
        return array("datos"=>$datos,"consulta"=>$query,"resultado"=>true,"mensaje"=>$this->mensaje);
    }
    function addCliente($param) {
        print_r($param);
        //SELECT * FROM `cat_clientes` WHERE `clienteID` = 'AAHH860402LQ4' 
        $this->conexion(1);
        $query = "INSERT INTO `cat_clientes` (`clienteID`, `nombre`, `rfc`, `calle`, `numext`, `numint`, `colonia`, `CodigoPostal`, `estadoID`, `telefono`, `correoe`, `borrado`) VALUES ('".$param['clienteID']."', '".$param['nombre']."', '".$param['rfc']."', '".$param['calle']."', '".$param['numext']."', '".$param['numint']."', '".$param['colonia']."', '".$param['CodigoPostal']."', '".$param['estadoID']."', '".$param['telefono']."', '".$param['correoe']."', '0');";
        try {
            if ($this->mysqli->query($query)) {
                $this->mensaje = "Registro Actualizado Correctamente.";
            }else{
                if($this->mysqli->errno===1062){
                    throw new Exception($this->mysqli->errno." - Este Cliente ya fue añadido");
                }else{
                    throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
                }
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("datos"=>$datos,"consulta"=>$query,"resultado"=>false,"mensaje"=>$this->mensaje);
        }
        $this->conexion(0);
        return array("datos"=>$datos,"consulta"=>$query,"resultado"=>true,"mensaje"=>$this->mensaje);
    }
}
