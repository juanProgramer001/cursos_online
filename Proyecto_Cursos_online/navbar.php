<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
<div class="container-fluid">
<a class="navbar-brand" href="cursos.php">Cursos Online</a>
<div class="navbar-nav">
<a class="nav-link" href="cursos.php">Cursos</a>
<a class="nav-link" href="categorias.php">Categorías</a>
<a class="nav-link" href="usuarios.php">Usuarios</a>
<a class="nav-link" href="roles.php">Roles</a>
</div>
<span class="navbar-text text-white me-3">
<?= $_SESSION['nombre'] ?? '' ?>
</span>
<a href="logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
</div>
</nav>