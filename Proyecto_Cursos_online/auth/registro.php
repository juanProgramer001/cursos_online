<?php
include "../config/conexion.php";
include "../config/csrf.php";
$msg="";


if (isset($_POST['registrar'])) {
check_csrf();
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$clave = $_POST['clave'] ?? '';
$rol = intval($_POST['rol'] ?? 0);


if ($nombre && $correo && $clave && $rol) {
$hash = password_hash($clave, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO usuarios(nombre,correo,clave,id_rol) VALUES (?,?,?,?)");
$stmt->bind_param("sssi", $nombre, $correo, $hash, $rol);
$stmt->execute();
$msg="Usuario registrado correctamente";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h3>Registro</h3>
<?= $msg ? '<div class="alert alert-success">'.htmlspecialchars($msg).'</div>' : '' ?>
<form method="post">
<?= csrf() ?>
<input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
<input class="form-control mb-2" name="correo" type="email" placeholder="Correo" required>
<input class="form-control mb-2" name="clave" type="password" placeholder="Contraseña" required>
<select class="form-control mb-2" name="rol" required>
<option value="">Seleccione rol</option>
<?php
$res = $conn->query("SELECT * FROM roles");
while($r=$res->fetch_assoc()){
echo '<option value="'.$r['id_rol'].'">'.htmlspecialchars($r['nombre']).'</option>';
}
?>
</select>
<button class="btn btn-primary" name="registrar">Registrar</button>
</form>
</body>
</html>