<?php
include 'includes/db.php';

// Variables para mantener los valores del formulario
$nombre_comercial = '';
$nombre_generico = '';
$principio_activo = '';
$dosis = '';
$presentacion = '';

// Variable para controlar si es un modo de edición
$is_edit = false;

// Agregar nuevo medicamento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_medicamento'])) {
    $nombre_comercial = $_POST['nombre_comercial'];
    $nombre_generico = $_POST['nombre_generico'];
    $principio_activo = $_POST['principio_activo'];
    $dosis = $_POST['dosis'];
    $presentacion = $_POST['presentacion'];

    $sql = "INSERT INTO medicamentos (nombre_comercial, nombre_generico, principio_activo, dosis, presentacion)
            VALUES ('$nombre_comercial', '$nombre_generico', '$principio_activo', '$dosis', '$presentacion')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Nuevo medicamento agregado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Eliminar medicamento
if (isset($_GET['delete'])) {
    $id_medicamento = $_GET['delete'];

    $sql = "DELETE FROM medicamentos WHERE id = $id_medicamento";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Medicamento eliminado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Editar medicamento
if (isset($_GET['edit'])) {
    $id_medicamento = $_GET['edit'];
    $sql = "SELECT * FROM medicamentos WHERE id = $id_medicamento";
    $result = $conn->query($sql);
    $medicamento = $result->fetch_assoc();

    // Rellenar los campos del formulario con los valores actuales del medicamento
    $nombre_comercial = $medicamento['nombre_comercial'];
    $nombre_generico = $medicamento['nombre_generico'];
    $principio_activo = $medicamento['principio_activo'];
    $dosis = $medicamento['dosis'];
    $presentacion = $medicamento['presentacion'];

    // Establecer la variable de edición en true
    $is_edit = true;
}

// Actualizar medicamento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_medicamento'])) {
    $id_medicamento = $_POST['id_medicamento'];
    $nombre_comercial = $_POST['nombre_comercial'];
    $nombre_generico = $_POST['nombre_generico'];
    $principio_activo = $_POST['principio_activo'];
    $dosis = $_POST['dosis'];
    $presentacion = $_POST['presentacion'];

    $sql = "UPDATE medicamentos SET nombre_comercial='$nombre_comercial', nombre_generico='$nombre_generico', principio_activo='$principio_activo', dosis='$dosis', presentacion='$presentacion' WHERE id = $id_medicamento";

    if ($conn->query($sql) === TRUE) {
        // Vaciar los campos después de guardar los cambios
        $nombre_comercial = '';
        $nombre_generico = '';
        $principio_activo = '';
        $dosis = '';
        $presentacion = '';
        echo "<p style='color: green;'>Medicamento actualizado exitosamente.</p>";

        // Redirigir a la misma página para reiniciar los campos y el formulario
        header("Location: medicamentos.php");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener los medicamentos
$sql = "SELECT * FROM medicamentos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Medicamento</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form method="POST">
                <label for="nombre_comercial">Nombre Comercial:</label>
                <input type="text" name="nombre_comercial" value="<?php echo $nombre_comercial; ?>" required><br>

                <label for="nombre_generico">Nombre Genérico:</label>
                <input type="text" name="nombre_generico" value="<?php echo $nombre_generico; ?>" required><br>

                <label for="principio_activo">Principio Activo:</label>
                <input type="text" name="principio_activo" value="<?php echo $principio_activo; ?>" required><br>

                <label for="dosis">Dosis:</label>
                <input type="text" name="dosis" value="<?php echo $dosis; ?>"><br>

                <label for="presentacion">Presentación:</label>
                <input type="text" name="presentacion" value="<?php echo $presentacion; ?>"><br>

                <?php if ($is_edit): ?>
                    <input type="hidden" name="id_medicamento" value="<?php echo $medicamento['id']; ?>">
                    <input type="submit" name="update_medicamento" value="Guardar Cambios">
                <?php else: ?>
                    <input type="submit" name="add_medicamento" value="Agregar Medicamento">
                <?php endif; ?>
            </form>

            <h2>Medicamentos Registrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre Comercial</th>
                    <th>Nombre Genérico</th>
                    <th>Principio Activo</th>
                    <th>Dosis</th>
                    <th>Presentación</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre_comercial']; ?></td>
                        <td><?php echo $row['nombre_generico']; ?></td>
                        <td><?php echo $row['principio_activo']; ?></td>
                        <td><?php echo $row['dosis']; ?></td>
                        <td><?php echo $row['presentacion']; ?></td>
                        <td>
                            <a href="medicamentos.php?edit=<?php echo $row['id']; ?>" class="btn">Editar</a>
                            <a href="medicamentos.php?delete=<?php echo $row['id']; ?>" class="btn">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- Botón Volver a la página principal -->
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
