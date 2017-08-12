<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
      <a class="navbar-brand" href="<?= baseURL ?>"><img src="<?= img ?>ms.png" alt="logo"></a>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Cotización<b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li<?= $active['cotizacionadministracion'] ?>><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=cotizacion&sq=administracion">Administración</a></li>
          <li<?= $active['cotizacionalta'] ?>><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=cotizacion&sq=alta">Captura</a></li>
          <li<?= $active['cotizacionlistado'] ?>><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=cotizacion&r=listado">Listado</a></li>
        </ul>
      </li>        
      
      <li><a href="#">Enlace #2</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Catálogos<b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li<?= $active['clientes'] ?>><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=clientes">Clientes</a></li>
          <li<?= $active['clientesalta'] ?>><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=clientes&sq=alta">Clientes Alta</a></li>
          <li><a href="#">Productos</a></li>
          <li><a href="#">Proveedores</a></li>
          <li class="divider"></li>
          <li><a href="#">Cuentas</a></li>
          <li class="divider"></li>
          <li><a href="#">Seguimiento</a></li>
        </ul>
      </li>
    </ul>
 
    <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Buscar">
      </div>
      <button type="submit" class="btn btn-default">Enviar</button>
    </form>
 
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">Enlace #3</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Paginación <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=<?=$q?>&resultados=10">10</a></li>
          <li><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=<?=$q?>&resultados=20">20</a></li>
          <li><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=<?=$q?>&resultados=30">30</a></li>
          <li class="divider"></li>
          <li><a href="<?= baseURL .$_SERVER['PHP_SELF']?>?q=<?=$q?>&resultados=all">Todos</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>