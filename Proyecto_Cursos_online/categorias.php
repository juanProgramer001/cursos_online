<?php include "conexion.php";
include "auth.php"; include "conexion.php";
if(isset($_POST['guardar'])){
if($_POST['id']==""){
$conn->query("INSERT INTO categorias(nombre) VALUES ('{$_POST['nombre']}')");
}else{
$conn->query("UPDATE categorias SET nombre='{$_POST['nombre']}' WHERE id_categoria={$_POST['id']}");
}
}
if(isset($_GET['del'])) $conn->query("DELETE FROM categorias WHERE id_categoria=".$_GET['del']);
$edit = isset($_GET['edit']) ? $conn->query("SELECT * FROM categorias WHERE id_categoria=".$_GET['edit'])->fetch_assoc() : null;
?>
<!DOCTYPE html><html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="estilos.css"></head><body>
<?php include "navbar.php"; ?>
<div class="container">
<div class="card p-4 mb-4">
<h4>Categorías</h4>
<form method="post">
<input type="hidden" name="id" value="<?= $edit['id_categoria'] ?? '' ?>">
<input class="form-control mb-2" name="nombre" placeholder="Nombre" required value="<?= $edit['nombre'] ?? '' ?>">
<button class="btn btn-primary" name="guardar">Guardar</button>
</form></div>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
<?php $res=$conn->query("SELECT * FROM categorias"); while($r=$res->fetch_assoc()){
echo "<tr><td>{$r['id_categoria']}</td><td>{$r['nombre']}</td><td>
<a class='btn btn-warning btn-sm' href='?edit={$r['id_categoria']}'>Editar</a>
<a class='btn btn-danger btn-sm' href='?del={$r['id_categoria']}'>Eliminar</a></td></tr>"; }
?>
</table></div></body></html>