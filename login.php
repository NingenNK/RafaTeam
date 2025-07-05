<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Consulta para obtener usuario y contraseña
    $sql = "SELECT id, contraseña FROM alumnos WHERE nombre = '$nombre'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);

        // Comparar contraseña simple
        if ($fila['contraseña'] === $contraseña) {
            $_SESSION['id'] = $fila['id'];
            $_SESSION['nombre'] = $nombre;

            // Si el usuario es "Rafa", redirige a admin_page.php
            if ($nombre === 'Rafa') {
                header("Location: read.php");
                exit();
            } else {
                // Para cualquier otro usuario, ir a perfil.php
                header("Location: perfil.php");
                exit();
            }
        }
    }

    $error = "Usuario o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login">
            <h1>Login</h1>

            <?php if (!empty($error)): ?>
                <p class="error" style="color: #fff; background-color: #800000; padding: 10px; border-radius: 8px;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="Usuario">
                    <input type="text" name="nombre" placeholder="nombre" required>
                </div>
                <div class="Usuario">
                    <input type="password" name="contraseña" placeholder="contraseña" required>
                </div>
                <button type="submit">Login</button>
            </form>

            <p style="color: #ddd; margin-top: 15px;">
                ¿No tienes cuenta? <a href="register.php" style="color: #fff;">Registrarse</a>
            </p>
        </div>
    </div>
</body>
</html>