<script>
    $(document).ready(function(){
        $("#imprimir").click(function(){
            var ficha=document.getElementById("cotizacion");
            var ventimp=window.open(' ','_blank');
            $.ajax({
                method: "POST",
                url: "<?= baseURL?>/cotizacion/headCotizacion.php",
                dataType:"html"
            })
            .done(function( msg ) {
                ventimp.document.write(msg);
                ventimp.document.write(ficha.innerHTML);
                ventimp.document.write('</div>\n');
                ventimp.document.write('</div>\n');
                ventimp.document.write('</body>\n');
                ventimp.document.write('</html>'); 
                ventimp.document.close();
                ventimp.print();
            });
        }); 
        $("#imprimi2r").click(function(){
            var ficha=document.getElementById("cotizacion");
            var ventimp=window.open(' ','_blank');
            $.get( "<?= baseURL?>/cotizacion/headCotizacion.php", function( data ) {
                ventimp.document.write(data);
            })
            .done(function() {
                ventimp.document.write(ficha.innerHTML);
                ventimp.document.write('</div>\n');
                ventimp.document.write('</div>\n');
                ventimp.document.write('</body>\n');
                ventimp.document.write('</html>'); 
                ventimp.document.close();
                ventimp.print();
            });
        }); 
        function imprSelec(muestra){
            var ficha=document.getElementById(muestra);
            var ventimp=window.open(' ','_blank');
            $.get( "<?= baseURL?>/cotizacion/headCotizacion.php", function( data ) {
                ventimp.document.write(data);
            })
            .done(function() {
                ventimp.document.write(ficha.innerHTML);
                ventimp.document.write('</div>\n');
                ventimp.document.write('</div>\n');
                ventimp.document.write('</body>\n');
                ventimp.document.write('</html>'); 
                ventimp.document.close();
                ventimp.print();
            });
        }
    });
        function imprSelec2(muestra){
        var ficha=document.getElementById(muestra);
        var ventimp=window.open(' ','_blank');
        ventimp.document.write('<!DOCTYPE html>\n');
        ventimp.document.write('<html lang="es">\n');
        ventimp.document.write('<head>\n');
        ventimp.document.write('<meta charset="utf-8">\n');
        ventimp.document.write('<meta name="viewport" content="width=device-width, initial-scale=1">\n');
        ventimp.document.write('<title>Mara Marlín</title>\n');
        ventimp.document.write('<meta name="description" content="Marine Supplies">\n');
        ventimp.document.write('<meta name="keywords" content="motores, lanchas, etc">\n');
        ventimp.document.write('<link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,400italic,300italic,300|Raleway:300,400,600" rel="stylesheet" type="text/css">\n');
        ventimp.document.write('<link rel="stylesheet" type="text/css" href="http://mmarlin.rvrsi.com.mx/css/font-awesome.min.css" media="print">\n');
        ventimp.document.write('<link rel="stylesheet" type="text/css" href="http://mmarlin.rvrsi.com.mx/css/bootstrap.min.css" media="print">\n');
        ventimp.document.write('<link rel="stylesheet" type="text/css" href="http://mmarlin.rvrsi.com.mx/css/animate.css" media="print">\n');
        ventimp.document.write('<link rel="stylesheet" type="text/css" href="http://mmarlin.rvrsi.com.mx/css/style.css" media="print">\n');
        ventimp.document.write('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" media="print">\n');
        ventimp.document.write('<style type="text/css">');
        ventimp.document.write('@page{\n');
        ventimp.document.write('size:  auto;\n');
        ventimp.document.write('margin: 0mm;\n');
        ventimp.document.write('}\n');
        ventimp.document.write('#principal table td{\n');
        ventimp.document.write('border: 1px solid blue;\n');
        ventimp.document.write('}\n');
        ventimp.document.write('</style>\n');
        ventimp.document.write('</head>\n');
        ventimp.document.write('<body>\n');
        ventimp.document.write('<div class="container">\n');
        ventimp.document.write('<div class="content">\n');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.write('</div>\n');
        ventimp.document.write('</div>\n');
        ventimp.document.write('</body>\n');
        ventimp.document.write('</html>'); 
        ventimp.document.close();
        ventimp.print();
                   
        //
        //ventimp.document.close();
        //ventimp.print();
        //ventimp.close();
    }
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row">
            <div class="col-xs-offset-6 col-sm-offset-6 col-md-offset-6 col-lg-offset-5">
                <button type="button" class="btn btn-info" id="imprimir">Imprimir Cotización</button>
            </div>
        </div>
<?php
include('tablaCotizacion.php');
?>
    
    </div>
</div>
