<?php

function listar_secciones($secciones, $titulo)
{
    ?>
<div class="titulo_prod"><?php echo $titulo; ?></div>
    <?php
    if (!$secciones) {
        ?>
    <div class='vacio'>Menú sin secciones, No se puede agregar productos</div>
        <?php
    } else {
          secciones_menu($secciones);
    }
}

function secciones_menu($secciones)
{
    $id_menu = $_GET['id'];
    ?>
  <div class="secciones_prod">
    <?php
    foreach ($secciones as $row) {
        $id_seccion = $row['id'];
        $nombre_seccion = $row['name'];
        ?>
    <div class="seccion_prod">
        <a class="seccion_prod_a" href="productos.php?id=<?php echo $id_menu ?>&idsec=<?php echo $id_seccion ?>">
        <img class="icon_arrow" src="images/svg/icons/arrow.svg">
        <?php echo $nombre_seccion ?>
      </a>
    </div>
        <?php
    }
    ?>
  </div>
    <?php
}
