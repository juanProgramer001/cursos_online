<?php
session_start();
include "../config/conexion.php";
include "../config/csrf.php";
$error="";


if (isset($_POST['login'])) {
check_csrf();
$correo = $_POST['correo'] ?? '';
$clave = $_POST['clave'] ?? '';


$stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo=?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();


if ($u && password_verify($clave, $u['clave'])) {
$_SESSION['id_usuario']=$u['id_usuario'];
$_SESSION['nombre']=$u['nombre'];
header("Location: ../crud/usuarios.php");
exit;
} else {
$error="Credenciales incorrectas";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h3>Login</h3>
<?= $error ? '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>' : '' ?>
<form method="post">
<?= csrf() ?>
<input class="form-control mb-2" name="correo" type="email" placeholder="Correo" required>
<input class="form-control mb-2" name="clave" type="password" placeholder="Contraseña" required>
<button class="btn btn-success" name="login">Ingresar</button>
</form>
</body>
</html>