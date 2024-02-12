<?php

function fondocolor_acc()
{
    $query_fondo_color = "SELECT * FROM fondo_color ";
    $fondos = obtener_todo($query_fondo_color);

    if (isset($_POST['editar_color'])) {
        $idcodigo = $_POST['idcodigo00'];
        $color_sel = $_POST['color_sel'];
        $query_codigo_editar = "UPDATE 
            fondo_color 
            SET 
            data_fondo_color = '$color_sel' 
            WHERE 
            id_fondo_color = $idcodigo";
        actualizar_registro($query_codigo_editar);
        // echo $query_codigo_editar;
    }

    foreach ($fondos as $row) {
        $nombre_fondo_color = $row['nombre_fondo_color'];
        $id_fondo_color = $row['id_fondo_color'];
        $data_fondo_color = $row['data_fondo_color'];
        ?>
<script type="text/javascript" src="js/picker/colorpicker.js"></script>
<link rel="stylesheet" href="css/picker/colorpicker.css" type="text/css">
<div class="titulo_prod"><?php echo $nombre_fondo_color ?></div>

<div class="color_fon">
<form 
    class="marquesina_form" 
    action="promocion.php?menu_lat=20" 
    method="post" 
    enctype="multipart/form-data" 
    id="frmedit<?php echo $id_fondo_color ?>"
>
    <div 
        class="data cambiarcolor<?php echo $id_fondo_color ?>" 
        style="border: 1px solid #000000; width: 20px; height: 20px; background: <?php echo $data_fondo_color ?>"
    >
    </div>
    <div class="data">
        <input 
            type="hidden" 
            id="hex_color<?php echo $id_fondo_color ?>" 
            name="color_sel" 
            value="<?php echo $data_fondo_color ?>"
        >
        <input 
            class="btn_data"
            type="button" 
            id="colorSelector<?php echo $id_fondo_color ?>" 
            value="Elegir Color"
        >
    </div>    
    <div class="opciones">
        <input type="hidden" value="<?php echo $row['id_fondo_color'] ?>" name="idcodigo00">
        <input type="hidden" value="editar_color_producto" name="editar_color">
        <button class="btn_linea" type="submit">Guardar Color</button>
    </div>
    <script>
        $("#frmedit<?php echo $id_fondo_color ?>").on("submit",function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                success: function(res) {
                    $("#rspt<?php echo $id_fondo_color ?>").show("slow");
                    setTimeout(() => {
                        $("#rspt<?php echo $id_fondo_color ?>").hide();
                    }, 3000);
//                    console.log(res);
                },
                error: function(res) {
                    console.log(res);
                }
            })
        })
    </script>
    <div style="display: none" class="data" id="rspt<?php echo $id_fondo_color ?>">Dato actualizado!</div>
</form>

    <script>
    $('#colorSelector<?php echo $id_fondo_color ?>').ColorPicker({
        color: '<?php echo $data_fondo_color ?>',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $("#hex_color<?php echo $id_fondo_color ?>").val('#'+hex);
            $(".cambiarcolor<?php echo $id_fondo_color ?>").attr("style","width: 20px; height: 20px; background: #"+hex);
        }
    });
    </script>

</div>
        <?php
    }
}
