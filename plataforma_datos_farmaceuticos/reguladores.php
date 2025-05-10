<?php
include 'includes/db.php';

// Variables para mantener los valores del formulario
$entidad = '';
$informe_fecha = '';
$descripcion = '';

// Variable para controlar si es un modo de edición
$is_edit = false;
$id_regulador = '';

// Agregar nuevo regulador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_regulador'])) {
    $entidad = $_POST['entidad'];
    $informe_fecha = $_POST['informe_fecha'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO reguladores (entidad, informe_fecha, descripcion)
            VALUES ('$entidad', '$informe_fecha', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Nuevo regulador agregado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Eliminar regulador
if (isset($_GET['delete'])) {
    $id_regulador = $_GET['delete'];

    $sql = "DELETE FROM reguladores WHERE id = $id_regulador";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Regulador eliminado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Editar regulador
if (isset($_GET['edit'])) {
    $id_regulador = $_GET['edit'];
    $sql = "SELECT * FROM reguladores WHERE id = $id_regulador";
    $result = $conn->query($sql);
    $regulador = $result->fetch_assoc();

    // Rellenar los campos del formulario con los valores actuales del regulador
    $entidad = $regulador['entidad'];
    $informe_fecha = $regulador['informe_fecha'];
    $descripcion = $regulador['descripcion'];

    // Establecer la variable de edición en true
    $is_edit = true;
}

// Actualizar regulador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_regulador'])) {
    $id_regulador = $_POST['id_regulador'];
    $entidad = $_POST['entidad'];
    $informe_fecha = $_POST['informe_fecha'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE reguladores SET entidad='$entidad', informe_fecha='$informe_fecha', descripcion='$descripcion' WHERE id = $id_regulador";

    if ($conn->query($sql) === TRUE) {
        // Vaciar los campos después de guardar los cambios
        $entidad = '';
        $informe_fecha = '';
        $descripcion = '';
        echo "<p style='color: green;'>Regulador actualizado exitosamente.</p>";

        // Redirigir a la misma página para reiniciar los campos y el formulario
        header("Location: reguladores.php");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener los reguladores
$sql = "SELECT * FROM reguladores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reguladores</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Regulador</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form method="POST">
                <label for="entidad">Entidad Reguladora:</label>
                <input type="text" name="entidad" value="<?php echo $entidad; ?>" required><br>

                <label for="informe_fecha">Fecha del Informe:</label>
                <input type="date" name="informe_fecha" value="<?php echo $informe_fecha; ?>" required><br>

                <label for="descripcion">Descripción del Informe:</label>
                <textarea name="descripcion" required><?php echo $descripcion; ?></textarea><br>

                <?php if ($is_edit): ?>
                    <input type="hidden" name="id_regulador" value="<?php echo $regulador['id']; ?>">
                    <input type="submit" name="update_regulador" value="Guardar Cambios">
                <?php else: ?>
                    <input type="submit" name="add_regulador" value="Agregar Regulador">
                <?php endif; ?>
            </form>

            <h2>Reguladores Registrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Entidad Reguladora</th>
                    <th>Fecha del Informe</th>
                    <th>Descripción del Informe</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['entidad']; ?></td>
                        <td><?php echo $row['informe_fecha']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>
                            <a href="reguladores.php?edit=<?php echo $row['id']; ?>" class="btn">Editar</a>
                            <a href="reguladores.php?delete=<?php echo $row['id']; ?>" class="btn">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <a href="index.php" class="btn">Volver a Inicio</a>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Plataforma Farmacéutica</p>
        </div>
    </footer>
</body>
</html>
