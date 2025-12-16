<?php
include "../auth/auth.php";
include "../config/conexion.php";
include "../config/csrf.php";

if (isset($_POST['guardar'])) {
    check_csrf();
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $profesor = intval($_POST['profesor']);
    $categoria = intval($_POST['categoria']);

    $stmt = $conn->prepare(
        "INSERT INTO cursos(titulo,descripcion,id_profesor,id_categoria) VALUES (?,?,?,?)"
    );
    $stmt->bind_param("ssii",$titulo,$descripcion,$profesor,$categoria);
    $stmt->execute();
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->prepare("DELETE FROM cursos WHERE id_curso=?")
         ->bind_param("i",$id)->execute();
}

$cursos = $conn->query("
SELECT c.*, u.nombre profesor, ca.nombre categoria
FROM cursos c
JOIN usuarios u ON c.id_profesor=u.id_usuario
LEFT JOIN categorias ca ON c.id_categoria=ca.id_categoria
");
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php include "../includes/navbar.php"; ?>
<h3>Cursos</h3>

<form method="post">
<?= csrf() ?>
<input class="form-control mb-2" name="titulo" placeholder="Título" required>
<textarea class="form-control mb-2" name="descripcion" placeholder="Descripción"></textarea>

<select class="form-control mb-2" name="profesor">
<?php
$p=$conn->query("SELECT * FROM usuarios WHERE id_rol=2");
while($x=$p->fetch_assoc())
echo "<option value='{$x['id_usuario']}'>{$x['nombre']}</option>";
?>
</select>

<select class="form-control mb-2" name="categoria">
<?php
$c=$conn->query("SELECT * FROM categorias");
while($x=$c->fetch_assoc())
echo "<option value='{$x['id_categoria']}'>{$x['nombre']}</option>";
?>
</select>

<button class="btn btn-primary" name="guardar">Guardar</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Título</th><th>Profesor</th><th>Categoría</th><th></th></tr>
<?php while($c=$cursos->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($c['titulo']) ?></td>
<td><?= htmlspecialchars($c['profesor']) ?></td>
<td><?= htmlspecialchars($c['categoria']) ?></td>
<td><a href="?eliminar=<?= $c['id_curso'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
