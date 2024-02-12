<?php

function cupones_fnc()
{
    $accion = "";
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    }

    $query_cupones = "SELECT * FROM cupones_descuento WHERE id_cupon = 1";
    $cupon = obtener_linea($query_cupones);

    if ($accion == "vamos") {
        modificar_cupones();
    } else {
        cupones_inicio($cupon);
    }
}

function cupones_inicio($cupon)
{
    $hoy = date("Y-m-d");
    $hora = date("H:i");
    //print_r($cupon);
    $activo = "";
    if ($cupon['activo_cupon'] == 1) {
        $activo = "checked";
    }
    ?>
<div class="titulo_solo">Cupones</div>
    <div class="formulario">
        <form enctype="multipart/form-data" action="promocion.php?menu_lat=7" method="POST">
            <div class="activar">
                <label class="activo">Cupón Activo: </label>
                <input type="checkbox" value="1" name="activar" <?php  echo $activo ?> />
            </div>
            <div class="cupon">
                <label>Código: </label> 
                <input 
                    class="codigo" 
                    name="nombre_cupon" 
                    type="text" 
                    value="<?php echo $cupon['codigo_cupon'] ?>" 
                    required 
                />
            </div>
            <hr />
            <div class="fecha"> 
                <div>Fecha y Hora de inicio: </div>
                <input 
                    name="inicio_dt" 
                    type="date" 
                    min="<?php echo $hoy; ?>" 
                    value="<?php echo $cupon['fecha_inicio_cupon']; ?>" 
                    required
                />
                <input 
                    name="inicio_hr" 
                    type="time" 
                    value="<?php echo $cupon['hora_inicio_cupon']; ?>" 
                    required
                />
            </div>
            <div class="fecha"> Fecha y Hora de cierre:
                <input 
                    name="final_dt" 
                    type="date" 
                    min="<?php echo $hoy; ?>" 
                    value="<?php echo $cupon['fecha_cierre_cupon']; ?>" 
                    required
                />
                <input 
                    name="final_hr" 
                    type="time" 
                    value="<?php echo $cupon['hora_cierre_cupon']; ?>" 
                    required
                />
            </div>
            <hr />
            <div class="funcion"> Aplica a: <br>
                <?php
                $lista_array = explode(',', $cupon['secciones_cupon']);
                $query_secciones = "SELECT * FROM secciones WHERE active = 1";
                $secciones = obtener_todo($query_secciones);
                foreach ($secciones as $seccion) {
                    $nombre_seccion = $seccion['name'];
                    $id_seccion = $seccion['id'];
                    $checked = "";
                    if (in_array($id_seccion, $lista_array)) {
                        $checked = "checked";
                    }
                    ?>
                <div class="datos_inline">
                    <label class="bold"><?php echo $nombre_seccion ?>: </label>
                    <input name="secciones_chk[]" type="checkbox" value="<?php echo $id_seccion ?>" <?php echo $checked ?>>
                </div>
                    <?php
                }
                ?>
                <hr />
                <div class="datos">
                    <p>
                        <span class="bold">Porcentaje de descuento: </span><input name="porcentaje_nmr" type="number" min="1" max="99" value="<?php echo $cupon['porcentaje_cupon']; ?>"> %<br>
                    </p>
                </div>
            </div>
            <div class="envio">
                <input type="hidden" name="accion" value="vamos" />
                <button class="boton" type="submit">Actualizar Cupón</button>
            </div>
        </form>
    </div>
    <div class="promoactiva">
        <?php
        $ahora = new DateTime('now');
        $datetime1 = new DateTime($cupon['fecha_inicio_cupon'] . $cupon['hora_inicio_cupon']);
        $datetime2   = new DateTime($cupon['fecha_cierre_cupon'] . $cupon['hora_cierre_cupon']);
        $interval = date_diff($datetime1, $datetime2);
        $titulo = "";
        if ($ahora > $datetime2) {
            $titulo = "Cupón Finalizado";
        } else {
            $inicio = date_diff($ahora, $datetime1);
            $fin = date_diff($ahora, $datetime2);
            if ($ahora > $datetime1) {
                if ($cupon['activo_cupon'] == 0) {
                    $titulo = "(apagada) ";
                }
                $titulo = $titulo . "El cupón esta activo hace: " . $inicio->format('%R%a días y %H:%I horas') . " y termina dentro de: " . $fin->format('%R%a días y %H:%I horas');
            } elseif ($ahora < $datetime1) {
                $titulo = "El cupón se activará dentro de:" . $inicio->format('%R%a días y %H:%I horas');
            }
        }
        ?>
        <div class="estado"><?php echo $titulo; ?></div>
        <div class="detalle">Desde: <?php echo $cupon['fecha_inicio_cupon']; ?> <?php echo $cupon['hora_inicio_cupon']; ?></div>
        <div class="detalle">Hasta: <?php echo $cupon['fecha_cierre_cupon']; ?> <?php echo $cupon['hora_cierre_cupon']; ?></div>
        <div class="detalle">Duración del Cupón: <?php echo $interval->format('%a días y %H:%I horas'); ?></div>
        <div class="detalle"></div>
    </div>
    <?php
}

function modificar_cupones()
{
    $activar = 0;
    if (isset($_POST['activar'])) {
        $activar = $_POST['activar'];
    }

    $codigo = $_POST['nombre_cupon'];
    $codigo = strtoupper($codigo);
    $fecha_inicio = $_POST['inicio_dt'];
    $fecha_cierre = $_POST['final_dt'];
    $hora_inicio = $_POST['inicio_hr'];
    $hora_cierre = $_POST['final_hr'];
    $secciones = [];
    if (isset($_POST['secciones_chk'])) {
        $secciones = $_POST['secciones_chk'];
    }
    $porcentaje = $_POST['porcentaje_nmr'];

    $secciones_string = "";
    if ($secciones) {
        $secciones_string = implode(',', $secciones);
    }

    $query_cupones = "UPDATE 
        cupones_descuento 
        SET 
        activo_cupon = '$activar', 
        codigo_cupon = '$codigo', 
        fecha_inicio_cupon = '$fecha_inicio', 
        fecha_cierre_cupon = '$fecha_cierre', 
        hora_inicio_cupon = '$hora_inicio',	
        hora_cierre_cupon = '$hora_cierre',	
        secciones_cupon = '$secciones_string', 
        porcentaje_cupon = '$porcentaje' 
        WHERE id_cupon = '1'";

    if (actualizar_registro($query_cupones)) {
        $msj = "Cupón Actualizado";
    } else {
        $msj = "Error en el Servidor, por favor intente de nuevo";
    }
    $ruta = "promocion.php?menu_lat=7";
    $boton = "Regresar";
    mensaje_generico($msj, $ruta, $boton);
}
