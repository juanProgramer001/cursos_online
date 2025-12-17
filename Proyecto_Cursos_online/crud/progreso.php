<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";

if (isset($_POST['guardar'])) {
    check_csrf();
    $usuario = intval($_POST['usuario']);
    $leccion = intval($_POST['leccion']);
    $completado = isset($_POST['completado']) ? 1 : 0;

    $stmt = $conn->prepare(
        "INSERT INTO progreso(id_usuario,id_leccion,completado) VALUES (?,?,?)"
    );
    $stmt->bind_param("iii",$usuario,$leccion,$completado);
    $stmt->execute();
}

$progreso = $conn->query("
SELECT p.*, u.nombre usuario, l.titulo leccion
FROM progreso p
JOIN usuarios u ON p.id_usuario=u.id_usuario
JOIN lecciones l ON p.id_leccion=l.id_leccion
");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Progreso</h3>

<form method="post">
<?= csrf() ?>
<select class="form-control mb-2" name="usuario">
<?php
$u=$conn->query("SELECT * FROM usuarios");
while($x=$u->fetch_assoc())
echo "<option value='{$x['id_usuario']}'>{$x['nombre']}</option>";
?>
</select>

<select class="form-control mb-2" name="leccion">
<?php
$l=$conn->query("SELECT * FROM lecciones");
while($x=$l->fetch_assoc())
echo "<option value='{$x['id_leccion']}'>{$x['titulo']}</option>";
?>
</select>

<div class="form-check mb-2">
<input class="form-check-input" type="checkbox" name="completado" id="c1">
<label class="form-check-label" for="c1">Completado</label>
</div>

<button class="btn btn-primary" name="guardar">Guardar</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Usuario</th><th>Lección</th><th>Estado</th></tr>
<?php while($p=$progreso->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($p['usuario']) ?></td>
<td><?= htmlspecialchars($p['leccion']) ?></td>
<td><?= $p['completado'] ? 'Completado' : 'Pendiente' ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
