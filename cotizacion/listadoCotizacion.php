<script>
    $( document ).ready(function() {
        cargar();
        function cargar(){
            $.ajax({
                method: "POST",
                url: "<?= baseURL ?>/controller/controllerCotizacion.php",
                data: { accion: "cargarCotizaciones"}
            })
            .done(function( msg ) {
                alert( "Data Saved: " + msg );
            });            
        }
    });
</script>
<?php
?>
<div class="container-fluid">
    <div class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">LISTADO DE COTIZACIONES</div>
            <div class="panel-body">
                <ul class="pagination">
                    <li class="disabled"><a href="#"><span class="glyphicon glyphicon-backward"></span></a></li>
                    <li><a href="#">1</a></li>
                    <li class="active"><span>2<span class="sr-only">(página actual)</span></span></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-forward"></span></a></li>
                </ul>


            </div>
            <table class="table table-bordered" id="listado_cotizacion">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>PRESUPUESTO</th>
                        <th>FECHA</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">Panel Footer</div>
</div>


    </div><!-- content-->
</div><!-- container-->