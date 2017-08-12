<?php
$cliente = new cliente();
//print_r($cliente);
if (!$pagina) {
   $inicio = 0;
   $pagina = 1;
}
else {
   $inicio = ($pagina - 1) * $_SESSION['resultados'];
}
$param['inicio'] = $inicio;
$total_paginas = ceil($cliente->rows()/ $_SESSION['resultados']);
?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="row">
<?php
if(isset($sq) and $sq=="alta"){
    include('formularioCliente.php');
}
?>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">Listado de Clientes</div>
              <div class="panel-body">
                  <h2>Administración Clientes</h2>
                  <a href="<?= baseURL .$_SERVER['PHP_SELF'] ?>?q=clientes&sq=alta" title="Agregar Cliente">
                      <button type="button" class="btn btn-success btn-lg">
                          <span class="glyphicon glyphicon-user"></span> Agregar Cliente
                      </button>
                  </a>
              </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="4">
                            <ul class="pager">
<?php
if ($total_paginas > 1) {
   if ($pagina != 1)
?>
                                <li class="previous">
                                    <a href="<?= baseURL .$_SERVER['PHP_SELF']."?q=clientes&pagina=".($pagina-1)?>">&larr; Anterior</a>
                                </li>
      
<?php
//echo "<a href="'. baseURL .$_SERVER['PHP_SELF'].'?q=clientes&pagina='.($pagina-1).'"><span class="glyphicon glyphicon-arrow-left"></span></a>';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i){
            //si muestro el índice de la página actual, no coloco enlace
?>
                                <li class="disabled">
                                    <a href="#"><?= $pagina ?> <span class="sr-only">(página actual)</span></a>
                                </li>
                                
<?php
            //echo $pagina;
         }else{
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
?>
                                <li><a href="<?= baseURL .$_SERVER['PHP_SELF']."?q=clientes&pagina=".$i ?>"><?= $i ?></a></li>
<?php
//echo '  <a href="'. baseURL .$_SERVER['PHP_SELF'].'?q=clientes&pagina='.$i.'">'.$i.'</a>  ';
         }
      }
      if ($pagina != $total_paginas){
          if(($pagina+1)>=$total_paginas){
              $pagina = $total_paginas - 1;
          }
?>
                                <li class="next"><a href="<?= baseURL .$_SERVER['PHP_SELF']."?q=clientes&pagina=".($pagina+1) ?>">Siguiente &rarr;</a></li>
<?php
         //echo '<a href="'. baseURL .$_SERVER['PHP_SELF'].'?q=clientes&pagina='.($pagina+1).'"><span class="glyphicon glyphicon-arrow-right"></span></a>';
    }
}
?>                                
                            </ul>
                    </th>
                </tr>
                <tr>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Ops</th>
                </tr>
                </thead>
<?php
$listado = $cliente->listadoCliente($param);
foreach ($listado['datos'] as $key => $value) {
?>
                <tr>
                    <td><?= $key ?> filas = <?= $count?></td>
                    <td><?= $listado['datos'][$key]['nombre']?></td>
                    <td><?= $listado['datos'][$key]['rfc']?></td>
                    <td>
                        <a href="<?= baseURL .$_SERVER['PHP_SELF']."?q=fclientes&id=".$key?>">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        </a>
                    </td>
                </tr>
<?php
}

?>
            </table>
              <div class="panel-footer panel-danger">
                    pie
                </div>
              </div>
          <div id="countdown" data-wow-delay=".3s" data-date="Dec 26, 2016 06:00:00"></div>
          <h2 class="subs-title text-center">Subscribe now to get Recent updates!!!</h2>
          <div class="subcription-info text-center">
            <form class="subscribe_form" action="#" method="post">
              <input required="" value="" placeholder="Enter your email..." class="email" id="email" name="email" type="email">
              <input class="subscribe" name="email" value="Subscribe!" type="submit">
            </form>
            <p class="sub-p">We Promise to never span you.</p>
          </div>
        </div>
      </div>
    </div>
<?php
print "<br>".$listado['query']."<br>";
?>