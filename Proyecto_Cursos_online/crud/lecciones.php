<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";

if(isset($_POST['guardar'])){
    check_csrf();
    $modulo=intval($_POST['modulo']);
    $titulo=$_POST['titulo'];
    $contenido=$_POST['contenido'];

    $stmt=$conn->prepare("INSERT INTO lecciones(id_modulo,titulo,contenido) VALUES (?,?,?)");
    $stmt->bind_param("iss",$modulo,$titulo,$contenido);
    $stmt->execute();
}

$lecciones=$conn->query("
SELECT l.*, m.titulo modulo FROM lecciones l
JOIN modulos m ON l.id_modulo=m.id_modulo
");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Lecciones</h3>

<form method="post">
<?= csrf() ?>
<select class="form-control mb-2" name="modulo">
<?php
$m=$conn->query("SELECT * FROM modulos");
while($x=$m->fetch_assoc())
echo "<option value='{$x['id_modulo']}'>{$x['titulo']}</option>";
?>
</select>
<input class="form-control mb-2" name="titulo" placeholder="Título" required>
<textarea class="form-control mb-2" name="contenido"></textarea>
<button class="btn btn-primary" name="guardar">Guardar</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Módulo</th><th>Lección</th></tr>
<?php while($l=$lecciones->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($l['modulo']) ?></td>
<td><?= htmlspecialchars($l['titulo']) ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
