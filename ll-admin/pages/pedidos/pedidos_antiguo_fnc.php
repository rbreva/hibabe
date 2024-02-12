<?php

function pedidos_antiguo($id_lat)
{
    $query_pedidos_antiguos = "SELECT * FROM pedidos_antiguos ORDER BY id_pedido DESC";
    $pedidos_antiguos = obtener_todo($query_pedidos_antiguos);
    ?>
    <div class="pedidos">
        <div class="pedido top">
            <div class="pedido_num">#</div>
            <div class="pedido_codigo">Código</div>
            <div class="pedido_total">Total</div>
            <div class="pedido_fecha">Fecha del Pedido</div>
            <div class="pedido_cliente">Cliente</div>
            <div class="pedido_acciones">Acciones</div>
        </div>
        <?php
        if ($pedidos_antiguos) {
                listar_pedidos_antiguos($pedidos_antiguos, $id_lat);
        } else {
            ?>
            <div class="vacio">No hay Pedidos Antiguos Registrados</div>
            <?php
        }
        ?>
    </div>
    <?php
}

function listar_pedidos_antiguos($pedidos_antiguos, $id_lat)
{
    $num = 1;
    foreach ($pedidos_antiguos as $pedido) {
        $id = $pedido['id_pedido'];
        $codigo = $pedido['codigo_pedido'];
        $total = $pedido['total_pedido'];
        $fecha = $pedido['fecha_pedido'];
        $nombre = $pedido['nombre_pedido'];
        ?>
        <div class="pedido">
            <div class="pedido_num"><?php echo $num; ?></div>
            <div class="pedido_codigo"><?php echo $codigo ?></div>
            <div class="pedido_total">S/. <?php echo $total ?></div>
            <div class="pedido_fecha"><?php echo $fecha ?></div>
            <div class="pedido_cliente"><?php echo $nombre ?></div>
            <div class="pedido_acciones">
                <a 
                    href="pedidos.php?menu_lat=<?php echo $id_lat ?>&accview=<?php echo $id ?>" 
                    class="accbtn pedgreen"
                >
                    Ver
                </a>
                <a 
                    href="pedidos.php?menu_lat=<?php echo $id_lat ?>&accdel=<?php echo $id ?>" 
                    class="accbtn pedred"
                >
                    Eliminar
                </a>
            </div>
        </div>
        <?php
        $num++;
    }
}
