<?php

function envio_lima()
{
    $query_departamentos = "SELECT * FROM departamentos";
    $departamentos = obtener_todo($query_departamentos);
    ?>
<div class="pedidos">
    <div class="pedido top">
        <div class="pedido_num">Id</div>
        <div class="pedido_fecha">Nombres</div>
        <div class="pedido_acciones">Costo Envio</div>
    </div>
    <?php
    foreach ($departamentos as $departamento) {
        ?>
    <div class="pedido">    
        <div class="pedido_num"><?php echo $departamento['id_departamentos'] ?></div>
        <div class="pedido_fecha"><?php echo $departamento['nombre_departamento'] ?></div>
        <div class="pedido_acciones">
            <input type="text" name="costo[]" value="<?php echo $departamento['costo_envio'] ?>">
            <input type="hidden" name="iddep[]" value="<?php echo $departamento['id_departamentos'] ?>">
        </div>
    </div>
        <?php
    }
    ?>
    <div class="botonera">
        <button class="acc_btn">Actualizar Costos de envío</button>
    </div>

    <div id="respuesta">este texto</div>
</div>
<script type="text/javascript">
    $(".acc_btn").on("click",function(){
        var costo = [];
        var iddep = [];
        valores_array('input[name="costo[]"]', costo);
        valores_array('input[name="iddep[]"]', iddep);
        function valores_array(valor, det_array){
            $(valor).each(function() {
                //console.log($(this).val());
                det_array.push($(this).val());
                //console.log(det_array);
            })
        }
        $.ajax({
            url: 'envio_departamentos.php',
            type: 'post',
            data: {
                'costo': JSON.stringify(costo),
                'iddep':JSON.stringify(iddep),
                'enviodep':'enviodep'
            },
            success: function(response) {
                // La llamada AJAX se completó con éxito
                console.log('Respuesta del servidor:', response);
                if(response == "bien"){
                    $("#respuesta").html("Se actualizaron los datos"); 
                    $("#respuesta").show();
                    setTimeout(function() {
                        $("#respuesta").fadeOut("slow");
                    },2000);
                    console.log(response);
                }
            },
            error: function(xhr, status, error){
                $("#respuesta").html("Nada"); 
                console.error('Error en la llamada AJAX:', error);
            }
        })
    })
</script>
    <?php
}

function envio_provincias()
{
    ?>
<div class="pedidos">
    envio Provincia
</div>
    <?php
}

function envio_express()
{
    ?>
<div class="pedidos">
    envio Express
</div>
    <?php
}
