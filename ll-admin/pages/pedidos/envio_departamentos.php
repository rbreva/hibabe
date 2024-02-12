<?php

require_once 'll-admin2023/functions/lla_admin.php';

$enviodep = $_POST['enviodep'];
if ($enviodep) {
    $costo = json_decode($_POST['costo']);
    $iddep = json_decode($_POST['iddep']);

    $cont = count($costo);

    if (is_array($costo)) {
        for ($i = 0; $i < $cont; $i++) {
            $query = "UPDATE departamentos SET costo_envio = $costo[$i] WHERE id_departamentos = $iddep[$i]";
            actualizar_registro($query);
        }
        echo "bien";
    } else {
        echo "error";
    }
}

echo "<br>";
print_r($costo);
echo "<br>";
print_r($iddep);
echo "<br>";
echo "bien";
echo "<br>";
