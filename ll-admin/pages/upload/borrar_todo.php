<?php

$conf = "";

if (isset($_GET['conf'])) {
    $conf = $_GET['conf'];
}

if ($conf == "borralo") {
    include 'functions/lla_dbconnect.php';
    $pdo->beginTransaction();
    $exito = true;

    $query_transaccion = array(
        "DELETE FROM seccion_producto",
        "DELETE FROM fotos",
        "DELETE FROM codigos",
        "DELETE FROM colors",
        "DELETE FROM productos"
    );

    foreach ($query_transaccion as $query) {
        //echo "Query: " . $query . "<br>";
        $statement = $pdo->prepare($query);
        $result = $statement->execute();
        if (!$result) {
            $exito = false;
            break;
        }
    }

    if ($exito) {
        $pdo->commit();
        // return true;
        ?>
<div class="wrap">
    <div class="barra_titulo">
        <h2 class="titulo_h2">Borrar Todo</h2>
    </div>
    <div class="upload">
        <h3>Se borraron todos los productos</h3>
    </div>
</div>
        <?php
    } else {
        $pdo->rollback();
        // return false;
        ?>
        <div class="wrap">
            <div class="barra_titulo">
                <h2 class="titulo_h2">Borrar Todo</h2>
            </div>
            <div class="upload">
                <h3>No se pudo borrar</h3>
            </div>
        </div>
        <?php
    }
    $pdo = null;
} else {
    ?>
<div class="wrap">
    <div class="barra_titulo">
        <h2 class="titulo_h2">Borrar Todo</h2>
    </div>
    <form class="upload" action="upload.php?menu_lat=24&conf=borralo" method="post" enctype="multipart/form-data">
        <input type="hidden" name="subir">
        <button type="submit">Borrar Todo Productos</button>
    </form>
</div>
    <?php
}
