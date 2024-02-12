<?php

function pedidos($type)
{
    $id_lat = 16;
    if (isset($_GET['menu_lat'])) {
        $id_lat = $_GET['menu_lat'];
    }
    $accview = "";
    if (isset($_GET['accview'])) {
        $accview = $_GET['accview'];
    }
    $accdel = "";
    if (isset($_GET['accdel'])) {
        $accdel = $_GET['accdel'];
    }

    if ($accview) {
        pedido($accview, $id_lat);
    } elseif ($accdel) {
        echo "eliminamos pedido";
    } else {
        pedidos_list($type, $id_lat);
    }
}

function pedidos_list($type, $id_lat)
{
    ?>
    <div class="pedidos">
        <div class="pedido top">
            <div class="pedido_num">#</div>
            <div class="pedido_codigo">Código</div>
            <div class="pedido_total">Total</div>
            <div class="pedido_email">Email</div>
            <div class="pedido_fecha">Fecha</div>
            <div class="pedido_tipo">Tipo</div>
            <div class="pedido_estado">Estado</div>
            <div class="pedido_acciones">Acciones</div>
        </div>
        <?php
        $num = 1;
        $query_pedidos = "SELECT * FROM pedidos WHERE estado_pagado = '$type' ORDER BY id DESC";
        $pedidos = obtener_todo($query_pedidos);
        if ($pedidos) {
            foreach ($pedidos as $pedido) {
                $id_estado = $pedido["id_estado_pedido"];
                $query_estado = "SELECT * FROM estado_pedido WHERE id = $id_estado";
                $estado = obtener_linea($query_estado);
                $estado_pedido = $estado["name"];
                ?>
                <div class="pedido">
                    <div class="pedido_num"><?php echo $num; ?></div>
                    <div class="pedido_codigo"><?php echo $pedido["codigo"]; ?></div>
                    <div class="pedido_total">S/. <?php echo $pedido["total"]; ?></div>
                    <div class="pedido_email"><?php echo $pedido["email_pedido"]; ?></div>
                    <div class="pedido_fecha"><?php echo $pedido["fecha"]; ?></div>
                    <div class="pedido_tipo">
                        <?php
                        if ($type == 0) {
                            echo "Abandonado";
                        } else {
                            echo $pedido["estado_pagado"];
                        }
                        ?>
                    </div>
                    <div class="pedido_estado">
                        <?php
                        if ($type == 0) {
                            echo "Abandonado";
                        } else {
                            echo $estado_pedido;
                        }
                        ?>
                    </div>
                    <div class="pedido_acciones">
                        <a 
                            href="pedidos.php?menu_lat=<?php echo $id_lat ?>&accview=<?php echo $pedido["id"]; ?>" 
                            class="accbtn pedgreen"
                        >
                            Ver
                        </a>
                        <a 
                            href="pedidos.php?menu_lat=<?php echo $id_lat ?>&accdel=<?php echo $pedido["id"]; ?>" 
                            class="accbtn pedred"
                        >
                            Eliminar
                        </a>
                    </div>
                </div>
                    <?php
                        $num++;
            }
        } else {
            ?>
            <div class="vacio">No hay Pedidos Registrados</div>
            <?php
        }
        ?>
    </div>
    <?php
}

function pedido($accview, $id_lat)
{
    $estado_msj = "";
    if (isset($_POST['actualiza_estado'])) {
        $nuevo_estado = $_POST['estado'];
        $tracking = "";
        $enviar_correo = "";
        $txt_adicional = "";
        if (isset($_POST['tracking'])) {
            $tracking = $_POST['tracking'];
        }
        if (isset($_POST['enviar_correo'])) {
            $enviar_correo = $_POST['enviar_correo'];
        }
        if (isset($_POST['txt_adicional'])) {
            $txt_adicional = $_POST['txt_adicional'];
        }

        $query_estado_pedido = "UPDATE 
            pedidos 
            SET 
            id_estado_pedido='$nuevo_estado', 
            tracking='$tracking' 
            WHERE 
            id = '$accview'";
        if (actualizar_registro($query_estado_pedido)) {
            $estado_msj = "Estado Actualizado";
        }
        if ($enviar_correo) {
            // echo "enviar a: " . $enviar_correo;
            envio_correo($enviar_correo, $tracking, $nuevo_estado, $txt_adicional);
        }
    }

    $query_pedido = "SELECT * FROM pedidos WHERE id = $accview";
    $pedido = obtener_linea($query_pedido);

    $id_estado = $pedido["id_estado_pedido"];
    $query_estado = "SELECT * FROM estado_pedido WHERE id = $id_estado";
    $estado = obtener_linea($query_estado);
    $estado_pedido = $estado["name"];

    $codigo = $pedido["codigo"];

    $query_estados = "SELECT * FROM estado_pedido";
    $estados = obtener_todo($query_estados);
    ?>
    <div class="pedido">
        <div class="titulo_pedido">
            <div class="pedido_num">Pedido: <?php echo $codigo ?></div>
            <div class="pedido_estado">Estado: <?php echo $estado_pedido ?></div>
            <a href="generar_pdf.php?id=<?php echo $accview ?>" target="_blank" class="btn_descarga_pdf">Descargar pedido PDF</a>
        </div>
        <div class="pedido_sel">
            <div class="datos">
                <div class="nombre">Código:</div>
                <div class="linea"><?php echo $codigo ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Descripción:</div>
                <div class="linea"><?php echo $pedido['descripcion'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Monto Pagado:</div>
                <div class="linea"><?php echo $pedido['moneda'] . " " . $pedido['total'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Fecha de Pedido:</div>
                <div class="linea"><?php echo $pedido['fecha'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Datos de Cliente:</div>
                <div class="linea">
                    Nombre: <?php echo $pedido['nombre_pedido'] ?><br>
                    DNI: <?php echo $pedido['dni_pedido'] ?><br>
                    eMail: <?php echo $pedido['email_pedido'] ?><br>
                    Teléfono: <?php echo $pedido['celular_pedido'] ?><br>
                    Fijo: <?php echo $pedido['fijo_pedido'] ?><br>
                </div>
            </div>
            <div class="datos">
                <?php
                if ($pedido['metodo_pedido'] == "envio") {
                    ?>
                    <div class="nombre">Datos de Envío:</div>
                    <div class="linea">
                        Envio: <?php echo $pedido['envio_pedido'] ?><br>
                        Departamento: <?php echo $pedido['depa_pedido'] ?><br>
                        Provincia: <?php echo $pedido['prov_pedido'] ?><br>
                        Distrito: <?php echo $pedido['dist_pedido'] ?><br>
                        Direccion: <?php echo $pedido['direccion_pedido'] ?><br>
                        Referencia: <?php echo $pedido['referencia_pedido'] ?><br>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="nombre">Datos de Envío:</div>
                    <div class="linea">
                        Envio: Recojo en tienda<br>
                        Tienda: <?php echo $pedido['tienda_pedido'] ?><br>
                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="datos">
                <div class="nombre">Uso de Cupón:</div>
                <div class="linea"><?php echo $pedido['cupon'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Uso de Nota de Crédito:</div>
                <div class="linea"><?php echo $pedido['nota'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Tipo de Pago:</div>
                <div class="linea"><?php echo $pedido['estado_pagado'] ?></div>
            </div>
            <div class="datos">
                <div class="nombre">Estado:</div>
                <div class="linea">

                    <form class="form_datos" action="pedidos.php?menu_lat=<?php echo $id_lat ?>&accview=<?php echo $accview ?>" method="post">
                        <div>
                            <select name="estado">
                                <?php
                                foreach ($estados as $row) {
                                    $select = "";
                                    $id_estado_pedido = $row['id'];
                                    $nombre_estado_pedido = $row['name'];
                                    if ($id_estado_pedido == $pedido['id_estado_pedido']) {
                                        $select = "selected";
                                    }
                                    ?>
                                    <option value="<?php echo $id_estado_pedido ?>" <?php echo $select ?>>
                                        <?php echo $nombre_estado_pedido ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                            $tracking = "";
                            if ($pedido['tracking']) {
                                $tracking = $pedido['tracking'];
                            }
                            ?>
                        </div>
                        <div>
                            <label>Tracking Number: </label>
                            <input type="text" name="tracking" placeholder="Agregar Tracking number" value="<?php echo $tracking ?>">
                            <input type="hidden" name="actualiza_estado" value="actualiza">
                        </div>
                        <div>
                            <label>Texto Adicional (Opcional)(max 100 Caracteres.)</label><br>
                            <textarea type="text" name="txt_adicional" value="" maxlength="100"></textarea>
                        </div>
                        <div>
                            <label>Enviar Correo</label>
                            <input type="checkbox" name="enviar_correo" value="<?php echo $accview ?>">
                        </div>
                        <button class="form_datos_btn">Actualizar Estado</button>
                    </form>

                </div>
                <div class="nombre" id="content"><?php echo $estado_msj ?></div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        setTimeout(function() {
                            $("#content").fadeOut(1500);
                        }, 3000);
                        //          console.log("aca")
                    });
                </script>
            </div>
        </div>
    </div>
    <?php
}

function envio_correo($enviar_correo, $tracking, $nuevo_estado, $txt_adicional)
{
    $query_pedido = "SELECT * FROM pedidos WHERE id = $enviar_correo";
    $pedido = obtener_linea($query_pedido);
    $codigo = $pedido["codigo"];
    $nombre_pedido = $pedido["nombre_pedido"];
    $email_pedido = $pedido["email_pedido"];

    $query_estado = "SELECT * FROM estado_pedido WHERE id = $nuevo_estado";
    $estado = obtener_linea($query_estado);
    $nuevo_estado_nombre = $estado["name"];

    $destinatario = "retail@cocojolieonline.com";

    $asunto_comprador = "Actualización de tu pedido: $codigo en Shop-CocoJolie";
    $cuerpo = " 
    <html>
    <head>
        <title>Compras Shop-CocoJolie</title>
    </head>
    <body>
    <br>
    <table align='center' border='0' cellpadding='0' cellspacing='0' width='800'>
        <tbody>
            <tr>
                <td>
                    <img 
                    alt='Cocojolie' 
                    src='https://www.shop-cocojolie.com/images/rep/cocojolie_reg.jpg' 
                    style='display:block; border:0px;' width='800' />
                </td>
            </tr>
            <tr>
                <td>
                &nbsp;<br>
                </td>
            </tr>
            <tr>
                <td 
                style='font-size:14px; 
                    color:#000; 
                    font-family:Arial, Helvetica, sans-serif; 
                    text-decoration:none; 
                    line-height:12px; 
                    -webkit-text-size-adjust:none' 
                align='center'>
                    <p><strong>¡Hola $nombre_pedido Muchas gracias por tu compra!</strong></p><br>
                    <table>
                        <tr>
                            <td style='padding:10px '>
                            <p>Tu pedido se encuentra: $nuevo_estado_nombre</p>
                            </td>
                        </tr>
                    </table>
                    <table width='100%' border='1px' cellspacing='0'>
                        <tr height='40px'>
                            <td align='center' colspan='4'>
                            <strong>Pedido: $codigo </strong>
                            </td>
                        </tr>
                        ";

    if ($tracking) {
        $cuerpo .= "
        <tr height='40px'>
            <td align='center' colspan='4'>
            <strong>Tracking: $tracking</strong>
            </td>
        </tr>";
    }

    if ($txt_adicional) {
        $cuerpo .= "
        <tr height='40px'>
            <td align='center' colspan='4'>
            <strong>$txt_adicional</strong>
            </td>
        </tr>";
    }

    $cuerpo .= "
    <br>
    </td>
    </tr>
    </table>
    
    <br>
    <br>
    <br>
    </td>
    </tr>
    
    <tr>
    <td>&nbsp;<br></td>
    </tr>
    
    <tr bgcolor='#494542'>
    <td 
    style='font-size:14px; 
        color:#FFF; 
        font-family:Arial, Helvetica, sans-serif; 
        text-decoration:none; 
        line-height:12px; 
        -webkit-text-size-adjust:none' 
        align='center'>
    <br>
    <p>Mantente en contacto</p>
    <br>
    </td>
    </tr>
    
    </tbody>
    </table>
    
    <table align='center' border='0' cellpadding='0' cellspacing='0' width='800'>
        <tbody>
            <tr>
                <td style='font-size:10px; 
                    color:#000; 
                    font-family:Arial, Helvetica, sans-serif; 
                    text-decoration:none; 
                    line-height:12px; 
                    -webkit-text-size-adjust:none'>
                    <br>
                    <p><font color='#333333'>Copyright &copy; 2019 CocoJolie, 
                    Todos los derechos reservados.</font></p>
                    <br>
                </td>
            </tr>
        </tbody>
    </table>
    </body>
    </html>";

    //para el envío en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    //dirección del remitente
    $headers .= "From: Compras - CocoJolie <compras@shop-cocojolie.com>\r\n";

    //dirección de respuesta, si queremos que sea distinta que la del remitente
    $headers .= "Reply-To: compras@shop-cocojolie.com\r\n";

    //ruta del mensaje desde origen a destino
    $headers .= "Return-path: compras@shop-cocojolie.com\r\n";

    //direcciones que recibián copia
    $headers .= "Cc: " . $destinatario . "\r\n";

    //direcciones que recibirán copia oculta
    $headers .= "Bcc: rbreva@gmail.com\r\n";

    mail($email_pedido, $asunto_comprador, $cuerpo, $headers);

    // echo "<pre>";
    // print_r($cuerpo);
    // echo "</pre>";
}
