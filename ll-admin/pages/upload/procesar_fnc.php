<?php

function buscar_sku($sku)
{
    $query_buscar_sku = "SELECT EXISTS 
      (SELECT 1 FROM codigos WHERE name = '$sku') 
      AS exist";
    $result = obtener_linea($query_buscar_sku);
    $exist = $result['exist'];
    return $exist;
}

function obtener_id_color($sku)
{
    $query_id_sku = "SELECT id_color FROM codigos WHERE name = :nombre";

    include 'functions/lla_dbconnect.php';
    $statement = $pdo->prepare($query_id_sku);
    $statement->bindParam(':nombre', $sku);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['id_color'];
}

function buscar_producto_back($nombre_producto)
{
    $query_buscar_producto = "SELECT EXISTS 
      (SELECT 1 FROM productos WHERE name = '$nombre_producto') 
      AS exist";
    $result = obtener_linea($query_buscar_producto);
    $exist = $result['exist'];
    return $exist;
}

function buscar_producto($nombre_producto)
{
    $query_buscar_producto = "SELECT EXISTS 
      (SELECT 1 FROM productos WHERE name = :nombre) 
      AS exist";

    include 'functions/lla_dbconnect.php';
    $statement = $pdo->prepare($query_buscar_producto);
    $statement->bindParam(':nombre', $nombre_producto);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $exist = $result['exist'];

    return $exist;
}

function obtener_id_producto($nombre_producto)
{
    $query_id_producto = "SELECT id FROM productos WHERE name = :nombre";

    include 'functions/lla_dbconnect.php';
    $statement = $pdo->prepare($query_id_producto);
    $statement->bindParam(':nombre', $nombre_producto);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['id'];
}

function buscar_color($nombre_color, $id_producto)
{
    $query_buscar_color = "SELECT EXISTS 
      (SELECT 1 FROM colors WHERE name = '$nombre_color' AND id_producto = '$id_producto') 
      AS exist";
    $result = obtener_linea($query_buscar_color);
    $exist = $result['exist'];
    return $exist;
}

function buscar_foto($foto, $id_color)
{
    $query_buscar_foto = "SELECT EXISTS 
      (SELECT 1 FROM fotos WHERE name = '$foto' AND id_color = '$id_color') 
      AS exist";
    $result = obtener_linea($query_buscar_foto);
    $exist = $result['exist'];
    return $exist;
}

function upload_producto_color_codigo_transaccion($row)
{
    $sku = $row[2];
    $nombre_producto = $row[1];
    $descripcion = $row[3];
    $detalles = $row[4];
    $nombre_color = $row[8];
    $nombre_talla = $row[9];
    $precio = $row[6];
    $precio_oferta = $row[7];
    $stock = $row[5];

    // echo "SKU: " . $sku . "<br>";
    // echo "Nombre Producto: " . $nombre_producto . "<br>";
    // echo "Descripción: " . $descripcion . "<br>";
    // echo "Características: " . $detalles . "<br>";
    // echo "Nombre Color: " . $nombre_color . "<br>";
    // echo "Nombre Talla: " . $nombre_talla . "<br>";
    // echo "Precio Base: " . $precio . "<br>";
    // echo "Precio Especial: " . $precio_oferta . "<br>";
    // echo "Stock: " . $stock . "<br>";

    include 'functions/lla_dbconnect.php';

    try {
        $pdo->beginTransaction();
        // Insertar en la tabla "productos"
        $stmt = $pdo->prepare(
            "INSERT INTO productos (
      name, 
      description, 
      details
      ) VALUES (
      :name_producto, 
      :description, 
      :details
      )"
        );
        $stmt->bindParam(':name_producto', $nombre_producto);
        $stmt->bindParam(':description', $descripcion);
        $stmt->bindParam(':details', $detalles);

        // $generatedQuery = $stmt->queryString;
        // echo "Query generado: $generatedQuery" . "<br>";

        $stmt->execute();

        $productoId = $pdo->lastInsertId(); // Obtener el ID autogenerado

        // Insertar en la tabla "colors"
        $stmt = $pdo->prepare("INSERT INTO colors (name, id_producto) VALUES (:color_nombre, :producto_id)");
        $stmt->bindParam(':producto_id', $productoId);
        $stmt->bindParam(':color_nombre', $nombre_color);
        $stmt->execute();

        $colorId = $pdo->lastInsertId(); // Obtener el ID autogenerado

        // Insertar en la tabla "codigos"
        $stmt = $pdo->prepare(
            "INSERT INTO codigos (
      name, 
      name_talla, 
      precio, 
      precio_oferta, 
      stock, 
      id_color
      ) VALUES (
      :nombre_sku, 
      :nombre_talla, 
      :precio,
      :precio_oferta,
      :stock,
      :color_id
      )"
        );
        $stmt->bindParam(':color_id', $colorId);
        $stmt->bindParam(':nombre_sku', $sku);
        $stmt->bindParam(':nombre_talla', $nombre_talla);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':precio_oferta', $precio_oferta);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();

        $pdo->commit(); // Confirmar la transacción

        //echo "Operaciones completadas exitosamente.";
        return true;
    } catch (PDOException $e) {
        $pdo->rollback(); // Revertir la transacción en caso de error
        //echo "Error: " . $e->getMessage();
        return false;
    }
}

function upload_codigo($row, $id_color)
{
    $sku = $row[2];
    $nombre_talla = $row[9];
    $precio = $row[6];
    $precio_oferta = $row[7];
    $stock = $row[5];

    include 'functions/lla_dbconnect.php';

    try {
        $pdo->beginTransaction();
        // Insertar en la tabla "codigos"
        $stmt = $pdo->prepare(
            "INSERT INTO codigos (
        name, 
        name_talla, 
        precio, 
        precio_oferta, 
        stock, 
        id_color
        ) VALUES (
        :nombre_sku, 
        :nombre_talla, 
        :precio,
        :precio_oferta,
        :stock,
        :color_id
        )"
        );
        $stmt->bindParam(':color_id', $id_color);
        $stmt->bindParam(':nombre_sku', $sku);
        $stmt->bindParam(':nombre_talla', $nombre_talla);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':precio_oferta', $precio_oferta);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();

        $pdo->commit(); // Confirmar la transacción

        //echo "Operaciones completadas exitosamente.";
        return true;
    } catch (PDOException $e) {
        $pdo->rollback(); // Revertir la transacción en caso de error
        //echo "Error: " . $e->getMessage();
        return false;
    }
}

function upload_codigo_color($row, $id_producto)
{
    $sku = $row[2];
    $nombre_talla = $row[9];
    $precio = $row[6];
    $precio_oferta = $row[7];
    $stock = $row[5];
    $nombre_color = $row[8];

    include 'functions/lla_dbconnect.php';

    try {
        $pdo->beginTransaction();

        // Insertar en la tabla "colors"
        $stmt = $pdo->prepare("INSERT INTO colors (name, id_producto) VALUES (:color_nombre, :producto_id)");
        $stmt->bindParam(':producto_id', $id_producto);
        $stmt->bindParam(':color_nombre', $nombre_color);
        $stmt->execute();

        $colorId = $pdo->lastInsertId(); // Obtener el ID autogenerado

        // Insertar en la tabla "codigos"
        $stmt = $pdo->prepare(
            "INSERT INTO codigos (
      name, 
      name_talla, 
      precio, 
      precio_oferta, 
      stock, 
      id_color
      ) VALUES (
      :nombre_sku, 
      :nombre_talla, 
      :precio,
      :precio_oferta,
      :stock,
      :color_id
      )"
        );
        $stmt->bindParam(':color_id', $colorId);
        $stmt->bindParam(':nombre_sku', $sku);
        $stmt->bindParam(':nombre_talla', $nombre_talla);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':precio_oferta', $precio_oferta);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();

        $pdo->commit(); // Confirmar la transacción

        //echo "Operaciones completadas exitosamente.";
        return true;
    } catch (PDOException $e) {
        $pdo->rollback(); // Revertir la transacción en caso de error
        //echo "Error: " . $e->getMessage();
        return false;
    }
}

function upload_fotos_color($query_transaccion)
{
    include 'functions/lla_dbconnect.php';
    $pdo->beginTransaction();
    $exito = true;

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
        return true;
    } else {
        $pdo->rollback();
        return false;
    }
    $pdo = null;
}
