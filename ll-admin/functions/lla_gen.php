<?php

function doctype($page, $config)
{
    ?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;400;700&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/png" href="../images/<?php echo $config['icon_page'] ?>" />
    <title><?php echo $page ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  </head>

  <body>
    <?php
}

function ll_header($page, $config)
{
    $menu_lat_active = 1;
    if (isset($_GET['menu_lat'])) {
        $menu_lat_active = $_GET['menu_lat'];
    }
    if ($page == "Local") {
        $menu_top_active = 1;
    } elseif ($page == "Productos") {
        $menu_top_active = 2;
    } elseif ($page == "Banners") {
        $menu_top_active = 3;
    } elseif ($page == "Pedidos") {
        $menu_top_active = 4;
    } elseif ($page == "Menus") {
        $menu_top_active = 5;
    } elseif ($page == "Promociones") {
        $menu_top_active = 6;
    } elseif ($page == "Clientes") {
        $menu_top_active = 7;
    } elseif ($page == "Suscripcion") {
        $menu_top_active = 8;
    } elseif ($page == "Destacados") {
        $menu_top_active = 9;
    } elseif ($page == "Informativas") {
        $menu_top_active = 10;
    } elseif ($page == "Upload") {
        $menu_top_active = 11;
    }
    ?>
    <header>
      <div class="marquesina"><?php echo $config['name'] ?></div>
      <div class="header_container">
        <div class="menu_mob mob">
          <img src="images/svg/icons/menu.svg" alt="Menu" />
        </div>
        <div class="logo_limalocal">
          <img src="images/svg/limalocal.svg" alt="Limalocal" />
        </div>
        <nav class="nav_bar desk">
          <?php
              principal_menu($config, $menu_top_active);
            ?>
        </nav>
        <div class="cls_ses">
          <div class="cls_btn"><a href="logout.php">Cerrar Sesión</a></div>
        </div>
      </div>
    </header>
    <main>
      <nav class="nav_bar mob close" id="nav_bar">
        <?php
            principal_menu($config, $menu_top_active);
        ?>
      </nav>
      <?php
        if ($page == "Menus") {
            secondary_menu_menus();
        } elseif ($page == "Productos") {
            secondary_menu_products();
        } elseif ($page == "Informativas") {
            secondary_menu_informativas();
        } else {
            secondary_menu($menu_lat_active, $menu_top_active);
        }
        ?>
    <?php
}

function ll_footer($config)
{
    ?>
    </main>
    <footer>
      <div class="marq">Limalocal 2023 - v.<?php echo $config['version'] ?></div>
    </footer>
    <script type="module" src="index.js"></script>
  </body>
</html>
    <?php
}

function barra_titulo($titulo, $nivel, $btn_a_list)
{
    ?>
<div class="barra_titulo">
  <h2 class="titulo_h2"><?php echo $titulo ?></h2>
    <?php
    if ($nivel  == 1 || $nivel  == 2) {
        foreach ($btn_a_list as $row) {
            ?>
    <a class='nuevo_btn' href='<?php echo $row[0] ?>'>
            <?php echo $row[1] ?>
    </a>
            <?php
        }
    }
    ?>
</div>
    <?php
}
