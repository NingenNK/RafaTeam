<?php
require_once 'db.php'; // Conexión a la base de datos

// Eliminar alumno
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_id'])) {
    $id = $_POST['eliminar_id'];
    $sql = "DELETE FROM alumnos WHERE id = $id";
    $conn->query($sql);
    header("Location: read.php");
    exit();
}

// Editar alumno
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_edicion'])) {
    $id = $_POST['editar_id'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_tiempo = $_POST['nuevo_tiempo'];

    $sql = "UPDATE alumnos SET nombre = '$nuevo_nombre', tiempo = '$nuevo_tiempo' WHERE id = $id";
    $conn->query($sql);
    header("Location: read.php");
    exit();
}

// Mostrar formulario de edición
$editar_id = isset($_POST['mostrar_editar']) ? $_POST['mostrar_editar'] : null;

// Obtener todos los alumnos
$sql = "SELECT id, nombre, tiempo FROM alumnos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alumnos</title>
    <link rel="stylesheet" href="read.css">
    <script>
        function confirmar(nombre) {
            return confirm("¿Seguro que querés eliminar a " + nombre + "?");
        }

        function ocultarFormulario() {
            const form = document.getElementById("formularioeditar");
            if (form) {
                form.style.display = "none";
            }
        }
    </script>
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

<h1 style="text-align: center;">Listado de Alumnos</h1>

<!-- Tabla de alumnos -->
<table>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Tiempo</th>
    <th>Acciones</th>
</tr>

<?php if ($resultado->num_rows > 0): ?>
    <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['tiempo'] ?></td>
            <td>
                <!-- Botón Editar -->
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="mostrar_editar" value="<?= $row['id'] ?>">
                    <button type="submit">Editar</button>
                </form>

                <!-- Botón Eliminar -->
                <form method="post" onsubmit="return confirmar('<?= $row['nombre'] ?>')" style="display:inline-block;">
                    <input type="hidden" name="eliminar_id" value="<?= $row['id'] ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="4">No hay alumnos registrados.</td></tr>
<?php endif; ?>
</table>

<!-- Formulario de edición -->
<?php if ($editar_id): ?>
    <?php
    $sql = "SELECT nombre, tiempo FROM alumnos WHERE id = $editar_id";
    $resultado_editar = $conn->query($sql);
    $fila = $resultado_editar->fetch_assoc();
    ?>
    <div style="text-align: center;" id="formularioeditar">
        <h2>Editar Alumno</h2>
        <form method="post"><br>
            <input type="hidden" name="editar_id" value="<?= $editar_id ?>">
            
            <label for="nuevo_nombre">Nombre:</label>
            <input type="text" name="nuevo_nombre" value="<?= $fila['nombre'] ?>" required>
            
            <label for="nuevo_tiempo">Tiempo:</label>
            <input type="text" name="nuevo_tiempo" value="<?= $fila['tiempo'] ?>" required>

            <div style="text-align: center;"><br>
                <button type="submit" name="guardar_edicion">Guardar</button>
                <button type="button" onclick="ocultarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
<?php endif; ?>

<footer>
    <h1>RafaTeam</h1>
    <p>© 2025 RafaTeam. Todos los derechos reservados.</p>    
</footer>

</body>
</html>