<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";

if(isset($_POST['guardar'])){
    check_csrf();
    $curso=intval($_POST['curso']);
    $titulo=$_POST['titulo'];
    $desc=$_POST['descripcion'];

    $stmt=$conn->prepare("INSERT INTO modulos(id_curso,titulo,descripcion) VALUES (?,?,?)");
    $stmt->bind_param("iss",$curso,$titulo,$desc);
    $stmt->execute();
}

$modulos=$conn->query("
SELECT m.*, c.titulo curso FROM modulos m
JOIN cursos c ON m.id_curso=c.id_curso
");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Módulos</h3>

<form method="post">
<?= csrf() ?>
<select class="form-control mb-2" name="curso">
<?php
$c=$conn->query("SELECT * FROM cursos");
while($x=$c->fetch_assoc())
echo "<option value='{$x['id_curso']}'>{$x['titulo']}</option>";
?>
</select>
<input class="form-control mb-2" name="titulo" placeholder="Título" required>
<textarea class="form-control mb-2" name="descripcion"></textarea>
<button class="btn btn-primary" name="guardar">Guardar</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Curso</th><th>Módulo</th></tr>
<?php while($m=$modulos->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($m['curso']) ?></td>
<td><?= htmlspecialchars($m['titulo']) ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
