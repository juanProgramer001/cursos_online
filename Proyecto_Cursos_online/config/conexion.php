<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bd_cursos_online";


$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");


if ($conn->connect_error) {
die("Error de conexión");
}

?>