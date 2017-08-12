<?php
//print_r($_REQUEST);
if(!isset($clienteID)){
    $clienteID = $id;
}

?>
<script>
    $(document).ready(function(){
        cargarCliente(<?=$clienteID?>);
        function cargarCliente(id){
            var datos = {clienteID: id, accion: 'fichaCliente'};
            $.ajax({
                type: "POST",
                url: "controller/controllerCliente.php",
                dataType: "json",
                data: {
                    datos
                },
                success: function(data) {
                    if(data.resultado === 1){
                        $.each(data.datos, function( index, value ) {
                            $.each(value, function( index1, value1 ) {
                                $('#'+index1+'').empty();
                                $('#'+index1+'').append(value1);
                            });
                        });
                    }else{
                        alert ("Error"+data.mensaje);
                    }
                    
                }
            });
        }
    });
</script>
<div class="content">
    <div class="row center-block">
        <div class="panel panel-default">
            <div class="panel-heading"><h3>Datos Cliente</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1"><label>Clave</label></div>
                    <div class="col-md-9"><div id="clienteID"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-1"><label>Nombre</label></div>
                    <div class="col-md-9"><div id="clienteNombre"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-1"><label>RFC</label></div>
                    <div class="col-md-9"><div id="rfc"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-1"><label>Dirección</label></div>
                    <div class="col-md-9"><div id="direccion"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-1"><label>Contácto</label></div>
                    <div class="col-md-9"><b>Teléfono</b> <div id="telefono"></div><b>Correo Eléctronico</b> <div id="correoe"></div></div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Historial Cotizaciones</h3>
            </div>
            <div class="panel-body">
                Contenido del panel
            </div>
        </div>
    </div>
</div>