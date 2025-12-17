<?php
declare(strict_types=1);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'bd_cursos_online';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Error de conexión');
}

$conn->set_charset('utf8mb4');
