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
            open: function( event, ui ) {
                //alert("open?");
            },
            focus: function( event, ui ) {
                $( "#estadoID" ).val(ui.item.id);
            },
            change: function( event, ui ) {
                //alert($(this).val());
                $('#nombreestadoID').autocomplete('search');
                //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item:{value:$(this).val()}});


                $( "#nombreestadoID" ).focus();
                
                //$($(this).data('autocomplete').menu.active).find($(this).val()).trigger('click');
                //$(this).data('uiAutocomplete')._trigger('select', 'autocompleteselect', {item:{value:$(this).val()}});
                //$(this).data('uiAutocomplete')._trigger('search');
                //$( "#estadoID" ).val(ui.item.id);
                //$(this).data('uiAutocomplete')._trigger('select', 'autocompleteselect', {item:{value:$(this).val()}});
            }
        } );/*
        $( "#nombremunicipio" ).autocomplete({
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
            minLength:0,
            select: function( event, ui ) {
                $( "#estadoID" ).val(ui.item.id);
                //$( "#nombreestadoID" ).val(ui.item.label);
                //alert("label: "+ui.item.label+"valor: "+ui.item.value);
            }
        } );*/
    } );
    </script>
<script>
    function validar(){
        var correoe = document.getElementById("correoe").value;
        if(correoe.length <= 2){
            $('#correoe').focus();
            return false;
        }
        return true;
    }
    function seleccionar(esto,mcpio,std){
            $('#colonia').val(esto.value);
            $('#nombremunicipio').val(mcpio);
            $('#nombreestadoID').val(std);
            $('#nombreestadoID').data('uiAutocomplete')._trigger('change');
            //$($('#nombreestadoID').data('autocomplete').menu.active).find(std).trigger('click');
            //$($('#nombreestadoID').data('autocomplete').menu.active).find(std).trigger('click');
            //$('#nombreestadoID').data('uiAutocomplete')._trigger('change');
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
                    $('#CP').fadeIn(1000).html(data);
                }
            });
        });
        $('#clienteID').blur(function(){
            $('#clavecliente').html('<img src="<?= img ?>loader.gif" alt="" />').fadeOut(1000);
            var clienteID = $(this).val();
            var dataString = 'id='+clienteID+'&ajax=1';
            $.ajax({
                type: "POST",
                url: "clientes/buscarCliente.php",
                data: dataString,
                success: function(data) {
                    $('#clavecliente').fadeIn(1000).html(data);
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
    $( document ).ready(function() {
        
        $('#CodigoPostal').numeric(true);
        //$('#telefono').numeric(true);
    });
    
    
</script>
<?php
$obj_cliente = new cliente();
switch ($accion) {
    case "add":
        $tituloFormulario = "Agregar Nuevo Cliente";
        break;
    default:
        $tituloFormulario = "Averiguar como entro";
        break;
}
if(isset($enviar) and $enviar === "Guardar"){
    $cliente = $obj_cliente->addCliente($datos);
}
?>
    <div class="content">
        <form role="form" action="<?= baseURL.$_SERVER['REQUEST_URI']?>" method="post" onsubmit="return validar();">
            <div class="panel panel-primary">
                <div class="panel-heading"><?= $tituloFormulario ?></div>
<?php
print "Post";
print_r($_POST);

?>
                <div class="panel-body"> <!-- div primeroo-->
                    <div class="form-group">
                        <label for="clienteID" class="col-lg-2 control-label">Clave Cliente</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[clienteID]" class="form-control" id="clienteID" placeholder="Clave Cliente" tabindex="<?= $i++ ?>" maxlength="30">
                            <div id="clavecliente"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CodigoPostal" class="col-lg-2 control-label">Código Postal</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[CodigoPostal]" class="form-control" id="CodigoPostal" placeholder="Código Postal" tabindex="<?= $i++ ?>" maxlength="7">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-lg-2 control-label">Nombre o Razón Social</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombre]" class="form-control" id="nombre" placeholder="Nombre o Razón Social" tabindex="<?= $i++ ?>" maxlength="90">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfc" class="col-lg-2 control-label">RFC</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[rfc]" class="form-control" id="rfc" placeholder="Registro Federal de Contribuyentes" tabindex="<?= $i++ ?>" maxlength="30">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="calle" class="col-lg-2 control-label">Calle</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[calle]" class="form-control" id="calle" placeholder="Calle" tabindex="<?= $i++ ?>" maxlength="60">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numext" class="col-lg-2 control-label">Número Exterior</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[numext]" class="form-control" id="numext" placeholder="Número Exterior" tabindex="<?= $i++ ?>" maxlength="10">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numint" class="col-lg-2 control-label">Número Interior</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[numint]" class="form-control" id="numint" placeholder="Número Interior" tabindex="<?= $i++ ?>" maxlength="30">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="colonia" class="col-lg-2 control-label">Colonia</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[colonia]" class="form-control" id="colonia" placeholder="Colonia" tabindex="<?= $i++ ?>" maxlength="60">
                            <div id="CP"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estadoID" class="col-lg-2 control-label">Estado</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombreestadoID]" class="form-control" id="nombreestadoID" placeholder="Estado" tabindex="<?= $i++ ?>">
                            <input type="hidden" name="datos[estadoID]" class="form-control" id="estadoID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombremunicipio" class="col-lg-2 control-label">Municipio</label>
                        <div class="col-lg-10">
                            <input type="text" name="datos[nombremunicipio]" class="form-control" id="nombremunicipio" placeholder="Municipio" tabindex="<?= $i++ ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-lg-2 control-label">Teléfono</label>
                        <div class="col-lg-10">
                            <input type="tel" name="datos[telefono]" class="form-control" id="telefono" placeholder="Teléfono" tabindex="<?= $i++ ?>" maxlength="21">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="correoe" class="col-lg-2 control-label">Correo Electrónico</label>
                        <div class="col-lg-10">
                            <input type="email" name="datos[correoe]" class="form-control" id="correoe" placeholder="Correo Electrónico" tabindex="<?= $i++ ?>" maxlength="80">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-default" name="enviar" id="enviar" value="Guardar">Guardar</button>
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