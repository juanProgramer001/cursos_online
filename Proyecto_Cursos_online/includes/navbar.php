<nav class="navbar navbar-dark bg-dark px-3">
<span class="navbar-text text-white">Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
<a href="../auth/logout.php" class="btn btn-danger">Salir</a>
</nav>