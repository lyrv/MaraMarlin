<?php
session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
header("Content-Type: text/html;charset=utf-8");
if(isset($_REQUEST) and !empty($_REQUEST)){
    foreach($_REQUEST as $k => $v) {
        $$k=$v;
        //print "ASA$$k=$v<br>";
    }
}
$i = 1;

define("baseURL", "http://mmarlin.rvrsi.com.mx");
define("css", baseURL."/css/");
define("js", baseURL."/js/");
define("fonts", baseURL."/fonts/");
define("img", baseURL."/img/");
define("SERVER", "localhost");
define("USER", "rvrsicom_marlin");
define("PASSWORD", "mmarlin1979.");
/*define("USER", "root");
define("PASSWORD", "");
*/

define("DATABASE", "rvrsicom_mamarlin_2017");
define("SERVERAIZ",$_SERVER["DOCUMENT_ROOT"]."/");
//define("SERVERAIZ",$_SERVER["DOCUMENT_ROOT"]."/viirsa/");
define("ENTIDADES","entidades/");
define("MODELO","modelo/");
function __autoload($class_name) {
    if(file_exists(SERVERAIZ.ENTIDADES.$class_name.".php")){
        require_once(SERVERAIZ.ENTIDADES.$class_name.".php");
    }elseif(file_exists(SERVERAIZ.PDF."fpdf.php")){
        require_once(SERVERAIZ.PDF."fpdf.php");
    }elseif(file_exists(SERVERAIZ.MODELO.$class_name.".php")){
        require_once(SERVERAIZ.MODELO.$class_name.".php");
    }else{
        print "la Clase no existe ".SERVERAIZ.PDF." $class_name";
    }    
}
