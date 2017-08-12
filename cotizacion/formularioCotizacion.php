<script type="text/javascript">
      $().ready(function() {
          var disablebuscarCliente = false;
        $( "#clavecliente" ).autocomplete({
            source: function( request, response ) {
                
            $.ajax( {
                url: "controller/controllerCotizacion.php",
                dataType: "json",
                open: function (event, ui) {
                    disablebuscarCliente = true;
                },
                close: function (event, ui) {
                    disablebuscarCliente = false;
                    $(this).focus();
                },
                data: {
                    clienteNombre: request.term+"%",
                    operador: "LIKE",
                    accion: "buscarCliente"
                },
                success: function( data ) {
                    //alert(data.nombre+data.clienteID);
                    response( data );
                },
                statusCode: {
                    200: function() {
                        //alert( "page not found" );
                    },
                    400: function() {
                        alert( "Server understood the request, but request content was invalid." );
                    },
                    401: function() {
                        alert( "Acceso no autorizado." );
                    },
                    500: function() {
                        alert( "Internal server error." );
                    },
                    503: function() {
                        alert( "Service unavailable." );
                    },
                    403: function() {
                        alert( "Forbidden resource can't be accessed." );
                    }
                },
                error: function(e, x,  exception){
                    var message;
                    var statusErrorMap = {
                        '400' : "El servidor entiende la solicitud, pero el contenido de la solicitud no es válido..",
                        '401' : "Acceso no autorizado.",
                        '403' : "No se puede acceder al recurso prohibido.",
                        '500' : "Error Interno del Servidor.",
                        '503' : "Servicio no disponible"
                    };
                    if (x.status) {
                        message =statusErrorMap[x.status];
                        if(!message){
                            message="Error desconocido \n.";
                        }
                    }else if(exception=='parsererror'){
                        message="Información Obtenida Inválida.";
                    }else if(exception=='timeout'){
                        message="Tiempo de repuesta agotado";
                    }else if(exception=='abort'){
                        message="Consulta rechazada por el servidor";
                    }else {
                        message="Error desconocido \n.";
                    }
                    
                    alert(message);
                    //alert("e -"+e+"- x-"+ x+"- exception -"+ exception+"-");
                    //alert(' Error! '+xhr+' Error! '+ ajaxOptions+' Error! '+ thrownError );
                    //Error!statusError!200
                    //$.each(xhr, function( index, value ) {
                        //alert(data.bien[index1].motivo);
                        
                        //$('#'+data.bien[index1].div+'').toggleClass("hide");
                        //$('#'+data.bien[index1].div+'').removeClass( "show" ).addClass( "hide" );
                       // $('#'+data.bien[index1].div+'').empty();
                        //$('#'+data.bien[index1].div+'').removeClass("show").addClass("hide");
                        //alert('Error!'+index+'Error!'+ value );
                    //});
                }
            } );
            },
            minLength:0,
            select: function( event, ui ) {
                //$(this).val(ui.item.nombre);
                //alert("label "+ui.item.label+" value "+ui.item.value);
                $( "#direccion" ).val(ui.item.direccion);
                $( "#telefono" ).val(ui.item.telefono);
                $( "#clienteID" ).val(ui.item.clienteID);
                disablebuscarCliente = true;
            }
        })
        .blur(function(){
            if(!disablebuscarCliente){
                //alert($(this).val()); //este es el bueno
                $( "#dialog" ).dialog( "open" );
                //$("#tags").val($('ul.ui-autocomplete li:first a').text());
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append( "<div>" +"("+item.clienteID+")"+item.clienteNombre+ "</div>" )
            .appendTo( ul );
    };
    $( "#p_codigo" ).autocomplete({
            source: function( request, response ) {
            $.ajax( {
                //url: "<?= baseURL ?>/productos/buscarProducto.php",
                url: "controller/controllerCotizacion.php",
                dataType: "json",
                data: {
                    codigo: request.term,
                    accion: "buscarProducto" 
                },
                success: function( data ) {
                    //alert(data.nombre+data.clienteID);
                    response( data );
                },
                error: function(){
                    alert('Error!');
                }
            } );
            },
            minLength:0,
            select: function( event, ui ) {
                //$(this).val(ui.item.nombre);
                //alert("label "+ui.item.label+" value "+ui.item.value);
                $( "#p_codigoID" ).val(ui.item.codigoID);
                $( "#p_descripcion" ).val(ui.item.descripcion);
                $( "#p_preciolista" ).val(ui.item.preciolista);
                $( "#p_preciodescuento" ).val(ui.item.preciolista);
            }
        } )
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append( "<div>" +"("+item.codigoID+")"+item.descripcion+ "</div>" )
            .appendTo( ul );
    };
    } );
    </script>
<script type="text/javascript">
    //establecer tipos de datos para los campos
    $(document).ready(function() {
        $("#enviar").click(function(){
            $.ajax({
                type: "POST",
                //url: "cotizacion/controller.php",
                url: "controller/controllerCotizacion.php",
                dataType: "json",
                data:$("#formCotizacion").serialize(), 
                success: function(data) {
                    
                    $.each(data.correctos, function( index1, value1 ) {
                        //$('#'+data.correctos[index1].div+'').empty();
                        $('#'+value1+'div').empty();
                        $('#'+value1+'div').removeClass("show").addClass("hide");
                    });
                    $.each(data.errores, function( index, value ) {
                        $('#'+data.errores[index].div+'').empty();
                        $('#'+data.errores[index].div+'').removeClass("hide").addClass("show");
                        $('#'+data.errores[index].div+'').append(data.errores[index].motivo);
                    });
                    //$("#claveclientediv").append();
                    //alert(data.errores[0].campo);
                },
                error: function(){
                    alert('Error!');
                }
            })
            .done(function(data) {
                if(data.cotizacion.resultado){
                    $("#cotizacionID").val(data.cotizacionID);
                    $("#formCotizacion").submit();
                }else{
                }
                
                
            });            
        });
        
        $('#telefono').numeric(',');
        $('#p_sol').numeric(true);
        $('#horas').numeric(true);
        $('#p_preciolista').numeric('.');
        $('#p_preciodescuento').numeric('.');
    });
    
    function validar(){
        var sol = document.getElementById("sol").value;
        var dp = document.getElementById("dp").value;
        alert(sol);
        if((sol.length <= 0)){
            alert("que pedo");
            return false;
        }
        return true;
    }
    function seleccionar(esto,mcpio,std){
            $('#colonia').val(esto.value);
            $('#nombremunicipio').val(mcpio);
            $('#nombreestadoID').val(std);
            $('#nombreestadoID').data('uiAutocomplete')._trigger('change');
    }
    function editarpartida(valor){
        $('#p_sol').val($("#partidas"+valor+"-sol").val());
        $('#p_horas').val($("#partidas"+valor+"-horas").val());
        $('#p_codigo').val($("#partidas"+valor+"-codigo").val());
        $('#p_codigoID').val($("#partidas"+valor+"-codigoID").val());
        $('#p_descripcion').val($("#partidas"+valor+"-descripcion").val());
        $('#p_preciolista').val($("#partidas"+valor+"-preciolista").val());
        $('#p_preciodescuento').val($("#partidas"+valor+"-preciodescuento").val());
        $('#addpartida').val('editPartida');
        $('#p_sol').focus();
    }
    function eliminarpartida(valor){
        var partida = {
            accion: 'delPartida',
            partida: valor
        };
        $.ajax({
            type: "POST",
            url: "controller/controllerCotizacion.php",
            //dataType: "json",
            data:{
                accion: 'delPartida',
                partida: valor
            },
            success: function(data) {
                //$('#partidas').removeClass("hide").addClass("show");
                $('#partidas tbody').empty();
                $('#partidas tbody').append(data);
            },
                error: function(){
                    alert('Error!');
                }
        });
    };
    $(document).ready(function() {
        function clean() {
            $('#p_sol').val('');
            $('#p_horas').val('');
            $('#p_codigo').val('');
            $('#p_codigoID').val('');
            $('#p_descripcion').val('');
            $('#p_preciolista').val('');
            $('#p_preciodescuento').val('');
            $('#addpartida').val('addPartida');
            $('#p_sol').focus();
        }
        $('#vaciarPartidas').click(function(){
            $.ajax({
                type: "POST",
                url: "controller/controllerCotizacion.php",
                //dataType: "json",
                data: {accion: 'emptyPartida'}, 
                success: function(data) {
                    $('#partidas').removeClass("hide").addClass("show");
                    $('#partidas tbody').empty();
                    clean();
                },
                error: function(){
                    alert('Error!');
                }
            });            
        });
        $('#refreshPart').click(function(){
            $.ajax({
                type: "POST",
                url: "controller/controllerCotizacion.php",
                //dataType: "json",
                data: {accion: 'cargarPartidas'}, 
                success: function(data) {
                        $('#partidas').removeClass("hide").addClass("show");
                        $('#partidasdiv').empty();
                        $('#partidasdiv').removeClass("hide").addClass("show");
                        $('#partidas tbody').empty();
                        $('#partidas tbody').append(data);
                },
                error: function(){
                    alert('Error!');
                }
            });            
        });
        
        $('#addpartida').click(function(){
            $('#ver').html('<img src="<?= img ?>loader.gif" alt="" />').fadeOut(1000);
            var partida = {
                sol: $('#p_sol').val(), 
                horas: $('#p_horas').val(), 
                codigo: $('#p_codigo').val(), 
                codigoID: $('#p_codigoID').val(), 
                descripcion: $('#p_descripcion').val(), 
                preciolista: $('#p_preciolista').val(), 
                preciodescuento: $('#p_preciodescuento').val()
            };
            if(((partida.sol.length >=1) || (partida.horas.length >=1)) && (partida.codigo.length >=1)){
                $.ajax({
                    type: "POST",
                    url: "controller/controllerCotizacion.php",
                    //dataType: "json",
                    data:{
                        accion: $(this).val(),
                        partida
                    },
                    success: function(data) {
                        //$('#partidas').empty();
                        $('#partidas').removeClass("hide").addClass("show");
                        $('#partidasdiv').empty();
                        $('#partidasdiv').removeClass("show").addClass("hide");
                        $('#partidas tbody').empty();
                        $('#partidas tbody').append(data);
                        clean();
                    },
                error: function(){
                    alert('Error!');
                }
                })
                .done(function() {
                });
            }else{
                alert("Le falta información a la Partida");
            }
        });
        $.datepicker.setDefaults($.datepicker.regional['es-MX']);
        $( "#fecha" ).datepicker({
            dateFormat:'yy-mm-dd',
            inline: true
            , altField: '#fecha_texto'
            , altFormat: "DD, d 'de' MM 'de' yy"
        });
        $("input").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toUpperCase());
            },50);
        });
        $( "#dialog" ).dialog({
            autoOpen: false,
            width: 400,
            modal: true,
            buttons: [
                {
                    text: "Ok",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
            ]
        });
        $( "#dialog-link" ).click(function( event ) {
            $( "#dialog" ).dialog( "open" );
            event.preventDefault();
        });
    });
    
</script>
<?php
$hoy = getdate();
$fecha = $hoy['mday']."-".$hoy['mon']."-".$hoy['year'];
switch ($sq) {
    case "alta":
        $tituloFormulario = "Agregar Nueva Cotización";
        break;
    default:
        $tituloFormulario = "Averiguar como entro";
        break;
}
?>
<div class="content"><?= baseURL.$_SERVER['PHP_SELF']?>?q=cotizacion&sq=alta
    
    
    
<div id="dialog" title="Agregar Nuevo Cliente">
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div>
    <form role="form" action="<?= baseURL.$_SERVER['PHP_SELF']?>?q=cotizacion&sq=alta&r=edcotizacion" method="post" id="formCotizacion">
        <input type="hidden" name="accion" id="accion" value="grabarCotizacion">
        <input type="hidden" name="cotizacionID" id="cotizacionID">
        <div class="panel panel-primary">
            <div class="panel-heading"><?= $tituloFormulario ?></div>
            <div class="panel-body"> <!-- div primeroo-->
<?php
print_r($_POST);
?>
            </div> <!-- div primeroo-->
                <table class="table-bordered">
                    <tr>
                        <td><img><img src="<?= img ?>logo2.png" alt="logo"></td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>
                                        <table class="table">
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="clienteID" class="col-lg-3 control-label">Cliente
    <button id="dialog-link" class="btn btn-success" title="Agregar Cliente">
            <span class="glyphicon glyphicon-user" title="Agregar Cliente"></span>
    </button>
    </label>
    <div class="col-lg-9">
        <input type="text" name="datos[clavecliente]" value="<?=$values['datos']['clavecliente'] ?>" class="form-control" id="clavecliente" placeholder="Nombre del Cliente" tabindex="<?= $i++ ?>" maxlength="90" size="60">
        <input type="hidden" name="datos[clienteID]" class="form-control" id="clienteID" value="<?=$values['datos']['clienteID'] ?>">
        <div class="hide" id="claveclientediv">
        </div>
    </div>
</div>                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="solicito" class="col-lg-2 control-label">Solicito</label>
    <div class="col-lg-10">
        <input type="text" name="datos[solicito]" value="<?=$values['datos']['solicito'] ?>" class="form-control" id="solicito" placeholder="Quien Solicito" tabindex="<?= $i++ ?>" maxlength="80" size="60">
        <div class="hide" id="solicitodiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="solicito" class="col-lg-2 control-label">Dirección</label>
    <div class="col-lg-10">
        <input type="text" name="datos[direccion]" value="<?=$values['datos']['direccion'] ?>" class="form-control" id="direccion" placeholder="Dirección" tabindex="<?= $i++ ?>" maxlength="250" size="60">
        <div class="hide" id="direcciondiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="telefono" class="col-lg-2 control-label">Teléfono</label>
    <div class="col-lg-10">
        <input type="text" name="datos[telefono]" value="<?=$values['datos']['telefono'] ?>" class="form-control" id="telefono" placeholder="Teléfono 9932112112,9932112112" tabindex="<?= $i++ ?>" maxlength="21" size="60">
        <div class="hide" id="telefonodiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table">
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="motor" class="col-lg-4 control-label">Motor</label>
    <div class="col-lg-8">
        <input type="text" name="datos[motor]" value="<?=$values['datos']['motor'] ?>" class="form-control" id="motor" placeholder="Motor" tabindex="<?= $i++ ?>" maxlength="30" size="20">
        <div class="hide" id="motordiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="lancha" class="col-lg-4 control-label">Lancha</label>
    <div class="col-lg-8">
        <input type="text" name="datos[lancha]" value="<?=$values['datos']['lancha'] ?>" class="form-control" id="lancha" placeholder="Lancha" tabindex="<?= $i++ ?>" maxlength="30" size="20">
        <div class="hide" id="lanchadiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="requisicion" class="col-lg-4 control-label">Requ.</label>
    <div class="col-lg-8">
        <input type="text" name="datos[requisicion]" value="<?=$values['datos']['requisicion'] ?>" class="form-control" id="requisicion" placeholder="Requisición" tabindex="<?= $i++ ?>" maxlength="30" size="20">
        <div class="hide" id="requisiciondiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="horas" class="col-lg-4 control-label">Horas</label>
    <div class="col-lg-8">
        <input type="text" name="datos[horas]" value="<?=$values['datos']['horas'] ?>" class="form-control" id="horas" placeholder="Horas" tabindex="<?= $i++ ?>" maxlength="30" size="20">
        <div class="hide" id="horasdiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><table class="table">
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="presupuesto" class="col-lg-3 control-label">Presupuesto</label>
    <div class="col-lg-10">
        <input type="text" name="datos[presupuesto]" value="Nuevo" class="form-control" id="presupuesto" placeholder="Presupuesto" tabindex="<?= $i++ ?>" maxlength="30" size="10">
        <div class="hide" id="presupuestodiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
<div class="form-group">
    <label for="fecha" class="col-lg-3 control-label">Fecha</label>
    <div class="col-lg-10">
        <input type="date" name="datos[fecha]" value="<?=$values['datos']['fecha'] ?>" class="form-control" id="fecha" placeholder="Fecha" tabindex="<?= $i++ ?>" maxlength="30" size="10">
        <div class="hide" id="fechadiv">
        </div>
    </div>
</div>
                                                </td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" id="refreshPart" class="btn btn-success" title="Mostrar Partidas">
                                <span class="glyphicon glyphicon-th-list" title="Mostrar Partidas"></span>
                            </button>
                            <table class="table-bordered hide" id="partidas">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="col-lg-2 text-center" style="height: 30px"><span class="label label-primary">CANTIDAD</span></th>
                                        <th class="col-lg-2 text-center"><span class="label label-primary">CODIGO</span></th>
                                        <th class="col-lg-4 text-center"><span class="label label-primary">DESCRIPCION</span></th>
                                        <th class="col-lg-1 text-center"><span class="label label-primary">PRECIO P</span></th>
                                        <th class="col-lg-1 text-center"><span class="label label-primary">PRECIO ESP</span></th>
                                        <th class="col-lg-1 text-center"><span class="label label-primary">IMPORTE</span></th>
                                        <th class="col-lg-1 text-center"><span class="label label-primary">OPCIONES</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div id="partidasdiv" class="hide"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table-bordered b">
                                <tr class="text-center">
                                    <td colspan="2" class="col-lg-2" style="height: 30px"><span class="label label-default">CANTIDAD</span></td>
                                    <td class="col-lg-3"><span class="label label-default">CODIGO</span></td>
                                    <td class="col-lg-4"><span class="label label-default">DESCRIPCION</span></td>
                                    <td class="col-lg-1"><span class="label label-default">PRECIO P</span></td>
                                    <td class="col-lg-1"><span class="label label-default">PRECIO ESP</span></td>
                                    <td class="col-lg-1"><span class="label label-default">OPCIONES</span></td>
                                </tr>
                                <tr>                                    
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_sol[]" class="form-control" id="p_sol" placeholder="Solicitadas" tabindex="<?= $i++ ?>" maxlength="5" size="3">
    </div>
</div>
                                    </td>
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_horas[]" class="form-control" id="p_horas" placeholder="Horas" tabindex="<?= $i++ ?>" maxlength="5" size="3">
    </div>
</div>
                                    </td>
                                    
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_codigo[]" class="form-control" id="p_codigo" placeholder="Código" tabindex="<?= $i++ ?>" maxlength="21" size="10">
        <input type="hidden" name="p_codigoID[]" class="form-control" id="p_codigoID">
    </div>
</div>
                                    </td>
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_descripcion[]" class="form-control" id="p_descripcion" placeholder="Descripción" tabindex="<?= $i++ ?>" maxlength="60" size="30">
    </div>
</div>
                                    </td>
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_preciolista[]" class="form-control" id="p_preciolista" placeholder="Precio de Lista" tabindex="<?= $i++ ?>" maxlength="60" size="20">
    </div>
</div>
                                    </td>
                                    <td>
<div class="form-group">
    <div class="col-lg-12">
        <input type="text" name="p_preciodescuento[]" class="form-control" id="p_preciodescuento" placeholder="Precio Especial" tabindex="<?= $i++ ?>" maxlength="60" size="20">
    </div>
</div>
                                    </td>
                                    <td class="text-left">
<div class="form-group">
    <div class="col-lg-12">
        <button type="button" class="btn btn-default" name="addpartida" id="addpartida" value="addPartida">Añadir Partida</button>
    </div>
</div>
                                    </td>
                                </tr>
                                <tr>
                            </table>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
<div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
        <button type="button" class="btn btn-default" name="enviar" id="enviar" value="grabarCotizacion">Guardar</button>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-12">
        <button type="button" class="btn btn-default" name="vaciarPartidas" id="vaciarPartidas" value="1">Vaciar Partidas</button>
    </div>
</div>
                        </td>
                    </tr>
                </table>                    
                <div class="panel-footer panel-danger">
                    pie
                </div>
        </div>
        </form>
    </div>
<div id="sesion"></div>
<?php
include(SERVERAIZ."clientes/formularioModal.php");
?>