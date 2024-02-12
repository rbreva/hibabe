<?php

function principal_menu($config, $menu_top_active)
{
    $query_menutop = "SELECT * FROM menu_top WHERE active = 1";
    $menu_top = obtener_todo($query_menutop);
    ?>
  <ul class="nav_bar_ul">
    <?php
    foreach ($menu_top as $row) {
        $selected = "";
        if ($row['id'] == 1) {
            $name = $config['name'];
        } else {
            $name = $row['name'];
        }
        $link = $row['link'];
        if ($menu_top_active == $row['id']) {
            $selected = "selected";
        }
        ?>
      <li class="nav_bar_li <?php echo $selected ?>">
        <a class="nav_bar_li_a" href="<?php echo $link ?>">
          <?php echo $name ?>
        </a>
      </li>
        <?php
    }
    ?>
  </ul>
    <?php
}

function secondary_menu($menu_lat_active, $menu_top_active)
{
    $query_menutop = "SELECT * FROM menu_top WHERE id = $menu_top_active";
    $menu_top = obtener_linea($query_menutop);
    $link = $menu_top['link'];

    echo $menu_top_active;
    ?>
  <nav class="nav_bar_lat lat_open">
    <ul class="nav_bar_lat_ul">
      <?php
        $query_menu_secondary = "SELECT * FROM menu_lat WHERE menu_top_id = $menu_top_active AND active = 1";
        $menu_secondary = obtener_todo($query_menu_secondary);
        if ($menu_secondary) {
            foreach ($menu_secondary as $row) {
                $selected = "";
                if ($menu_lat_active == $row['id']) {
                    $selected = "selected";
                }
                ?>
          <li class="nav_bar_lat_li  <?php echo $selected ?>">
            <a href="<?php echo $link . "?menu_lat=" . $row['id'] ?>">
                <?php echo $row['name'] ?>
            </a>
          </li>
                <?php
            }
        }
        ?>
    </ul>
    <div class="nav_bar_lat_btn">
      <img class="arrow_lat" src="images/svg/icons/arrow_lat.svg" alt="Menu" />
    </div>
  </nav>
    <?php
}

function secondary_menu_menus()
{
    $selected = "selected";
    $id_menu = "";
    if (isset($_GET['id'])) {
        $selected = "";
        $id_menu = $_GET['id'];
    }
    ?>
  <nav class="nav_bar_lat lat_open">
    <ul class="nav_bar_lat_ul">
      <li class="nav_bar_lat_li <?php echo $selected ?>">
        <a href="menus.php"><span>Lista de Menus</span></a>
      </li>
      <?php
        $query_menus  = "SELECT * FROM menus";
        $menus = obtener_todo($query_menus);
        if ($menus) {
            foreach ($menus as $row) {
                $selected_menu = "";
                $id = $row['id'];
                $name = $row['name'];
                if ($id == $id_menu) {
                    $selected_menu = "selected";
                }
            }
            ?>
        <li class="nav_bar_lat_li <?php echo $selected_menu ?>">
          <a href="menus.php?id=<?php echo $id ?>"><?php echo $name ?></a>
        </li>
            <?php
        }
        ?>
      <li class="nav_bar_lat_li <?php echo $selected ?>">
        <a href="menus.php?acc=create_menu">
          <img class="nav_bar_lat_img" src="images/svg/icons/add.svg" alt="Agregar" />
          <span>Agregar Menú</span>
        </a>
      </li>
    </ul>
    <div class="nav_bar_lat_btn">
      <img class="arrow_lat" src="images/svg/icons/arrow_lat.svg" alt="Menu" />
    </div>
  </nav>
    <?php
}

function secondary_menu_products()
{
    $selected = "selected";
    $id_menu = "";
    if (isset($_GET['id'])) {
        $selected = "";
        $id_menu = $_GET['id'];
    }
    $id_seccion = "";
    if (isset($_GET['idsec'])) {
        $id_seccion = $_GET['idsec'];
    }

    $query_menus  = "SELECT * FROM menus WHERE active = 1";
    $menus = obtener_todo($query_menus);
    ?>
  <nav class="nav_bar_lat lat_open">
    <ul class="nav_bar_lat_ul">
      <li class="nav_bar_lat_li <?php echo $selected ?>">
        <a href="productos.php"><span>Lista de Productos</span></a>
      </li>
      <?php
        if ($menus) {
            foreach ($menus as $row) {
                $selected_men = "";
                $id_menu_sel = $row['id'];
                $name_menu = $row['name'];
                if ($id_menu == $id_menu_sel) {
                    $selected_men = "selected";
                }
                ?>
        <li class="nav_bar_lat_li_men <?php echo $selected_men ?>">
          <a href="productos.php?id=<?php echo $id_menu_sel ?>"><?php echo $name_menu ?></a>
        </li>
                <?php
                if ($id_menu == $id_menu_sel) {
                    $query_secciones  = "SELECT s.* 
                                    FROM secciones s 
                                    JOIN menu_seccion ms 
                                    ON s.id = ms.seccion_id 
                                    WHERE ms.menu_id = $id_menu_sel";
                    $secciones = obtener_todo($query_secciones);
                    if ($secciones) {
                        foreach ($secciones as $rowsec) {
                            $selected_sec = "";
                            $id_seccion_sel = $rowsec['id'];
                            $name_seccion = $rowsec['name'];
                            if ($id_seccion == $id_seccion_sel) {
                                $selected_sec = "selected_sec";
                            }
                            ?>
            <li class="nav_bar_lat_li_sec <?php echo $selected_sec ?>">
              <a href="productos.php?id=<?php echo $id_menu_sel ?>&idsec=<?php echo $id_seccion_sel ?>">
                            <?php echo $name_seccion ?>
              </a>
            </li>
                            <?php
                        }
                    }
                }
            }
        }
        ?>
      <li class="nav_bar_lat_li selected">
        <a href="productos.php?acc=newprod">
          <img class="nav_bar_lat_img" src="images/svg/icons/add.svg" alt="Agregar" />
          <span>Agregar Producto</span>
        </a>
      </li>
    </ul>
    <div class="nav_bar_lat_btn">
      <img class="arrow_lat" src="images/svg/icons/arrow_lat.svg" alt="Menu" />
    </div>
  </nav>
    <?php
}

function secondary_menu_informativas()
{
    $query_pag = "SELECT * FROM informativas";
    $informativas = obtener_todo($query_pag);

    // echo "<pre>";
    // print_r($informativas);
    // echo "</pre>";

    // $selected = "";
    $id_pag = 1;
    if (isset($_GET['pag'])) {
        // $selected = "selected";
        $id_pag = $_GET['pag'];
    }
    ?>
  <nav class="nav_bar_lat lat_open">
    <ul class="nav_bar_lat_ul">
      <li class="nav_bar_lat_li titulo_menu">
        <span>Páginas Informativas</span>
      </li>
      <?php
        if ($informativas) {
            foreach ($informativas as $row) {
                $selected_men = "";
                $id_pag_sel = $row['id'];
                $name_pag = $row['name'];
                if ($id_pag == $id_pag_sel) {
                    $selected_men = "selected";
                }
                ?>
        <li class="nav_bar_lat_li_men <?php echo $selected_men ?>">
          <a href="informativas.php?pag=<?php echo $id_pag_sel ?>"><?php echo $name_pag ?></a>
        </li>
                <?php
            }
        }
        ?>
    </ul>
    <div class="nav_bar_lat_btn">
      <img class="arrow_lat" src="images/svg/icons/arrow_lat.svg" alt="Menu" />
    </div>
  </nav>
    <?php
}
