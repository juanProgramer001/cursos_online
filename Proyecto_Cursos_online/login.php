<?php
session_start();
include "conexion.php";
$error = "";


if (isset($_POST['login'])) {
$correo = $_POST['correo'];
$clave = md5($_POST['clave']);


$sql = "SELECT * FROM usuarios WHERE correo='$correo' AND clave='$clave'";
$res = $conn->query($sql);


if ($res->num_rows == 1) {
$u = $res->fetch_assoc();
$_SESSION['id_usuario'] = $u['id_usuario'];
$_SESSION['nombre'] = $u['nombre'];
$_SESSION['rol'] = $u['id_rol'];
header("Location: cursos.php");
exit();
} else {
$error = "Correo o contraseña incorrectos";
}
}
?>
<!DOCTYPE html>
<html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{height:100vh;background:linear-gradient(120deg,#4e73df,#1cc88a);display:flex;align-items:center;justify-content:center}
.card{width:380px;border-radius:15px}
</style></head>
<body>
<div class="card p-4 shadow">
<h4 class="text-center">Login</h4>
<?php if($error){ ?><div class="alert alert-danger"><?= $error ?></div><?php } ?>
<form method="post">
<input class="form-control mb-3" type="email" name="correo" placeholder="Correo" required>
<input class="form-control mb-3" type="password" name="clave" placeholder="Contraseña" required>
<button class="btn btn-primary w-100" name="login">Ingresar</button>
<a href="registro.php" class="btn btn-link w-100 mt-2">Registrarse</a>
</form></div></body></html>