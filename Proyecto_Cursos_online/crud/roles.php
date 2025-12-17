<?php
declare(strict_types=1);

require_once "../auth/auth.php";
require_once "../config/conexion.php";
require_once "../config/csrf.php";

/* ===========================
   INSERTAR ROL
=========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {

    check_csrf();

    $nombre = trim((string) ($_POST['nombre'] ?? ''));

    if ($nombre !== '') {
        $stmt = $conn->prepare("INSERT INTO roles (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->close();
    }
}

/* ===========================
   ELIMINAR ROL
=========================== */
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {

    check_csrf();

    $id = (int) $_GET['eliminar'];

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM roles WHERE id_rol = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

/* ===========================
   LISTAR ROLES
=========================== */
$roles = $conn->query("SELECT id_rol, nombre FROM roles ORDER BY id_rol ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Roles</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<?php require_once "../includes/navbar.php"; ?>

<h3 class="mb-3">Gestión de Roles</h3>

<form method="post" class="row g-2 mb-4">
    <?= csrf(); ?>

    <div class="col-md-6">
        <input
            type="text"
            name="nombre"
            class="form-control"
            placeholder="Nombre del rol"
            required
        >
    </div>

    <div class="col-md-2">
        <button type="submit" name="guardar" class="btn btn-primary w-100">
            Guardar
        </button>
    </div>
</form>

<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acción</th>
</tr>
</thead>
<tbody>
<?php while ($r = $roles->fetch_assoc()): ?>
<tr>
    <td><?= (int) $r['id_rol']; ?></td>
    <td><?= htmlspecialchars($r['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
        <a
            href="?eliminar=<?= (int) $r['id_rol']; ?>&token=<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('¿Eliminar este rol?')"
        >
            Eliminar
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</body>
</html>
