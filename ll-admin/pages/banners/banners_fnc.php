<?php

function banners($id_lat, $title, $medidas, $type)
{
    $acc = '';
    if (isset($_GET['acc'])) {
        $acc = $_GET['acc'];
        $id_banner = '';
        if (isset($_GET['id'])) {
            $id_banner = $_GET['id'];
        }
    }
    // echo "function banners" . $id_lat . "<br>";
    ?>
  <div class="barra_titulo">
    <h2 class="titulo_h2"><?php echo $title ?></h2>
    <div class="botones_prod">
      <a href="banners.php?menu_lat=<?php echo $id_lat ?>&acc=new" class="nuevo_btn">
        Agregar Nuevo <?php echo $title ?>
      </a>
    </div>
  </div>
  <div class="nota">
    El tamaño ideal del banner a agregar o modificar es de
    <?php echo $medidas ?>
    px o proporcional otros tamaños puede ocasionar descuadres inesperados
  </div>
  <div class="cuadro">
    <?php
    if ($acc) {
        if ($acc == 'new') {
            banner_new($id_lat, $title, $type);
        } elseif ($acc == 'edit') {
            banner_edit($id_lat, $title, $type, $id_banner);
        } elseif ($acc == 'del') {
            banner_del($id_lat, $title, $id_banner);
        } elseif ($acc == 'sus') {
            echo "suspender";
            banner_sus($id_lat, $id_banner);
        } elseif ($acc == 'act') {
            echo "activar";
            banner_act($id_lat, $id_banner);
        } else {
            ?>
            <div>No hay acciones disponibles, se regresa</div>
            <?php
        }
    } else {
        $query_banners = "SELECT * FROM banners WHERE id_menu_lat = $id_lat ORDER BY id DESC";
        $banners = obtener_todo($query_banners);

        if ($banners) {
            display_banners($banners, $type, $id_lat);
        } else {
            ?>
      
        <div class="titulo_prod">Lista: <?php echo $title ?></div>
        <div class="vacio">Aun no se ha ingresado <?php echo $title ?></div>
      
            <?php
        }
        ?>
  </div>
        <?php
    }
}

function display_banners($banners, $type, $id_lat)
{
    foreach ($banners as $row) {
        $id_banner = $row['id'];
        $name = $row['name'];
        $link = $row['link'];
        $image = $row['image'];
        $active = $row['active'];
        $verificarfile =  pathinfo($image)['extension'];
        ?>
    <div class="banner">
        <div class="nombre_banner">Nombre: <?php echo $name ?></div>
        <div class="nombre_banner">
          Link: 
          <?php
            echo $link ? $link : 'Sin link';
            ?>
        </div>
        <?php
        if ($verificarfile == "jpg" || $verificarfile == "jpge" || $verificarfile == "png") {
            if ($type == "desktop") {
                $classimg = "imagen";
            } elseif ($type == "mobile" || $type == "seccion") {
                $classimg = "imagen_mobile";
            }
            ?>
            <div class="<?php echo $classimg ?>"><img src="../images/banners/<?php echo $image; ?>"></div>
            <?php
        } else {
            ?>
            <div class="video">
              <video class="img-responsive center-block" loop autoplay muted width="100%">
                <source src="../images/banners/<?php echo $image ?>" type="video/mp4">
              </video>
            </div>
            <?php
        }
        ?>

        <div class="botonera">
          <?php
            if ($active == '1') {
                $actdesact = 'sus';
                $actdesacttxt = 'Suspender';
            } else {
                $actdesact = 'act';
                $actdesacttxt = 'Activar';
            }
            ?>
            <a 
                class="btn_a" 
                href="banners.php?menu_lat=<?php echo $id_lat ?>&acc=<?php echo $actdesact ?>&id=<?php echo $id_banner ?>" 
                class="boton"
            >
                <?php echo $actdesacttxt ?>
            </a>
            <a 
                class="btn_a" 
                href="banners.php?menu_lat=<?php echo $id_lat ?>&acc=edit&id=<?php echo $id_banner ?>" 
                class="boton"
            >
                Editar
            </a>
            <a 
                class="acc_btn" 
                href="banners.php?menu_lat=<?php echo $id_lat ?>&acc=del&id=<?php echo $id_banner ?>" 
                class="boton"
            >
                Eliminar
            </a>
        </div>
    </div>
        <?php
    }
}
