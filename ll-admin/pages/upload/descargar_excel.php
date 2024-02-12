<?php

$query_productos = "SELECT * FROM productos";
$productos = obtener_todo($query_productos);

// echo "<pre>";
// print_r($productos);
// echo "</pre>";

?>

<table id="miTabla">
        <tr>
            <th>Link Imágenes</th>
            <th>Nombre Producto</th>
            <th>SKU</th>
            <th>Descripción</th>
            <th>Características</th>
            <th>Marca</th>
            <th>Keywords</th>
            <th>Stock</th>
            <th>Precio Base</th>
            <th>Precio Especial</th>
            <th>SKU_Color</th>
            <th>SKU_Talla</th>
        </tr>

        <?php
        foreach ($productos as $producto) {
            $id_producto = $producto['id'];
            $name_producto = $producto['name'];
            $description_producto = $producto['description'];
            $details_producto = $producto['details'];

            $query_keywords = "SELECT * FROM keywords WHERE id_producto = $id_producto";
            $keywords = obtener_linea($query_keywords);
            $keywords_cont = "";
            if ($keywords) {
                $keywords_cont = $keywords['keywords'];
            }

            $query_colors = "SELECT * FROM colors WHERE id_producto = $id_producto";
            $colors = obtener_todo($query_colors);

            if ($colors) {
                foreach ($colors as $color) {
                    $id_color = $color['id'];
                    $name_color = $color['name'];

                    $query_fotos = "SELECT * FROM fotos WHERE id_color = $id_color AND link = 1";
                    $fotos = obtener_todo($query_fotos);

                    $fotos_cont = "";
                    if ($fotos) {
                        for ($i = 0; $i < count($fotos); $i++) {
                            $fotos_cont .= $fotos[$i]['name'];
                            if ($i < count($fotos) - 1) {
                                $fotos_cont .= ", ";
                            }
                        }
                    }

                    // echo "<pre>";
                    // print_r($fotos_cont);
                    // echo "<br><br><br><br>";
                    // echo "</pre>";

                    $query_codigos = "SELECT * FROM codigos WHERE id_color = $id_color";
                    $codigos = obtener_todo($query_codigos);

                    if ($codigos) {
                        foreach ($codigos as $codigo) {
                            $codigo_name = $codigo['name'];
                            $codigo_stock = $codigo['stock'];
                            $codigo_precio = $codigo['precio'];
                            $codigo_precio_oferta = $codigo['precio_oferta'];
                            $codigo_name_talla = $codigo['name_talla'];
                            ?>
        <tr>
            <td><?php echo $fotos_cont ?></td>
            <td><?php echo $name_producto ?></td>
            <td><?php echo $codigo_name ?></td>
            <td><?php echo $description_producto ?></td>
            <td><?php echo $details_producto ?></td>
            <td></td>
            <td><?php echo $keywords_cont ?></td>
            <td><?php echo $codigo_stock ?></td>
            <td><?php echo $codigo_precio ?></td>
            <td><?php echo $codigo_precio_oferta ?></td>
            <td><?php echo $name_color ?></td>
            <td><?php echo $codigo_name_talla ?></td>
        </tr>
                            <?php
                        }
                    }
                }
            }
        }
        ?>
    </table>

    <button onclick="exportarExcel()">Exportar a Excel</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="js/tuescritorio.js"></script>
