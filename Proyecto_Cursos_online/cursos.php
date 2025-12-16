<?php
include "conexion.php";
include "auth.php"; include "conexion.php";

// GUARDAR / ACTUALIZAR
if(isset($_POST['guardar'])){
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$profesor = $_POST['profesor'];
$categoria = $_POST['categoria'];


if($id==""){
$conn->query("INSERT INTO cursos (titulo,descripcion,id_profesor,id_categoria)
VALUES ('$titulo','$descripcion','$profesor','$categoria')");
}else{
$conn->query("UPDATE cursos SET titulo='$titulo', descripcion='$descripcion',
id_profesor='$profesor', id_categoria='$categoria' WHERE id_curso='$id'");
}
}

// ELIMINAR
if(isset($_GET['del'])){
$conn->query("DELETE FROM cursos WHERE id_curso=".$_GET['del']);
}


$edit=null;
if(isset($_GET['edit'])){
$edit=$conn->query("SELECT * FROM cursos WHERE id_curso=".$_GET['edit'])->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php include "navbar.php"; ?>


<div class="container">
<div class="card p-4 mb-4">
<h4>Formulario Curso</h4>
<form method="post">
<input type="hidden" name="id" value="<?= $edit['id_curso'] ?? '' ?>">
<input class="form-control mb-2" name="titulo" placeholder="Título" required value="<?= $edit['titulo'] ?? '' ?>">
<textarea class="form-control mb-2" name="descripcion" placeholder="Descripción"><?= $edit['descripcion'] ?? '' ?></textarea>


<select class="form-control mb-2" name="profesor" required>
<option value="">Profesor</option>
<?php
$pro=$conn->query("SELECT * FROM usuarios WHERE id_rol=2");
while($p=$pro->fetch_assoc()){
$s=($edit && $edit['id_profesor']==$p['id_usuario'])?'selected':'';
echo "<option value='{$p['id_usuario']}' $s>{$p['nombre']}</option>";
}
?>
</select>


<select class="form-control mb-2" name="categoria">
<option value="">Categoría</option>
<?php
$cat=$conn->query("SELECT * FROM categorias");
while($c=$cat->fetch_assoc()){
$s=($edit && $edit['id_categoria']==$c['id_categoria'])?'selected':'';
echo "<option value='{$c['id_categoria']}' $s>{$c['nombre']}</option>";
}
?>
</select>


<button class="btn btn-primary" name="guardar">Guardar</button>
</form>
</div>


<table class="table table-bordered">
<tr><th>ID</th><th>Título</th><th>Acciones</th></tr>
<?php
$res=$conn->query("SELECT * FROM cursos");
while($r=$res->fetch_assoc()){
echo "<tr>
<td>{$r['id_curso']}</td>
<td>{$r['titulo']}</td>
<td>
<a class='btn btn-warning btn-sm' href='?edit={$r['id_curso']}'>Editar</a>
<a class='btn btn-danger btn-sm' href='?del={$r['id_curso']}'>Eliminar</a>
</td></tr>";
}
?>
</table>
</div>
</body>
</html>