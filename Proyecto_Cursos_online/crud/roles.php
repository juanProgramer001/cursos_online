<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";


// insertar
if (isset($_POST['guardar'])) {
check_csrf();
$nombre = trim($_POST['nombre'] ?? '');
if ($nombre) {
$stmt = $conn->prepare("INSERT INTO roles(nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);
$stmt->execute();
}
}


// eliminar
if (isset($_GET['eliminar'])) {
$id = intval($_GET['eliminar']);
$conn->prepare("DELETE FROM roles WHERE id_rol=?")
->bind_param("i", $id)->execute();
}


$roles = $conn->query("SELECT * FROM roles");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Roles</h3>
<form method="post" class="row g-2">
<?= csrf() ?>
<div class="col-6"><input class="form-control" name="nombre" placeholder="Nombre del rol" required></div>
<div class="col"><button class="btn btn-primary" name="guardar">Guardar</button></div>
</form>
<table class="table table-bordered mt-3">
<tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
<?php while($r=$roles->fetch_assoc()): ?>
<tr>
<td><?= $r['id_rol'] ?></td>
<td><?= htmlspecialchars($r['nombre']) ?></td>
<td><a href="?eliminar=<?= $r['id_rol'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>