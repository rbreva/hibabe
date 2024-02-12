<?php

function products($config)
{
    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];
    ?>
<div class="barra_titulo">
  <h2 class="titulo_h2">Productos</h2>
  <div class="botones_prod">
    <?php
    if ($nivel == 1 || $nivel == 2) {
        new_product_btn();
    }
    busqueda_prod();
    ?>
  </div>
</div>
<div class="cuadro">
    <?php products_list() ?>
</div>
    <?php
}

function new_product_btn()
{
    ?>
  <a href="productos.php?acc=newprod" class="nuevo_btn">
    Agregar Nuevo Producto
  </a>
    <?php
}

function busqueda_prod()
{
    ?>
  <form class="form_search" action="productos.php" method="post">
    <input class="form_search_input" type="text" name="search" value="" required/>
    <button class="form_search_btn" type="submit">Buscar Producto</button>
  </form>
    <?php
}
