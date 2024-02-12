<?php

function lista_clientes($clientes)
{
    ?>
<div class="barra_titulo">
<h2 class="titulo_h2">Clientes</h2>
    <div class="botones_prod">
        <a href="clientes.xlsx" class="nuevo_btn">
            Descargar Lista Clientes
        </a>
    </div>
</div>
<div class="cuadro">
    <div class="titulo_prod">Lista de Clientes</div>
    <?php
    clientesactivos($clientes);
    ?>
</div>
    <?php
}

function clientesactivos($clientes)
{
    ?>
<div class="clientes">
    <div class="cliente header">
        <div class="cliente_item idcli">Id</div>
        <div class="cliente_item nombre">Nombres</div>
        <div class="cliente_item apellido">Apellidos</div>
        <div class="cliente_item dni">DNI</div>
        <div class="cliente_item mail">Email</div>
        <div class="cliente_item birth">Fec. Nac</div>
        <div class="cliente_item celular">Celular</div>
        <div class="cliente_item ingreso">Último ingreso</div>
    </div>
    <?php
    if ($clientes) {
        foreach ($clientes as $cliente) {
            ?>
            <div class="cliente">
                <div class="cliente_item idcli"><?php echo $cliente['id'] ?></div>
                <div class="cliente_item nombre"><?php echo $cliente['nombres'] ?></div>
                <div class="cliente_item apellido"><?php echo $cliente['paterno'] . ' ' . $cliente['materno'] ?></div>
                <div class="cliente_item dni"><?php echo $cliente['dni'] ?></div>
                <div class="cliente_item mail"><?php echo $cliente['email'] ?></div>
                <div class="cliente_item birth"><?php echo $cliente['birth'] ?></div>
                <div class="cliente_item celular"><?php echo $cliente['celular'] ?></div>
                <div class="cliente_item ingreso"><?php echo $cliente['ult_fecha_ingreso'] ?></div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="cliente">
            <div class="cliente_item idcli">-</div>
            <div class="cliente_item nombre">-</div>
            <div class="cliente_item apellido">-</div>
            <div class="cliente_item dni">-</div>
            <div class="cliente_item mail">-</div>
            <div class="cliente_item birth">-</div>
            <div class="cliente_item celular">-</div>
            <div class="cliente_item ingreso">-</div>
        </div>
        <?php
    }
    ?>
</div>
    <?php
}
