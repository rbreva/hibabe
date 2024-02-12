<?php

$host = 'localhost';
$dbname = 'hibabe2024';
$username = 'root';
$password = '';

// $host = 'localhost';
// $dbname = 'maiarose_trekkinghouseperu';
// $username = 'maiarose_user_trekkinghouseperu';
// $password = '%Gr$n]Y-&%9M';

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
);
