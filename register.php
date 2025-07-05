<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $contraseña = trim($_POST['contraseña']);
    $tiempo = trim($_POST['tiempo']);

    // Verificar si el usuario ya existe
    $verificar = "SELECT id FROM alumnos WHERE nombre = '$nombre'";
    $resultado = mysqli_query($conn, $verificar);

    if (mysqli_num_rows($resultado) > 0) {
        $error = "El nombre ya está registrado.";
    } else {
        $sql = "INSERT INTO alumnos (nombre, contraseña, tiempo) VALUES ('$nombre', '$contraseña', '$tiempo')";
        if (mysqli_query($conn, $sql)) {
            $success = "Registro exitoso.";
        } else {
            $error = "Error al registrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <div class="login">
        <h1>Registrarse</h1>

        <!-- Muestra mensaje de error si existe -->
        <?php if (!empty($error)): ?>
            <p style="color: #fff; background-color: #800000; padding: 10px; border-radius: 8px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Muestra mensaje de éxito si existe -->
        <?php if (!empty($success)): ?>
            <p style="color: #fff; background-color: #004d00; padding: 10px; border-radius: 8px;"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form method="POST" action="register.php">
            <div class="Usuario">
                <input type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="Usuario">
                <input type="password" name="contraseña" placeholder="Contraseña" required>
            </div>
            <div class="Usuario">
                <input type="text" name="tiempo" placeholder="Cuanto tiempo llevas ?" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>

        <p style="color: #ddd; margin-top: 15px;">¿Ya tienes cuenta?
            <a href="login.php" style="color: #FFFFFF;">Inicia sesión</a></p>
    </div>
</div>

</body>
</html>