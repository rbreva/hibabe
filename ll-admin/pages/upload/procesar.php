<?php

require 'vendor/autoload.php'; // Asegúrate de tener la biblioteca PhpSpreadsheet instalada
include_once "procesar_fnc.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$count = 0;

if ($_FILES['archivo_excel']['error'] === UPLOAD_ERR_OK) {
    $archivo_temporal = $_FILES['archivo_excel']['tmp_name'];

    $spreadsheet = IOFactory::load($archivo_temporal);
    $worksheet = $spreadsheet->getActiveSheet();

    $skipFirstRow = true;

    foreach ($worksheet->getRowIterator() as $row) {
        if ($skipFirstRow) {
                $skipFirstRow = false; // Desactivar el salto después de la primera fila
                continue; // Salta a la siguiente iteración del ciclo sin procesar esta fila
        }

        $cellIterator = $row->getCellIterator();

        $columnData = array();

        foreach ($cellIterator as $cell) {
            $columnData[] = $cell->getValue();
        }

        $column2Value = $columnData[2]; // Valor de la columna 2

        if (!empty($column2Value)) { // Si la columna 2 no está vacía
            $dataArray = array(); // Array para almacenar los datos de interés
            $rowData = array(
                $columnData[0], // Columna 0 - Link Imagenes
                $columnData[1], // Columna 1 - Nombre Producto
                $columnData[2], // Columna 2 - SKU
                $columnData[3], // Columna 3 - Descripcion
                $columnData[4], // Columna 4 - Características
                $columnData[7], // Columna 5 - Stock
                $columnData[8], // Columna 6 - Precio Base
                $columnData[9], // Columna 7 - Precio Especial
                $columnData[10], // Columna 8 - SKU_Color
                $columnData[11] // Columna 9 - SKU_Talla
            );

            $dataArray[] = $rowData; // Agregar los datos al array
            // echo "tipo: " . gettype($dataArray) . "<br>";
            // echo "cantidad de datos: " . count($dataArray) . "<br>";

            foreach ($dataArray as $row) {
                $count = $count + 1;
                ?>
                <div class="proceso_sku">
                <?php
                echo $count . "<br>";
                echo "Nombre Producto: " . $row[1] . "<br>";
                echo "SKU: " . $row[2] . "<br>";
                echo "Descripción: " . $row[3] . "<br>";
                echo "Características: " . $row[4] . "<br>";
                echo "Stock: " . $row[5] . "<br>";
                echo "Precio Base: " . $row[6] . "<br>";
                echo "Precio Especial: " . $row[7] . "<br>";
                echo "SKU_Color: " . $row[8] . "<br>";
                echo "SKU_Talla: " . $row[9] . "<br>";
                echo "<br>";

                //Verificar si existe el sku en la base de datos tabla "codigos"
                $sku = $row[2];

                $existe_sku = buscar_sku($sku);

                //Si existe el sku se pasa al siguiente registro

                if ($existe_sku == 1) {
                    ?>
                    <div class="sku existe">
                        <p>El SKU <?php echo $sku ?>, ya existe en la base de datos</p>
                        <p>No se puede volver a crear</p>
                    </div>
                    <?php
                } else {
                    //Si no existe el sku se inserta en la base de datos tabla "codigos"
                    //pero no tenemos el id_color
                    //necesitamos buscar si existe el color/producto en la tabla "colors"
                    //primero buscamos en la tabla "productos" si existe el producto
                    $nombre_producto = $row[1];
                    $existe_producto = buscar_producto($nombre_producto);

                    if ($existe_producto == 1) {
                        //Si existe el producto se busca el id_producto
                        $id_producto = obtener_id_producto($nombre_producto);

                        //Buscamos si existe el color en la tabla "colors"
                        $nombre_color = $row[8];
                        $existe_color = buscar_color($nombre_color, $id_producto);

                        if ($existe_color == 1) {
                            $query_id_color = "SELECT id 
                              FROM colors 
                              WHERE name = '$nombre_color' 
                              AND id_producto = '$id_producto'";
                              $result_color = obtener_linea($query_id_color);
                            $id_color = $result_color['id'];
                            if (upload_codigo($row, $id_color)) {
                                ?>
                                <div class="sku nuevo">Código insertado con éxito.</div>
                                <?php
                            } else {
                                ?>
                                <div class="sku error">Error al insertar código.</div>
                                <?php
                            }
                            ?>
                            <div class="sku alerta">El color existe.</div>
                            <?php
                        } else {
                            ?>
                            <div class="sku falta">El color No existe. Crear Color y agregar codigo</div>
                            <?php
                            if (upload_codigo_color($row, $id_producto)) {
                                ?>
                                <div class="sku nuevo">Color y Código insertado con éxito.</div>
                                <?php
                            } else {
                                ?>
                                <div class="sku error">Error al insertar color y código.</div>
                                <?php
                            }
                        }

                        // echo "El producto ya existe en la base de datos, sigue el proceso.<br>";
                    } else {
                        //Si no existe el producto se inserta en la base de datos tabla "productos"
                        //y se inserta en la tabla "colors"
                        //y se inserta en la tabla "codigos"

                        // print_r($row);

                        if (upload_producto_color_codigo_transaccion($row)) {
                            ?>
                            <div class="sku nuevo">Producto, color y código insertados con éxito.</div>
                            <?php
                        } else {
                            echo "Error al insertar producto, color y código.<br>";
                            ?>
                            <div class="sku error">Error al insertar producto, color y código.</div>
                            <?php
                        }
                    }
                }
                ?>
                </div>
                <?php
            }
        }
    }
    $msj_sku = "Datos del archivo Excel procesados con éxito";
} else {
    $msj_sku = "Error al subir el archivo.";
}
?>
<div class="proceso_sku">
    <p class="msj_sku"><?php echo $msj_sku ?></p>
</div>
