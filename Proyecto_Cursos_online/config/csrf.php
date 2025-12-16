<?php
if (session_status() === PHP_SESSION_NONE) session_start();


if (empty($_SESSION['token'])) {
$_SESSION['token'] = bin2hex(random_bytes(32));
}


function csrf() {
return '<input type="hidden" name="token" value="'.htmlspecialchars($_SESSION['token']).'">';
}


function check_csrf() {
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
die("CSRF inválido");
}
}
