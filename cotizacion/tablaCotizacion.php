<script>
    $(document).ready(function(){
        cargarCotizacion(<?=$cotizacionID?>);
        function cargarCotizacion(id){
            //var datos = {cotizacionID: id, accion: 'cargarCotizacion'};
            $.ajax({
                type: "POST",
                url: "<?= baseURL?>/controller/controllerCotizacion.php",
                dataType: "json",
                data: {
                    cotizacionID: id,
                    accion: 'cargarCotizacion'
                },
                success: function(data) {
                    $.each(data.cotizacion, function( index, value ) {
                        $.each(value, function( index1, value1 ) {
                            $('#'+index1+'').append(value1);
                            //alert(index1+" - value "+ value1);
                        });
                        //alert(index+" - value "+ value.clienteID);
                    });
                    var nuevaFila,i=0;
                    $.each(data.partidas, function( index, value ) {
                        i++;
                        nuevaFila="<tr>";
                        nuevaFila+="<td class=\"col-lg-1 text-center\">"+i+"</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-center\">";
                        nuevaFila+=value.sol;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-center\">";
                        nuevaFila+=value.horas;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-center\">";
                        nuevaFila+=value.codigo;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-4\">";
                        nuevaFila+=value.descripcion;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-right\">";
                        nuevaFila+=value.preciolista;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-right\">";
                        nuevaFila+=value.preciodescuento;
                        nuevaFila+="</td>";
                        nuevaFila+="<td class=\"col-lg-1 text-right\">";
                        nuevaFila+=value.importe;
                        nuevaFila+="</td>";
                        nuevaFila+="</tr>";
                        $('#partidas tbody').append(nuevaFila);
                    });
                   $.each(data.totales, function( index, value ) {
                       $('#'+index).append(value);
                   });
                    
                }
            });
        }
    });
</script>
<div id="cotizacion">
<table class="table">
    <tr>
        <td colspan="3"><img><img src="<?= img ?>logo2.png" alt="logo"></td>
    </tr>
    <tr>
        <td width="70%">
            <table class="table table-bordered">
                <tr>
                    <td>CLIENTE</td>
                    <td><div id="nombre"></td>
                </tr>
                <tr>
                    <td>SOLICITO</td>
                    <td><div id="solicito"></div></td>
                </tr>
                <tr>
                    <td>DIRECCION</td>
                    <td><div id="direccion"></div></td>
                </tr>
                <tr>
                    <td>TELEFONO</td>
                    <td> <div id="telefono"></div></td>
                </tr>
            </table>
        </td>
        <td width="15%">
            <table class="table table-bordered">
                <tr>
                    <td>MOTOR</td>
                    <td><div id="motor"></div></td>
                </tr>
                <tr>
                    <td>LANCHA</td>
                    <td><div id="lancha"></div></td>
                </tr>
                <tr>
                    <td>REQUISICION</td>
                    <td><div id="requisicion"></div></td>
                </tr>
                <tr>
                    <td>HORAS</td>
                    <td><div id="horas"></div></td>
                </tr>
            </table>
        </td>
        <td width="15%">
            <table class="table table-bordered">
                <tr>
                    <td class="text-center">PRESUPUESTO</td>
                </tr>
                <tr>
                    <td class="text-center"><div id="presupuesto"></div></td>
                </tr>
                <tr>
                    <td class="text-center">FECHA</td>
                </tr>
                <tr>
                    <td class="text-center"><div id="fecha"></div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table class="table table-bordered col-lg-12" id="partidas">
                <thead>
                    <tr>
                        <th class="col-md-1 col-lg-1 text-center"><strong>PARTIDA</strong></th>
                        <th colspan="2" class=" col-md-2 col-lg-2 text-center" style="height: 30px"><strong>CANTIDAD</strong></th>
                        <th class="col-md-2 col-lg-2 text-center"><strong>CODIGO</strong></th>
                        <th class="col-md-4 col-lg-4 text-center"><strong>DESCRIPCION</strong></th>
                        <th class="col-md-1 col-lg-1 text-center"><strong>P LISTA</strong></th>
                        <th class="col-md-1 col-lg-1 text-center"><strong>P DESC</strong></th>
                        <th class="col-md-1 col-lg-1 text-center"><strong>IMPORTE</strong></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="row">
                                <div class="col-lg-1">ENTREGA</div>
                                <div class="col-lg-11">
                                    <ul>
                                        <li>L.A.B. CANCUN</li>
                                        <li>FORMA DE PAGO 70% ANTICIPO Y SALDO PREVIA ENTREGA.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1">TERMINOS</div>
                                <div class="col-lg-11">
                                    <ul>
                                        <li>ENTREGA DE 3 A 4 SEMANAS DISPONIBILIDAD SALVO VENTA PREVIA</li>
                                        <li>PRECIOS SUJETOS A CAMBIO SIN PREVIO AVISO</li>
                                        <li>ESTE PRESUPUESTO SOLAMENTE INCLUYE LO AQUÍ DESCRITO, UNICAMENTE</li>
                                        <li>EN PEDIDOS ESPECIAL NO HAY DEVOLUCIÓN DE ANTICIPO NI DE PRODUCTO</li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="7">
                            <div class="row">
                                <div class="col-sm-8 col-md-6 col-lg-8">
                                    Beneficiario: <strong>MARA MARLIN SA DE CV </strong><br>
                                    SANTANDER MN: <strong>65502846417</strong> CLABE: <strong>014691655028464177</strong><br>
                                    SANTANDER USD: <strong>82500527850</strong> CLABE: <strong>014691825005278501</strong><br>
                                </div>
                                <div class="col-sm-3 col-md-5 col-lg-3"><img src="<?= img ?>/msuplier.png" class="center-block "></div>
                            </div>
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="6" rowspan="3">
                            <div class="row">
                                <div class="col-sm-9 col-md-8 col-lg-6">
                                    Realiza: Francisco José Loaeza Vazquez
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-md-8 col-lg-6">
                                    Tel. Cel: 998-294-01-96 ID NEX: 32*6*38359
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-md-8 col-lg-6">
                                    e-mail: ventas@maramarlin.com suzukimarinocancun@gmail.com
                                </div>
                            </div>
                        </th>
                        <th>SUBTOTAL</th>
                        <th class="col-sm-2 col-md-2 col-lg-1 text-right"><div id="subtotal"></div></th>
                    </tr>
                    <tr>
                        <th>IVA</th>
                        <th class="col-sm-2 col-md-2 col-lg-1 text-right"><div id="iva"></div></th>
                    </tr> 
                    <tr>
                        <th>TOTAL</th>
                        <th class="col-sm-2 col-md-2 col-lg-1 text-right"><div id="total"></div></th>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</table>
</div>