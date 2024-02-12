<?php

require './config/lla_config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
