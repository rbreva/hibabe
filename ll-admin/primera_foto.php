<?php

require_once 'includes/lla_generales.php';

$idfoto = $_POST['idfoto'];
$idpro = $_POST['idpro'];
$query_sel = "SELECT f.* 
	FROM productos p 
	JOIN colors c ON p.id = c.id_producto 
	JOIN fotos f ON c.id = f.id_color 
	WHERE p.id = $idpro";
$onbt = obtener_todo($query_sel);
foreach ($onbt as $itemf) {
    if ($itemf['id'] == $idfoto) {
        $query = "UPDATE fotos SET inicio = 1 WHERE id = $itemf[id]";
        actualizar_registro($query);
    } else {
        $query = "UPDATE fotos SET inicio = 0 WHERE id = $itemf[id]";
        actualizar_registro($query);
    }
}
