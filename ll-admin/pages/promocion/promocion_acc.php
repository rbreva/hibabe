<?php

function listar_promociones()
{
    $ofertaSel = "";
    if (isset($_GET['ofertaSel'])) {
        $ofertaSel = $_GET['ofertaSel'];
    }

    if ($ofertaSel == "ofertaSecciones") {
        ofertaSecciones();
    } elseif ($ofertaSel == "ofertaNxP") {
        ofertaNxP();
    } else {
        ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Lista de Promociones</div>
    </div>
    <ul class="promo_ul">
        <li class="promo_li"><a href="promocion.php?menu_lat=31&ofertaSel=ofertaSecciones">Oferta Secciones</a></li>
        <li class="promo_li"><a href="promocion.php?menu_lat=31&ofertaSel=ofertaNxP">Oferta NxP</a></li>
    </ul>
        <?php
    }
}

function ofertaSecciones()
{
    ?>
<div class="barra_titulo">
    <div class="titulo_sec">Oferta Seccion</div>
</div>
    <?php
    $accion = "";
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        $porcentaje = $_POST['porcentaje_oferta'];
        $activo_oferta = 0;
        if (isset($_POST['oferta_activo'])) {
            $activo_oferta = 1;
        }
        $query_seccion = "UPDATE secciones SET 
            activo_oferta_seccion = $activo_oferta,
            oferta_seccion = $porcentaje
            WHERE 
            id = $accion";
            // echo $query_seccion;
        if (actualizar_registro($query_seccion)) {
            ?>
            <div class='actualizadoSecciones'>Actualizado</div>
            <?php
        }
    }
    ?>
  <div class="formSecciones">
    <?php
      $query_secciones = "SELECT * FROM secciones WHERE active = 1";
      $secciones = obtener_todo($query_secciones);
    foreach ($secciones as $row) {
        $id_seccion = $row['id'];
        $nombre_seccion = $row['name'];
        $oferta_seccion = $row['oferta_seccion'];
        $activo_oferta = $row['activo_oferta_seccion'];

        $menu_query = "SELECT m.*
        FROM menus m
        JOIN menu_seccion ms ON m.id = ms.menu_id
        WHERE ms.seccion_id = $id_seccion";
        $menus = obtener_todo($menu_query);

        foreach ($menus as $menu) {
            $nombre_menu = $menu['name'];
        }

        ?>
    <form 
    class="ofertaSeccion" 
    enctype="multipart/form-data" 
    action="promocion.php?menu_lat=31&ofertaSel=ofertaSecciones" 
    method="post">
        <div class="nameSec"><?php echo $nombre_menu . " / " . $nombre_seccion ?>: </div>
        <input class="inputNum" type="number" name="porcentaje_oferta" value="<?php echo $oferta_seccion ?>">
        <input name="oferta_activo" type="checkbox"
        <?php
        if ($activo_oferta == 1) {
            echo " checked ";
        }
        ?>
          >
        <div class="envio">
          <input type="hidden" name="accion" value="<?php echo $id_seccion ?>"  />
          <input class="boton" type="submit" value="Activar/Desactivar Oferta" />
        </div>
    </form>
        <?php
    }
    ?>
      <hr />
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
      setTimeout(function() {
          $(".actualizadoSecciones").fadeOut(1500);
      },2000);
   
  });
  </script>
    <?php
}

function ofertaNxP()
{
    $accion = "";
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    }

    $query_prom_temp = "SELECT * FROM promonxn WHERE id_promonxn = 2";
    $promo = obtener_linea($query_prom_temp);

    if ($accion == "promonxp") {
        modificar_promonxp();
    } else {
        promonxp_inicio($promo);
    }
}

function promonxp_inicio($promo)
{
    $hoy = date("Y-m-d");
    // print_r($promo);
    $activo_oferta = $promo['activo_promonxn'];
    $fecha_inicio = $promo['fecha_inicio'];
    $hora_inicio = $promo['hora_inicio'];
    $fecha_cierre = $promo['fecha_cierre'];
    $hora_cierre = $promo['hora_cierre'];
    $uno_promonxn = $promo['uno_promonxn'];
    $dos_promonxn = $promo['dos_promonxn'];
    $secciones_cupon = $promo['secciones_cupon'];
    ?>
    
    <div class="titulo">Promo NxP</div>
    <div class="formulario">
    <form enctype="multipart/form-data" action="promocion.php?menu_lat=31&ofertaSel=ofertaNxP" method="post">

        <div class="linea">
            <label for="promo_active" class="activar"> Activar Promo NxP</label> 
            <input 
            id="promo_active" 
            type="checkbox" 
            value="1" 
            name="activar" 
            <?php echo $activo_oferta == 1 ? " checked " : ""; ?>>
        </div>

        <div class="linea"> 
            <label>Fecha y Hora de inicio: </label> 
            <input name="inicio_dt" type="date" min="<?php echo $hoy ?>" value="<?php echo $fecha_inicio ?>" required>
            <input name="inicio_hr" type="time" value="<?php echo $hora_inicio ?>" required>
        </div>

        <div class="linea"> 
            <label>Fecha y Hora de cierre: </label> 
            <input name="final_dt" type="date" min="<?php echo $hoy ?>" value="<?php echo $fecha_cierre ?>" required >
            <input name="final_hr" type="time" value="<?php echo $hora_cierre ?>" required>
        </div>

        <div class="funcion">
            <div>Configuración</div>
            
            <div class="linea">
                <label for="cantidadPrendas">Cantidad de Prendas: </label>
                <input 
                id="cantidadPrendas" 
                name="uno_promonxn" 
                type="number" 
                min="1" 
                value="<?php echo $uno_promonxn ?>" 
                required >
            </div>
            
            <div class="linea">
                <label for="montoPrendas">Monto </label>
                <input 
                id="montoPrendas" 
                name="dos_promonxn" 
                type="number" 
                min="1" 
                value="<?php echo $dos_promonxn ?>" 
                required >
            </div>
        </div>
        <hr />
        <div class="funcion"> Aplica a: <br>
        <?php
        $lista_array = explode(',', $secciones_cupon);

        $query_secciones = "SELECT * FROM secciones WHERE active = 1";
        $secciones = obtener_todo($query_secciones);
        foreach ($secciones as $row) {
            $nombre_seccion = $row['name'];
            $id_seccion = $row['id'];

            $menu_query = "SELECT m.*
            FROM menus m
            JOIN menu_seccion ms ON m.id = ms.menu_id
            WHERE ms.seccion_id = $id_seccion";
            $menus = obtener_todo($menu_query);
            foreach ($menus as $menu) {
                $nombre_menu = $menu['name'];
            }
            ?>
            <div class="seccion_lista">
                <label for="<?php echo $id_seccion ?>" class="bold">
                    <?php echo $nombre_menu . " / " . $nombre_seccion ?>: 
                </label>
                <input 
                    id="<?php echo $id_seccion ?>" 
                    name="secciones_chk[]" 
                    type="checkbox" 
                    value="<?php echo $id_seccion ?>" 
                    <?php echo in_array($id_seccion, $lista_array) ? " checked " : ""; ?>
                >
            </div>
            <?php
        }
        ?>
        <hr />
        </div>
        
        <div class="envio">
            <input type="hidden" name="accion" value="promonxp" />
            <input class="boton" type="submit" value="Actualizar Promoción NxP" />
        </div>
    </form>
    </div>
    <?php
}

function modificar_promonxp()
{
    $activar = "0";
    if (isset($_POST['activar'])) {
        $activar = $_POST['activar'];
    }

    $fecha_inicio = $_POST['inicio_dt'];
    $fecha_cierre = $_POST['final_dt'];
    $hora_inicio = $_POST['inicio_hr'];
    $hora_cierre = $_POST['final_hr'];

    $uno_promonxn = $_POST['uno_promonxn'];
    $dos_promonxn = $_POST['dos_promonxn'];

    $secciones = "";
    $secciones_string = "";
    if (isset($_POST['secciones_chk'])) {
        $secciones = $_POST['secciones_chk'];
        $secciones_string = implode(',', $secciones);
    }

    $query_promociones = "UPDATE promonxn SET 
        uno_promonxn = '$uno_promonxn', 
        dos_promonxn = '$dos_promonxn', 
        fecha_inicio = '$fecha_inicio', 
        hora_inicio = '$hora_inicio', 
        fecha_cierre = '$fecha_cierre', 
        hora_cierre = '$hora_cierre', 
        secciones_cupon = '$secciones_string', 
        activo_promonxn = '$activar' 
        WHERE id_promonxn = 2";

    if (actualizar_registro($query_promociones)) {
        $msj = "Promoción Actualizada";
    } else {
        $msj = "Error en el Servidor, por favor intente de nuevo";
    }
    $ruta = "promocion.php?menu_lat=31&ofertaSel=ofertaNxP";
    $boton = "Regresar";
    mensaje_generico($msj, $ruta, $boton);
}
