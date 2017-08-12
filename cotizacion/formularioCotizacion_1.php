<script type="text/javascript">
      $().ready(function() {
        $( "#clavecliente" ).autocomplete({
            source: function( request, response ) {
            $.ajax( {
                url: "<?= baseURL ?>/clientes/buscarCliente.php",
                dataType: "json",
                data: {
                    nombre: request.term
                },
                success: function( data ) {
                    //alert(data.nombre+data.clienteID);
                    response( data );
                }
            } );
            },
            minLength:0,
            select: function( event, ui ) {
                //$(this).val(ui.item.nombre);
                //alert("label "+ui.item.label+" value "+ui.item.value);
                $( "#clienteID" ).val(ui.item.clienteID);
            }
        } )
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append( "<div>" +"("+item.clienteID+")"+item.nombre+ "</div>" )
            .appendTo( ul );
    };
    $( "#p_codigo" ).autocomplete({
            source: function( request, response ) {
            $.ajax( {
                url: "<?= baseURL ?>/productos/buscarProducto.php",
                dataType: "json",
                data: {
                    codigo: request.term
                },
                success: function( data ) {
                    //alert(data.nombre+data.clienteID);
                    response( data );
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
    $( document ).ready(function() {
        $('#preciodescuento').blur(function(){
            var importe = $(this).val() * $('#sol').val();
            $('#importe').val(importe);
        });
        $('#telefono').numeric(',');
        $('#sol').numeric(true);
        $('#horas').numeric(true);
        $('#p_preciolista').numeric('.');
        $('#p_preciodescuento').numeric('.');
    });
    function validar(){
        var sol = document.getElementById("sol").value;
        var dp = document.getElementById("dp").value;
        alert(sol);
        if((sol.length <= 0)){
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
    function addfila(campo,valor) {
            var nuevaFila = "<tr>";
            //valor.preventDefault();
            $.each(valor, function( index, value ) {
                       //addfila(index1,data[index]);
                //alert( "obejto:"+index + "indice"+ value);
                if(typeof(index)==="number"){
                }
                if(index == "codigoID"){
                    nuevaFila+="<input type=\"hidden\" name=\"partidas["+campo+"]["+index+"]\" value=\""+value+"\" class=\"form-control\">";
                }else{
                    nuevaFila+="<td>"+value;
                    nuevaFila+="<input type=\"hidden\" name=\"partidas["+campo+"]["+index+"]\" value=\""+value+"\" class=\"form-control\">";
                    nuevaFila+="</td>"
                    //nuevaFila+="<td>"+index+"-"+value+"</td>";
                }
            });
            nuevaFila+="<td id=\"boton"+campo+"\"><button type=\"button\" class=\"botona btn btn-default\" name=\"ep["+campo+"]\" value =\""+campo+"\" onclick=\"eliminarpartida("+campo+");\"><span class=\"glyphicon glyphicon-pencil\"></span></button>";
            nuevaFila+="<button type=\"button\" class=\"boton btn btn-default\" name=\"dp["+campo+"]\" value =\""+campo+"\" onclick=\"eliminarpartida("+campo+");\"><span class=\"glyphicon glyphicon-trash\"></span></button></td>";
            nuevaFila+="<td id=\"boton"+campo+"\"></td>";
            nuevaFila+="</tr>";
            $('#partidas tbody').append(nuevaFila);
            clean();
        }
        function clean() {
            $('#p_sol').val('');
            $('#p_horas').val('');
            $('#p_codigo').val('');
            $('#p_codigoID').val('');
            $('#p_descripcion').val('');
            $('#p_preciolista').val('');
            $('#p_preciodescuento').val('');
            $('#p_sol').focus();
        }
        function eliminarpartida(valor){
        var partida = {
                funcion: 'delPartida',
                partida: valor
            };
            $.ajax({
                type: "POST",
                url: "cotizacion/controller.php",
                dataType: "json",
                data:{partida}, 
                success: function(data) {
                    $('#partidas').removeClass("hide").addClass("show");
                    $('#partidas tbody').empty();
                    $.each(data, function( index, value ) {
                        addfila(index,value);
                    });
                    //$('#ver').fadeIn(1000).html(data[0].importe+": importe");
                }
            });
    }
    
    $(document).ready(function() {
        $('#vaciarPartidas').click(function(){
            var partida = {
                funcion: 'emptyPartida'
            };
            $.ajax({
                type: "POST",
                url: "cotizacion/controller.php",
                dataType: "json",
                data:{partida}, 
                success: function(data) {
                    $('#partidas').removeClass("hide").addClass("show");
                    $('#partidas tbody').empty();
                }
            });
            
        });
        $('#addpartida').click(function(){
            $('#ver').html('<img src="<?= img ?>loader.gif" alt="" />').fadeOut(1000);
            var partida = {
                funcion: 'addPartida',
                sol: $('#p_sol').val(), 
                horas: $('#p_horas').val(), 
                codigo: $('#p_codigo').val(), 
                codigoID: $('#p_codigoID').val(), 
                descripcion: $('#p_descripcion').val(), 
                preciolista: $('#p_preciolista').val(), 
                preciodescuento: $('#p_preciodescuento').val()
            };
            $.ajax({
                type: "POST",
                url: "cotizacion/controller.php",
                dataType: "json",
                data:{partida}, 
                success: function(data) {
                    $('#partidas').removeClass("hide").addClass("show");
                    $('#partidas tbody').empty();
                    $.each(data, function( index, value ) {
                        addfila(index,value);
                    });
                    $('#ver').fadeIn(1000).html(data[0].importe+": importe");
                }
            });
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
        })
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
if($addpartida or $ep or $dp){
    $values = $_POST;
}
if(isset($enviar) and $enviar === "Guardar"){
    //$cliente = $obj_cliente->addCliente($datos);
}
?>
<div class="content">
    <form role="form" action="<?= baseURL.$_SERVER['PHP_SELF']?>?q=cotizacion&sq=alta" method="post" onsubmit="return validar();">
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
    <label for="clienteID" class="col-lg-2 control-label">Cliente</label>
    <div class="col-lg-10">
        <input type="text" name="datos[clavecliente]" value="<?=$values['datos']['clavecliente'] ?>" class="form-control" id="clavecliente" placeholder="Nombre del Cliente" tabindex="<?= $i++ ?>" maxlength="90" size="60">
        <input type="hidden" name="datos[clienteID]" class="form-control" id="clienteID" value="<?=$values['datos']['clienteID'] ?>">
        <div class="hide" id="claveclientediv">
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Usuario ya registrado
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Solicito
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Dirección
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Teléfono
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Motor
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Motor
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Requisición
            </div>
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
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Horas
            </div>
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
        <input type="text" name="datos[presupuesto]" value="<?=$values['datos']['presupuesto'] ?>" class="form-control" id="presupuesto" placeholder="Presupuesto" tabindex="<?= $i++ ?>" maxlength="30" size="10">
        <div class="hide" id="presupuestodiv">
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Presupuesto
            </div>
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
        <div class="hide" id="presupuestodiv">
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong> Fecha
            </div>
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
                            <table class="table-bordered hide" id="partidas">
                                <thead>
                                    <tr class="text-center">
                                        <th colspan="2" class="col-lg-2" style="height: 30px"><span class="label label-primary">CANTIDAD</span></th>
                                        <th class="col-lg-2"><span class="label label-primary">CODIGO</span></th>
                                        <th class="col-lg-4"><span class="label label-primary">DESCRIPCION</span></th>
                                        <th class="col-lg-1"><span class="label label-primary">PRECIO P</span></th>
                                        <th class="col-lg-1"><span class="label label-primary">PRECIO ESP</span></th>
                                        <th class="col-lg-1"><span class="label label-primary">IMPORTE</span></th>
                                        <th class="col-lg-1"><span class="label label-primary">OPCIONES</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
        <button type="button" class="btn btn-default" name="addpartida" id="addpartida" value="1">Añadir Partida</button>
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
        <button type="submit" class="btn btn-default" name="enviar" id="enviar" value="Guardar">Guardar</button>
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