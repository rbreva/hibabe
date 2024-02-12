<?php

function upload()
{
    if (isset($_POST['subir'])) {
        include_once 'procesar.php';
    } else {
        upload_form();
    }
}

function upload_form()
{
    ?>
<div class="wrap">
    <div class="barra_titulo">
        <h2 class="titulo_h2">Agregar Productos</h2>
        <div class="botones_prod">
            <a target="_blank" href="descargas/plantilla_productos_modelo.xlsx" class="nuevo_btn">
            Descarga Modelo Excel
            </a>
        </div>
    </div>    
    <form class="upload" action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo_excel" required/>
        <input type="hidden" name="subir">
        <button type="submit">Subir Archivo</button>
    </form>
</div>    
    <?php
}

function uploadfotos()
{
    if (isset($_POST['subir'])) {
        include_once 'procesar_fotos.php';
    } else {
        upload_form_fotos();
    }
}

function upload_form_fotos()
{
    ?>
<div class="wrap">
    <div class="barra_titulo">
        <h2 class="titulo_h2">Agregar Fotos</h2>
        <div class="botones_prod">
            <a target="_blank" href="descargas/plantilla_productos_modelo.xlsx" class="nuevo_btn">
            Descarga Modelo Excel
        </a>
        </div>
    </div>    
    <form class="upload" action="upload.php?menu_lat=10" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo_excel" required/>
        <input type="hidden" name="subir">
        <button type="submit">Subir Fotos</button>
    </form>
</div>    
    <?php
}

function descargar_productos()
{
    include_once 'descargar_excel.php';
}

function borrartodo()
{
    include_once 'borrar_todo.php';
}
