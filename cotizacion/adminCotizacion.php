<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
switch ($r) {
    case "edcotizacion":
        $archivo= "cotizacion.php";
        break;
    case "listado":
        $archivo= "listadoCotizacion.php";
        break;
    default:
        $archivo= "formularioCotizacion.php";
        break;
}
include($archivo);