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
                $columnData[0], // Columna 0
                $columnData[2], // Columna 2
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
                echo "SKU: " . $row[1] . "<br>";
                //echo "Fotos: " . $row[0] . "<br>";
                echo "<br>";

                //Verificar si existe el sku en la base de datos tabla "codigos"
                $fotos = $row[0];
                $sku = $row[1];

                $existe_sku = buscar_sku($sku);

                //Si existe el sku se agregan las fotos

                if ($existe_sku == 1) {
                    $id_color = obtener_id_color($sku);

                    $query_transaccion = [];
                    if (isset($array_fotos)) {
                        $array_fotos = explode(",", $fotos);
                    } else {
                        $array_fotos = [];
                    }

                    if ($array_fotos[0] == "") {
                        $msj_fotos = "No existen fotos";
                        ?>
                        <div class="sku alerta">
                            <p><?php echo $msj_fotos ?></p>
                        </div>
                        <?php
                    } else {
                        foreach ($array_fotos as $foto) {
                            $existe_foto = buscar_foto($foto, $id_color);
                            if ($existe_foto == 1) {
                                $msj_fotos = "La foto " . $foto . " ya existe";
                                ?>
                                <div class="sku alerta">
                                    <p><?php echo $msj_fotos ?></p>
                                </div>
                                <?php
                                continue;
                            } else {
                                echo $foto . "<br>";
                                $query_foto = "INSERT 
                                INTO fotos (name, id_color, link) 
                                VALUES ('$foto', $id_color, '1')";
                                array_push($query_transaccion, $query_foto);
                            }
                        }

                        if (upload_fotos_color($query_transaccion)) {
                            $msj_fotos = "Fotos agregadas exitosamente";
                        } else {
                            $msj_fotos = "Error al agregar las fotos";
                        }
                        ?>
                        <div class="sku nuevo">
                            <p>El SKU <?php echo $sku ?> existe</p>
                            <p><?php echo $msj_fotos ?></p>
                        </div>
                        <?php
                    }
                } else {
                    //Si no existe el sku se imprime el mensaje no ixte
                    ?>
                    <div class="sku alerta">
                        <p>El Sku no existe.</p>
                        <p>No se agregarán las fotos</p>
                    </div>
                    <?php
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
