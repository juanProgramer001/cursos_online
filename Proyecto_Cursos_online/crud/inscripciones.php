<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";

if(isset($_POST['guardar'])){
    check_csrf();
    $usuario=intval($_POST['usuario']);
    $curso=intval($_POST['curso']);

    $stmt=$conn->prepare("INSERT INTO inscripciones(id_usuario,id_curso) VALUES (?,?)");
    $stmt->bind_param("ii",$usuario,$curso);
    $stmt->execute();
}

$ins=$conn->query("
SELECT i.*, u.nombre usuario, c.titulo curso
FROM inscripciones i
JOIN usuarios u ON i.id_usuario=u.id_usuario
JOIN cursos c ON i.id_curso=c.id_curso
");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Inscripciones</h3>

<form method="post">
<?= csrf() ?>
<select class="form-control mb-2" name="usuario">
<?php
$u=$conn->query("SELECT * FROM usuarios");
while($x=$u->fetch_assoc())
echo "<option value='{$x['id_usuario']}'>{$x['nombre']}</option>";
?>
</select>
<select class="form-control mb-2" name="curso">
<?php
$c=$conn->query("SELECT * FROM cursos");
while($x=$c->fetch_assoc())
echo "<option value='{$x['id_curso']}'>{$x['titulo']}</option>";
?>
</select>
<button class="btn btn-primary" name="guardar">Inscribir</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Usuario</th><th>Curso</th></tr>
<?php while($i=$ins->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($i['usuario']) ?></td>
<td><?= htmlspecialchars($i['curso']) ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
