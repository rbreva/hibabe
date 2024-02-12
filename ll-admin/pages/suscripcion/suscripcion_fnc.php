<?php

function lista_suscriptores()
{
    ?>
<div class="barra_titulo">
<h2 class="titulo_h2">Suscriptores</h2>
    <div class="botones_prod">
        <a href="suscripcion.xlsx" class="nuevo_btn">
            Descargar Lista Suscriptores
        </a>
    </div>
</div>
<div class="cuadro">
    <div class="titulo_prod">Lista de Suscriptores</div>
    <?php
    suscriptores();
    ?>
</div>
    <?php
}

function suscriptores()
{
    $query_suscriptores = "SELECT * FROM suscripcion";
    $suscriptores = obtener_todo($query_suscriptores);
    ?>
<div class="clientes">
    <div class="cliente header">
        <div class="cliente_item idcli">#</div>
        <div class="cliente_item mail">Email</div>
        <div class="cliente_item celular">Nombre</div>
        <div class="cliente_item celular">Celular</div>
    </div>
    <?php
    if ($suscriptores) {
        $i = 1;
        foreach ($suscriptores as $suscriptor) {
            ?>
            <div class="cliente">
                <div class="cliente_item idcli"><?php echo $i ?></div>
                <div class="cliente_item mail"><?php echo $suscriptor['email'] ?></div>
                <div class="cliente_item celular"><?php echo $suscriptor['nombre'] ?></div>
                <div class="cliente_item celular"><?php echo $suscriptor['celular'] ?></div>
            </div>
            <?php
            $i++;
        }
    } else {
        ?>
        <div class="cliente">
            <div class="cliente_item idcli">-</div>
            <div class="cliente_item mail">-</div>
            <div class="cliente_item celular">-</div>
        </div>
        <?php
    }
    ?>
</div>
    <?php
}
