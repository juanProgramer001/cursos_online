<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: auth/login.php');
    exit;
}

$id_rol = (int) $_SESSION['id_rol'];
$nombre = htmlspecialchars((string) $_SESSION['nombre'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
<a class="navbar-brand" href="index.php">Cursos Online</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">
<ul class="navbar-nav me-auto">

<?php if ($id_rol === 1): ?>
<li class="nav-item"><a class="nav-link" href="crud/usuarios.php">Usuarios</a></li>
<li class="nav-item"><a class="nav-link" href="crud/roles.php">Roles</a></li>
<li class="nav-item"><a class="nav-link" href="crud/categorias.php">Categorías</a></li>
<?php endif; ?>

<?php if ($id_rol === 1 || $id_rol === 2): ?>
<li class="nav-item"><a class="nav-link" href="crud/cursos.php">Cursos</a></li>
<li class="nav-item"><a class="nav-link" href="crud/modulos.php">Módulos</a></li>
<li class="nav-item"><a class="nav-link" href="crud/lecciones.php">Lecciones</a></li>
<?php endif; ?>

<?php if ($id_rol === 3): ?>
<li class="nav-item"><a class="nav-link" href="crud/progreso.php">Progreso</a></li>
<li class="nav-item"><a class="nav-link" href="crud/comentarios.php">Comentarios</a></li>
<?php endif; ?>

</ul>

<span class="navbar-text text-white me-3">👤 <?= $nombre ?></span>
<a href="auth/logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>

</div>
</div>
</nav>

<div class="container mt-5">
<h3>Panel principal</h3>
<p>Selecciona una opción del menú superior.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
