<?php
declare(strict_types=1);

require_once "../auth/auth.php";
require_once "../config/conexion.php";
require_once "../config/csrf.php";

/* GUARDAR / EDITAR */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    check_csrf();

    $id = (int) ($_POST['id'] ?? 0);
    $nombre = trim((string) ($_POST['nombre'] ?? ''));

    if ($nombre !== '') {
        if ($id === 0) {
            $stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre);
        } else {
            $stmt = $conn->prepare("UPDATE categorias SET nombre=? WHERE id_categoria=?");
            $stmt->bind_param("si", $nombre, $id);
        }
        $stmt->execute();
        $stmt->close();
    }
}

/* ELIMINAR */
if (isset($_GET['del'])) {
    check_csrf();
    $id = (int) $_GET['del'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

/* EDITAR */
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$categorias = $conn->query("SELECT * FROM categorias ORDER BY id_categoria ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Categorías</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<?php require_once "../includes/navbar.php"; ?>

<h3>Categorías</h3>

<form method="post" class="card p-3 mb-4">
<?= csrf(); ?>
<input type="hidden" name="id" value="<?= $edit['id_categoria'] ?? '' ?>">

<input
    class="form-control mb-2"
    name="nombre"
    placeholder="Nombre"
    required
    value="<?= htmlspecialchars($edit['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
>

<button class="btn btn-primary" name="guardar">Guardar</button>
</form>

<table class="table table-bordered">
<tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
<?php while ($c = $categorias->fetch_assoc()): ?>
<tr>
<td><?= (int) $c['id_categoria'] ?></td>
<td><?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
<td>
<a class="btn btn-warning btn-sm" href="?edit=<?= $c['id_categoria'] ?>">Editar</a>
<a class="btn btn-danger btn-sm"
   href="?del=<?= $c['id_categoria'] ?>&token=<?= $_SESSION['token'] ?>"
   onclick="return confirm('¿Eliminar categoría?')">Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
