<?= $imf++ ?>
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
             alert(ui.item.id);
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
    </script>
<script>
    $(document).ready(function() {
        $('#telefonoc').numeric(',');
        $('#CodigoPostal').numeric(true);
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
        $('#nombre').blur(function(){
            $('#nombreencontrado').html('<img src="<?= img ?>loader.gif" alt="" />').fadeOut(1000);
            var nombre = $(this).val();
            var dataString = 'nombre='+nombre+'&ajax=1';
            $.ajax({
                type: "POST",
                url: "clientes/buscarCliente.php",
                data: dataString,
                success: function(data) {
                    if(data==="si"){
                        alert("Cliente Registrado la ventana se cerrara.")
                        $(".close").click();
                    }else{
                    }
                }
            });
        });
    });
    function seleccionar(esto,mcpio,std){
            $('#colonia').val(esto.value);
            $('#nombremunicipio').val(mcpio);
            $('#nombreestadoID').val(std);
            $('#nombreestadoID').data('uiAutocomplete')._trigger('change');
    }
    function clean(){
        $('#CodigoPostal').val("");
        $('#colonia').val("");
        $('#correoe').val("");
        $('#nombre').val("");
        $('#rfc').val("");
        $('#calle').val("");
        $('#numext').val("");
        $('#estadoID').val("");
        $('#nombreestadoID').val("");
        $('#nombremunicipio').val("");
        $('#telefonoc').val("");
        $('#CP').empty();
    }
    
    function submitContactForm(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+.)+[A-Z]{2,4}$/i;
    var CodigoPostal = $('#CodigoPostal').val();
    var colonia = $('#colonia').val();
    var correoe = $('#correoe').val();
    var nombre = $('#nombre').val();
    var rfc = $('#rfc').val();
    var calle = $('#calle').val();
    var numext = $('#numext').val();
    var estadoID = $('#estadoID').val();
    var nombremunicipio = $('#nombremunicipio').val();
    var telefonoc = $('#telefonoc').val();
    if(CodigoPostal.trim() == '' ){
        alert('Falta el Código Postal.');
        $('#CodigoPostal').focus();
        return false;
    }else if(colonia.trim() == '' ){
        alert('Falta elegir la colonia');
        $('#colonia').focus();
        return false;
    }else if(nombre.trim() == '' ){
        alert('Falta el nombre o razón social');
        $('#nombre').focus();
        return false;
    }else if(rfc.trim() == '' ){
        alert('Falta el Registro Federal de Contribuyentes');
        $('#rfc').focus();
        return false;
    }else if(calle.trim() == '' ){
        alert('Falta la calle');
        $('#calle').focus();
        return false;
    }else if(numext.trim() == '' ){
        alert('Falta el número exterior');
        $('#numext').focus();
        return false;
    }else if(estadoID.trim() == '' ){
        alert('Falta el estado');
        $('#estadoID').focus();
        return false;
    }else if(nombremunicipio.trim() == '' ){
        alert('Falta el Municipio');
        $('#nombremunicipio').focus();
        return false;
    }else if(telefonoc.trim() == '' ){
        alert('Falta el teléfono');
        $('#telefonoc').focus();
        return false;
    }else if(correoe.trim() == '' ){
        alert('Falta el Correo Electrónico');
        $('#correoe').focus();
        return false;
    }else if(correoe.trim() != '' && !reg.test(correoe)){
        alert('El correo no es válido');
        $('#correoe').focus();
        return false;
    }else{
        $.ajax({
            type:'POST',
            url:'clientes/controllerCliente.php',
            dataType: "json",
            data:{
                funcion: "addCliente",
                nombre: $('#nombre').val(),
                rfc: $('#rfc').val(),
                calle: $('#calle').val(),
                numext: $('#numext').val(),
                numint: $('#numint').val(),
                colonia: $('#colonia').val(),
                CodigoPostal: $('#CodigoPostal').val(),
                estadoID: $('#estadoID').val(),
                nombremunicipio: $('#nombremunicipio').val(),
                telefono: $('#telefonoc').val(),
                correoe: $('#correoe').val()
            },
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(data){
                //alert(data);
                $.each(data, function( index, value ) {
                    $('#clienteID').val(data[index].clienteID);
                    $('#clavecliente').val(data[index].clienteNombre);
                    $('#direccion').val(data[index].direccion);
                    $('#telefono').val(data[index].telefono);
                    //alert(data[index].clienteID);
                });
                
                
                
                clean();
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
                $(".close").click();
            }
        });
    }
}
</script>
<!-- Button to trigger modal -->
<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
    Capturar Cliente
</button>

<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Alta de Cliente</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form">
                    <div class="row">
                        <div class="form-group">
                            <label for="CodigoPostal" class="col-lg-3 control-label">Código Postal</label>
                            <div class="col-lg-9">
                                <input type="text" name="datos[CodigoPostal]" class="form-control" id="CodigoPostal" placeholder="Código Postal" tabindex="<?= $imf++ ?>" maxlength="7">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="colonia" class="col-lg-3 control-label">Colonia</label>
                            <div class="col-lg-9">
                                <input type="text" name="datos[colonia]" class="form-control" id="colonia" placeholder="Colonia" tabindex="<?= $i++ ?>" maxlength="60">
                            </div>
                        </div>
                    </div>
                    <div id="CP"></div>
                    <div class="row">
                    <div class="form-group">
                        <label for="nombre" class="col-lg-4 control-label">Nombre o Razón Social</label>
                        <div class="col-lg-8">
                            <input type="text" name="datos[nombre]" class="form-control" id="nombre" placeholder="Nombre o Razón Social" tabindex="<?= $i++ ?>" maxlength="90">
                        </div>
                        <div id="nombreencontrado"></div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="rfc" class="col-lg-3 control-label">RFC</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[rfc]" class="form-control" id="rfc" placeholder="Registro Federal de Contribuyentes" tabindex="<?= $i++ ?>" maxlength="30">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="calle" class="col-lg-3 control-label">Calle</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[calle]" class="form-control" id="calle" placeholder="Calle" tabindex="<?= $i++ ?>" maxlength="60">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="numext" class="col-lg-3 control-label">Número Exterior</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[numext]" class="form-control" id="numext" placeholder="Número Exterior" tabindex="<?= $i++ ?>" maxlength="10">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="numint" class="col-lg-3 control-label">Número Interior</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[numint]" class="form-control" id="numint" placeholder="Número Interior" tabindex="<?= $i++ ?>" maxlength="30">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="estadoID" class="col-lg-3 control-label">Estado</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[nombreestadoID]" class="form-control" id="nombreestadoID" placeholder="Estado" tabindex="<?= $i++ ?>">
                            <input type="hidden" name="datos[estadoID]" class="form-control" id="estadoID">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="nombremunicipio" class="col-lg-3 control-label">Municipio</label>
                        <div class="col-lg-9">
                            <input type="text" name="datos[nombremunicipio]" class="form-control" id="nombremunicipio" placeholder="Municipio" tabindex="<?= $i++ ?>">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="telefono" class="col-lg-3 control-label">Teléfono</label>
                        <div class="col-lg-9">
                            <input type="tel" name="datos[telefono]" class="form-control" id="telefonoc" placeholder="Teléfono" tabindex="<?= $i++ ?>" maxlength="21">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                        <label for="correoe" class="col-lg-3 control-label">Correo Electrónico</label>
                        <div class="col-lg-9">
                            <input type="email" name="datos[correoe]" class="form-control" id="correoe" placeholder="Correo Electrónico" tabindex="<?= $i++ ?>" maxlength="80">
                            <div class="hide" id="correoealert">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error</strong> El Correo Eléctronico no tiene el formato adecuado.
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>
            </div>
        </div>
    </div>
</div>
