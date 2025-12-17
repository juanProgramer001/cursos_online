<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "../config/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = trim($_POST["correo"]);
    $clave  = trim($_POST["clave"]);

    if ($correo === "" || $clave === "") {
        $mensaje = "Todos los campos son obligatorios";
    } else {

        $stmt = $conn->prepare("
            SELECT id_usuario, nombre, clave, id_rol
            FROM usuarios
            WHERE correo = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($clave, $usuario["clave"])) {

                $_SESSION["id_usuario"] = $usuario["id_usuario"];
                $_SESSION["nombre"]     = $usuario["nombre"];
                $_SESSION["id_rol"]     = $usuario["id_rol"];

                header("Location: ../index.php");
                exit;
            } else {
                $mensaje = "Correo o contraseña incorrectos";
            }
        } else {
            $mensaje = "Correo o contraseña incorrectos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Iniciar Sesión</h4>

                    <?php if ($mensaje): ?>
                        <div class="alert alert-danger text-center">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="clave" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Ingresar</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="registro.php">Crear cuenta</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
