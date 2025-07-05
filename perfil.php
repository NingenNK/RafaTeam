<?php

session_start();
require_once 'db.php'; // Conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['id']) || !isset($_SESSION['nombre'])) { /* El isset significa que no esta definido o es null, es decir: si id o nombre no esta definido o no existe, noesta logueado */
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];

// Obtener datos del usuario desde la base de datos
$sql = "SELECT id, nombre, tiempo FROM alumnos WHERE id = $usuario_id";
$resultado = $conn->query($sql);
$alumno = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="read.css">
</head>
<body>

<header>
    <div class="logo"><img src="FOTOS/logoRT.png" alt="Logo"></div>
    <nav>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="BJJ-CLASES.html">Clases</a></li>
            <li><a href="BJJ-HORARIOS.html">Horarios</a></li>
            <li><a href="BJJ-CONTACT.html">Contactos</a></li>
        </ul>
    </nav>
</header><br>

<h1 style="text-align: center;">Bienvenido <?php echo $nombre; ?></h1><br>
<h1 style="text-align: center;">Tu Información</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tiempo</th>
    </tr>
    <tr>
        <td><?= $alumno['id'] ?></td>
        <td><?= $alumno['nombre'] ?></td>
        <td><?= $alumno['tiempo'] ?></td>
    </tr>
</table>

<div class="cerrar">
<h1><a href="logout.php">Cerrar Sesion</a></h1>
</div>

<br>

<footer>
    <h1>RafaTeam</h1>
    <p>© 2025 RafaTeam. Todos los derechos reservados.</p>    
</footer>

</body>
</html>