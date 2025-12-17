<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../config/conexion.php";

$mensaje = "";

/* OBTENER ROLES */
$roles = $conn->query("SELECT id_rol, nombre FROM roles");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clave  = trim($_POST["clave"]);
    $id_rol = intval($_POST["id_rol"]);

    if ($nombre === "" || $correo === "" || $clave === "" || $id_rol === 0) {
        $mensaje = "Todos los campos son obligatorios";
    } else {

        // Verificar si el correo ya existe
        $verificar = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows > 0) {
            $mensaje = "El correo ya está registrado";
        } else {

            // Encriptar contraseña
            $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO usuarios (nombre, correo, clave, id_rol)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssi", $nombre, $correo, $clave_hash, $id_rol);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $mensaje = "Error al registrar usuario";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Registro de Usuario</h4>

                    <?php if ($mensaje): ?>
                        <div class="alert alert-warning text-center">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="clave" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select name="id_rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                <?php while ($rol = $roles->fetch_assoc()): ?>
                                    <option value="<?= $rol['id_rol'] ?>">
                                        <?= $rol['nombre'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button class="btn btn-success w-100">Registrarse</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
                                    