<script type="text/javascript">
      $().ready(function() {
        $( "#nombreestadoID" ).autocomplete({
            source: function( request, response ) {
            $.ajax( {
                url: "<?= baseURL ?>/clientes/buscarEstadoMexico.php",
                dataType: "json",
                data: {
                    nombre: request.term
                },
                success: function( data ) {
                    response( data );
                }
            } );
            },
            autoFocus: true,
            minLength:0,
            select: function( event, ui ) {
                $( "#estadoID" ).val(ui.item.id);
            },
            focus: function( event, ui ) {
                $( "#estadoID" ).val(ui.item.id);
            },
            change: function( event, ui ) {
                $('#nombreestadoID').autocomplete('search');
                $( "#nombreestadoID" ).focus();
            }
        } );
    } );
    $( document ).ready(function() {
        $("#enviar").click(function(){
            $.ajax({
                type: "POST",
                url: "controller/controllerCliente.php",
                dataType: "json",
                data:$("#form_cliente").serialize(), 
                success: function(data) {
                    if(data.resultado==0){
                        $.each(data.correctos, function( index1, value1 ) {
                            $('#'+value1+'div').empty();
                            $('#'+value1+'div').removeClass("show").addClass("hide");
                        });
                        $.each(data.errores, function( index, value ) {
                            $('#'+data.errores[index].div+'').empty();
                            $('#'+data.errores[index].div+'').removeClass("hide").addClass("show");
                            $('#'+data.errores[index].div+'').append(data.errores[index].motivo);
                        });
                    }else{
                        /*
                        $.each(data, function( index1, value1 ) {
                            alert(index1+ value1);
                        });*/
                    }
                }
            })
            .done(function(data) {
                $("#clienteID").val(data.lastID);
                if(data.resultado){
                    $('div.alert.alert-danger').removeClass("show").addClass("hide");
                    //$("#form_cliente").submit();
                }else{
                }
                
                
            });            
        });
                $('#telefono').numeric(',');
                $('#CodigoPostal').numeric(true);
            });
    function seleccionar(esto,mcpio,std){
            $('#colonia').val(esto.value);
            $('#nombremunicipio').val(mcpio);
            $('#nombreestadoID').val(std);
            $('#nombreestadoID').data('uiAutocomplete')._trigger('change');
    }
    $(document).ready(function() {
        $('#CodigoPostal').blur(function(){
            $('#CP').html('<img src="<?= img ?>loader.gif" alt="" />').fadeOut(1000);
            var CodigoPostal = $(this).val();
            var dataString = 'id='+CodigoPostal+'&ajax=1';
            $.ajax({
                type: "POST",
                url: "clientes/buscarCodigoPostal.php",
                data: dataString,
                success: function(data) {
                    $('#CP').fadeIn(100).html(data);
                }
            });
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
switch ($sq) {
    case "alta":
        $tituloFormulario = "Agregar Nuevo Cliente";
        $cve_cliente['readonly'] = "readonly=\"readonly\"";
        break;
    default:
        $tituloFormulario = "Averiguar como entro";
        break;
}
if(isset($enviar) and $enviar === "Guardar"){
    //$cliente = $obj_cliente->($datos);
}
?>
    <div class="content">
        <!-- <form role="form" action="<?= baseURL.$_SERVER['REQUEST_URI']?>" method="post" onsubmit="return validar();">-->
        <form role="form" action="<?= baseURL.$_SERVER['PHP_SELF']?>?q=fclientes" method="post" id="form_cliente">
            <input type="hidden" name="datos[accion]" value="agregar">
            <input type="hidden" name="clienteID" id="clienteID">
            <div class="panel panel-primary">
                <div class="panel-heading"><?= $tituloFormulario ?></div>
                <div class="panel-body"> <!-- div primeroo-->
                    <div class="form-group">
                        <label for="CodigoPostal" class="col-lg-2 control-label">Código Postal</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[CodigoPostal]" class="form-control" id="CodigoPostal" placeholder="Código Postal" tabindex="<?= $i++ ?>" maxlength="7">
                            <div class="hide" id="CodigoPostaldiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="colonia" class="col-lg-2 control-label">Colonia</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[colonia]" class="form-control" id="colonia" placeholder="Colonia" tabindex="<?= $i++ ?>" maxlength="60">
                            <div id="CP"></div>
                            <div class="hide" id="coloniadiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estadoID" class="col-lg-2 control-label">Estado</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombreestadoID]" class="form-control" id="nombreestadoID" placeholder="Estado" tabindex="<?= $i++ ?>">
                            <input type="hidden" name="datos[estadoID]" class="form-control" id="estadoID">
                            <div class="hide" id="estadoIDdiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombremunicipio" class="col-lg-2 control-label">Municipio</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombremunicipio]" class="form-control" id="nombremunicipio" placeholder="Municipio" tabindex="<?= $i++ ?>">
                            <div class="hide" id="nombremunicipiodiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-lg-2 control-label">Nombre o Razón Social</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombre]" class="form-control" id="nombre" placeholder="Nombre o Razón Social" tabindex="<?= $i++ ?>" maxlength="90">
                            <div class="hide" id="nombrediv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfc" class="col-lg-2 control-label">RFC</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[rfc]" class="form-control" id="rfc" placeholder="Registro Federal de Contribuyentes" tabindex="<?= $i++ ?>" maxlength="30">
                            <div class="hide" id="rfcdiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="calle" class="col-lg-2 control-label">Calle</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[calle]" class="form-control" id="calle" placeholder="Calle" tabindex="<?= $i++ ?>" maxlength="60">
                            <div class="hide" id="callediv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numext" class="col-lg-2 control-label">Número Exterior</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[numext]" class="form-control" id="numext" placeholder="Número Exterior" tabindex="<?= $i++ ?>" maxlength="10">
                            <div class="hide" id="numextdiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numint" class="col-lg-2 control-label">Número Interior</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[numint]" class="form-control" id="numint" placeholder="Número Interior" tabindex="<?= $i++ ?>" maxlength="30">
                            <div class="hide" id="numintdiv"></div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-lg-2 control-label">Teléfono</label>
                        <div class="col-lg-10">
                            <input type="tel" name="datos[telefono]" class="form-control" id="telefono" placeholder="Teléfono formato 9999999999,#########" tabindex="<?= $i++ ?>" maxlength="21">
                            <div class="hide" id="telefonodiv"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="correoe" class="col-lg-2 control-label">Correo Electrónico</label>
                        <div class="col-lg-10">
                            <input type="email" name="datos[correoe]" class="form-control" id="correoe" placeholder="Correo Electrónico" tabindex="<?= $i++ ?>" maxlength="80">
                            <div class="hide" id="correoediv">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" class="btn btn-default" name="enviar" id="enviar" value="Guardar">Guardar</button>
                            <!-- <button type="submit" class="btn btn-default" name="enviar" id="enviar" value="Guardar">Guardar</button>-->
                        </div>
                    </div>
                </div> <!-- div primeroo-->
                <div class="panel-footer panel-danger">
                    pie
                </div>
        </div>
        </form>
    </div>

<div class="alert alert-success" role="alert">
        <strong>Well done!</strong> You successfully read this important alert message.
      </div>
      <div class="alert alert-info" role="alert">
        <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
      </div>
      <div class="alert alert-warning" role="alert">
        <strong>Warning!</strong> Best check yo self, you're not looking too good.
      </div>
      <div class="alert alert-danger" role="alert">
        <strong>Oh snap!</strong> Change a few things up and try submitting again.
      </div>