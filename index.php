<?php
include("config.php");
if(isset($resultados)){
    $_SESSION['resultados'] = $resultados;
}else{
    if(!isset($_SESSION['resultados'])){
        $_SESSION['resultados'] = "all";
    }
}
$active[$q.$sq] = " class=\"active\"";
switch ($q) {
    case "clientes":
        $archivo = "clientes/adminClientes.php";
        if($sq){
            $archivo = "clientes/formularioCliente.php";
        }
        //$active['clientes'] = " class=\"active\"";
        break;
    case "fclientes":
        $archivo = "clientes/fichaCliente.php";
        break;
    case "cotizacion":
        $archivo = "cotizacion/adminCotizacion.php";
        //$active[$q] = " class=\"active\"";
        break;
    default:
        $archivo = "contenido.php";
        break;
}
include(SERVERAIZ.'head.php');
?>
  <body>
    

<?php
include(SERVERAIZ.'menu.php');
include(SERVERAIZ.$archivo);
include(SERVERAIZ.'foot.php');
?>    
    
  </body>
</html>
<?php
print_r($_SERVER);
?>