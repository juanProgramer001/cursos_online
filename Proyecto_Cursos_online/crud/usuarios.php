<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";


if (isset($_POST['guardar'])) {
check_csrf();
$nombre=$_POST['nombre'];
$correo=$_POST['correo'];
$rol=intval($_POST['rol']);
$conn->prepare("INSERT INTO usuarios(nombre,correo,clave,id_rol) VALUES (?,?,'',?)")
->bind_param("ssi",$nombre,$correo,$rol)->execute();
}


$usuarios = $conn->query("SELECT u.*, r.nombre rol FROM usuarios u JOIN roles r ON u.id_rol=r.id_rol");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Usuarios</h3>
<form method="post" class="row g-2">
<?= csrf() ?>
<div class="col"><input class="form-control" name="nombre" placeholder="Nombre" required></div>
<div class="col"><input class="form-control" name="correo" placeholder="Correo" required></div>
<div class="col"><select class="form-control" name="rol">
<?php $r=$conn->query("SELECT * FROM roles"); while($ro=$r->fetch_assoc()) echo '<option value="'.$ro['id_rol'].'">'.$ro['nombre'].'</option>'; ?>
</select></div>
<div class="col"><button class="btn btn-primary" name="guardar">Guardar</button></div>
</form>
<table class="table table-bordered mt-3">
<tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th></tr>
<?php while($u=$usuarios->fetch_assoc()): ?>
<tr>
<td><?= $u['id_usuario'] ?></td>
<td><?= htmlspecialchars($u['nombre']) ?></td>
<td><?= htmlspecialchars($u['correo']) ?></td>
<td><?= htmlspecialchars($u['rol']) ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>