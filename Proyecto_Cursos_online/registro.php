<?php
include "conexion.php";
$msg="";
if(isset($_POST['registrar'])){
$nombre=$_POST['nombre'];
$correo=$_POST['correo'];
$clave=md5($_POST['clave']);
$rol=$_POST['rol'];


$val=$conn->query("SELECT * FROM usuarios WHERE correo='$correo'");
if($val->num_rows>0){
$msg="El correo ya existe";
}else{
$conn->query("INSERT INTO usuarios(nombre,correo,clave,id_rol)
VALUES('$nombre','$correo','$clave','$rol')");
$msg="Usuario registrado correctamente";
}
}
?>
<!DOCTYPE html>
<html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{height:100vh;background:linear-gradient(120deg,#1cc88a,#4e73df);display:flex;align-items:center;justify-content:center}
.card{width:420px;border-radius:15px}
</style></head>
<body>
<div class="card p-4 shadow">
<h4 class="text-center">Registro</h4>
<?php if($msg){ ?><div class="alert alert-info"><?= $msg ?></div><?php } ?>
<form method="post">
<input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
<input class="form-control mb-2" type="email" name="correo" placeholder="Correo" required>
<input class="form-control mb-2" type="password" name="clave" placeholder="Contraseña" required>
<select class="form-control mb-3" name="rol" required>
<option value="">Rol</option>
<?php $r=$conn->query("SELECT * FROM roles"); while($ro=$r->fetch_assoc()){
echo "<option value='{$ro['id_rol']}'>{$ro['nombre']}</option>"; }
?>
</select>
<button class="btn btn-success w-100" name="registrar">Registrar</button>
<a href="login.php" class="btn btn-link w-100 mt-2">Volver al login</a>
</form></div></body></html>