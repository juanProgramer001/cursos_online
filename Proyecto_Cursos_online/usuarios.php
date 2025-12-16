<?php include "conexion.php";
include "auth.php"; include "conexion.php";
if(isset($_POST['guardar'])){
if($_POST['id']==""){
$conn->query("INSERT INTO usuarios(nombre,correo,clave,id_rol) VALUES (
'{$_POST['nombre']}','{$_POST['correo']}',md5('{$_POST['clave']}'),{$_POST['rol']})");
}else{
$conn->query("UPDATE usuarios SET nombre='{$_POST['nombre']}', correo='{$_POST['correo']}', id_rol={$_POST['rol']} WHERE id_usuario={$_POST['id']}");
}}
if(isset($_GET['del'])) $conn->query("DELETE FROM usuarios WHERE id_usuario=".$_GET['del']);
$edit = isset($_GET['edit']) ? $conn->query("SELECT * FROM usuarios WHERE id_usuario=".$_GET['edit'])->fetch_assoc() : null;
?>
<!DOCTYPE html><html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="estilos.css"></head><body>
<?php include "navbar.php"; ?>
<div class="container">
<div class="card p-4 mb-4"><h4>Usuarios</h4>
<form method="post">
<input type="hidden" name="id" value="<?= $edit['id_usuario'] ?? '' ?>">
<input class="form-control mb-2" name="nombre" placeholder="Nombre" required value="<?= $edit['nombre'] ?? '' ?>">
<input class="form-control mb-2" name="correo" placeholder="Correo" required value="<?= $edit['correo'] ?? '' ?>">
<?php if(!$edit){ ?><input class="form-control mb-2" name="clave" placeholder="Clave" required><?php } ?>
<select class="form-control mb-2" name="rol" required>
<option value="">Rol</option>
<?php $roles=$conn->query("SELECT * FROM roles"); while($r=$roles->fetch_assoc()){
$s=($edit && $edit['id_rol']==$r['id_rol'])?'selected':'';
echo "<option value='{$r['id_rol']}' $s>{$r['nombre']}</option>"; }
?>
</select>
<button class="btn btn-primary" name="guardar">Guardar</button>
</form></div>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr>
<?php $res=$conn->query("SELECT u.*, r.nombre rol FROM usuarios u JOIN roles r ON u.id_rol=r.id_rol");
while($u=$res->fetch_assoc()){
echo "<tr><td>{$u['id_usuario']}</td><td>{$u['nombre']}</td><td>{$u['correo']}</td><td>{$u['rol']}</td><td>
<a class='btn btn-warning btn-sm' href='?edit={$u['id_usuario']}'>Editar</a>
<a class='btn btn-danger btn-sm' href='?del={$u['id_usuario']}'>Eliminar</a></td></tr>"; }
?>
</table></div></body></html>