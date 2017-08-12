<?php
require_once '../config.php';
class manejador {
    private $mysqli;
    public $lastID;
    public $mensaje;
    public $campos;
    public $desde;
    public $filas;
    private $rows;
    private function conexion($accion=1) {
        if($accion===1){
            $this->mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
        }else{
            $this->mysqli->close();
        }
    }
    protected function getFields($tabla) {
        $this->conexion(1);
        $query ="SELECT * FROM `".$tabla."`";
        try {
            if ($result = $this->mysqli->query($query)) {
                $this->rows = $result->num_rows;
                while ($finfo = $result->fetch_field()) {
                    $this->campos[]=$finfo->name;
                }
                $result->close();
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
        } finally {
            $this->conexion(0);
            return $this->campos;
        }
        
    }
    protected function insertInto($param) {
        foreach ($param as $key => $value) {
            $campos .= "`$key`";
            $campos .= ",";
            $valores .= "'$value'";
            $valores .= ",";
        }
        $valores = trim($valores, ',');
        $campos = trim($campos, ',');
        $query = "INSERT INTO `".$this->tabla."` (".$campos.") VALUES (".$valores.");";
        $this->conexion(1);
        try {
            //if ($result = $this->mysqli->query($query)) {
            if ($this->mysqli->query($query)) {
                $this->lastID = $this->mysqli->insert_id;
                $this->mensaje = $this->entidad." Insertad@ Correctamente. ID".$this->lastID;
            }else{
                if($this->mysqli->errno===1062){
                    throw new Exception($this->mysqli->errno." - Est@ ".$this->entidad."  ya fue añadid@");
                }else{
                    throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
                }
            }
            return array("resultado"=>1,"mensaje"=>$this->mensaje,"query"=>$query,"lastID"=>$this->lastID);
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("resultado"=>0,"mensaje"=>$this->mensaje,"query"=>$query);
        } finally {
            $this->conexion(0);
        }
    }
    protected function insertOtraTabla($param,$tabla) {
        foreach ($param as $key => $value) {
            $campos .= "`$key`";
            $campos .= ",";
            $valores .= "'$value'";
            $valores .= ",";
        }
        $valores = trim($valores, ',');
        $campos = trim($campos, ',');
        $query = "INSERT INTO `".$tabla."` (".$campos.") VALUES (".$valores.");";
        $this->conexion(1);
        try {
            //if ($result = $this->mysqli->query($query)) {
            if ($this->mysqli->query($query)) {
                $this->lastID = $this->mysqli->insert_id;
                $this->mensaje = $this->entidad." Insertad@ Correctamente. ID".$this->lastID;
            }else{
                if($this->mysqli->errno===1062){
                    throw new Exception($this->mysqli->errno." - Est@ ".$this->entidad."  ya fue añadid@");
                }else{
                    throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
                }
            }
            return array("resultado"=>1,"mensaje"=>$this->mensaje,"query"=>$query,"lastID"=>$this->lastID);
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("resultado"=>0,"mensaje"=>$this->mensaje,"query"=>$query);
        } finally {
            $this->conexion(0);
        }
    }
    protected function buscarEsto($param,$tabla) {
        $where .= " WHERE ";
        foreach ($param['where'] as $key => $value) {
            $where .= "`".$param['where'][$key]['campo']."` ".$param['where'][$key]['operador']." '".$param['where'][$key]['valor']."'";
        }
        $query = "SELECT * FROM `".$tabla."`".$where.";";
        $this->conexion(1);
        try {
            //if ($result = $this->mysqli->query($query)) {
            if ($result = $this->mysqli->query($query)) {
                $this->filas = $result->num_rows;
                $this->mensaje = "Ok";
                while ($row = $result->fetch_assoc()){
                    $datos[$row[$this->campos[0]]]=$row;
                    $datos[$row[$this->campos[0]]]['label']=$row[$param['where'][0]['campo']];
                    //$datos[$row[$this->campos[0]]]['id']=$row[$this->campos[1]];
                }
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
            if($this->filas===0){
                $this->mensaje = "Ningun Registro encontrado";
                //throw new Exception($this->mensaje);
            }
            return array("resultado"=>1,"mensaje"=>$this->mensaje,"query"=>$query,"filas"=>$this->filas,"datos"=>$datos);
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("resultado"=>0,"mensaje"=>$this->mensaje,"query"=>$query,"data"=>$param);
        } finally {
            $this->conexion(0);
        }
    }
    protected function buscarEstoArray($param,$tabla) {
        $where .= " WHERE ";
        foreach ($param['where'] as $key => $value) {
            $where .= "`".$param['where'][$key]['campo']."` ".$param['where'][$key]['operador']." '".$param['where'][$key]['valor']."'";
        }
        $query = "SELECT * FROM `".$tabla."`".$where.";";
        $this->conexion(1);
        try {
            //if ($result = $this->mysqli->query($query)) {
            if ($result = $this->mysqli->query($query)) {
                $this->filas = $result->num_rows;
                $this->mensaje = "Ok";
                while ($row = $result->fetch_assoc()){
                    $datos[]=$row;
                    //$datos[]['label']=$row[$param['where'][0]['campo']];
                    //$datos[$row[$this->campos[0]]]['id']=$row[$this->campos[1]];
                }
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
            if($this->filas===0){
                $this->mensaje = "Ningun Registro encontrado";
                //throw new Exception($this->mensaje);
            }
            return array("resultado"=>1,"mensaje"=>$this->mensaje,"query"=>$query,"filas"=>$this->filas,"datos"=>$datos);
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("resultado"=>0,"mensaje"=>$this->mensaje,"query"=>$query,"data"=>$param);
        } finally {
            $this->conexion(0);
        }
    }
    protected function buscarEstoOtraTabla($param,$tabla) {
        $where .= " WHERE ";
        foreach ($param['where'] as $key => $value) {
            $where .= "`".$param['where'][$key]['campo']."` ".$param['where'][$key]['operador']." '".$param['where'][$key]['valor']."'";
        }
        $query = "SELECT * FROM `".$tabla."`".$where.";";
        $this->conexion(1);
        try {
            //if ($result = $this->mysqli->query($query)) {
            if ($result = $this->mysqli->query($query)) {
                $this->filas = $result->num_rows;
                $this->mensaje = "Ok";
                while ($row = $result->fetch_assoc()){
                    $datos[$row[$this->campos[0]]]=$row;
                    $datos[$row[$this->campos[0]]]['label']=$row[$param['where'][0]['campo']];
                    //$datos[$row[$this->campos[0]]]['id']=$row[$this->campos[1]];
                }
            }else{
                throw new Exception($this->mysqli->errno." - ".$this->mysqli->error);
            }
            if($this->filas===0){
                $this->mensaje = "Ningun Registro encontrado";
                //throw new Exception($this->mensaje);
            }
            return array("resultado"=>1,"mensaje"=>$this->mensaje,"query"=>$query,"filas"=>$this->filas,"datos"=>$datos);
        } catch (Exception $exc) {
            $this->mensaje = $exc->getMessage();
            return array("resultado"=>0,"mensaje"=>$this->mensaje,"query"=>$query,"data"=>$param);
        } finally {
            $this->conexion(0);
        }
    }
}
