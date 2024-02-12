<?php

require_once 'includes/lla_generales.php';

$username = $_POST['username'];
$email = $_POST['email'];

// Verificar el nombre de usuario
$query_usuario_comparar = "SELECT * FROM users WHERE username = '$username'";
$usuario_repetido = obtener_linea($query_usuario_comparar);
$existsUsername = false;
if ($usuario_repetido) {
    $existsUsername = true;
}

// Verificar el correo electrónico
$query_mail_comparar = "SELECT * FROM users WHERE email = '$email'";
$mail_repetido = obtener_linea($query_mail_comparar);
$existsEmail = false;
if ($mail_repetido) {
    $existsEmail = true;
}

// Devolver una respuesta en formato JSON
$response = array(
  'exists' => $existsUsername || $existsEmail
);

// Establece el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devuelve la respuesta en formato JSON
echo json_encode($response);
