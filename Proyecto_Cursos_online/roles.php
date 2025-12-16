<?php include "conexion.php";
include "auth.php"; include "conexion.php"; 
if(isset($_POST['guardar'])){
if($_POST['id']==""){
$conn->query("INSERT INTO roles(nombre) VALUES ('{$_POST['nombre']}')");
}else{
$conn->query("UPDATE roles SET nombre='{$_POST['nombre']}' WHERE id_rol={$_POST['id']}");
}}
if(isset($_GET['del'])) $conn->query("DELETE FROM roles WHERE id_rol=".$_GET['del']);
$edit = isset($_GET['edit']) ? $conn->query("SELECT * FROM roles WHERE id_rol=".$_GET['edit'])->fetch_assoc() : null;
?>
<!DOCTYPE html><html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="estilos.css"></head><body>
<?php include "navbar.php"; ?>
<div class="container">
<div class="card p-4 mb-4"><h4>Roles</h4>
<form method="post">
<input type="hidden" name="id" value="<?= $edit['id_rol'] ?? '' ?>">
<input class="form-control mb-2" name="nombre" placeholder="Rol" required value="<?= $edit['nombre'] ?? '' ?>">
<button class="btn btn-primary" name="guardar">Guardar</button>
</form></div>
<table class="table table-bordered"><tr><th>ID</th><th>Rol</th><th>Acciones</th></tr>
<?php $res=$conn->query("SELECT * FROM roles"); while($r=$res->fetch_assoc()){
echo "<tr><td>{$r['id_rol']}</td><td>{$r['nombre']}</td><td>
<a class='btn btn-warning btn-sm' href='?edit={$r['id_rol']}'>Editar</a>
<a class='btn btn-danger btn-sm' href='?del={$r['id_rol']}'>Eliminar</a></td></tr>"; }
?>
</table></div></body></html>