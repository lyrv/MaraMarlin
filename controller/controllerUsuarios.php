<?php
require_once '../config.php';
class controllerUsuarios {
    public $entidad;
    public function __construct() {
        print "paso";
        $this->entidad = new entidadUsuario();
        print "paso2";
    }
    public function loginUsuario($param) {
        
    }
    public function listadoUsuarios() {
        $resultado = $this->entidad->traerUsuarios();
        return $resultado;
    }
}
