<?php
include 'includes/db.php';

// Variables para mantener los valores del formulario
$nombre_proveedor = '';
$direccion = '';
$telefono = '';
$correo = '';

// Variable para controlar si es un modo de edición
$is_edit = false;
$id_proveedor = 0;

// Agregar nuevo proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_proveedor'])) {
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // SQL para insertar el nuevo proveedor en la base de datos
    $sql = "INSERT INTO proveedores (nombre_proveedor, direccion, telefono, correo)
            VALUES ('$nombre_proveedor', '$direccion', '$telefono', '$correo')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Proveedor agregado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Editar proveedor
if (isset($_GET['edit'])) {
    $id_proveedor = $_GET['edit'];
    $sql = "SELECT * FROM proveedores WHERE id = $id_proveedor";
    $result = $conn->query($sql);
    $proveedor = $result->fetch_assoc();

    // Rellenar los campos del formulario con los valores actuales del proveedor
    $nombre_proveedor = $proveedor['nombre_proveedor'];
    $direccion = $proveedor['direccion'];
    $telefono = $proveedor['telefono'];
    $correo = $proveedor['correo'];

    // Establecer la variable de edición en true
    $is_edit = true;
}

// Guardar cambios al editar proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_proveedor'])) {
    $id_proveedor = $_POST['id_proveedor'];
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // SQL para actualizar los datos del proveedor
    $sql = "UPDATE proveedores SET nombre_proveedor='$nombre_proveedor', direccion='$direccion', telefono='$telefono', correo='$correo' WHERE id = $id_proveedor";

    if ($conn->query($sql) === TRUE) {
        // Vaciar los campos después de guardar los cambios
        $nombre_proveedor = '';
        $direccion = '';
        $telefono = '';
        $correo = '';
        echo "<p style='color: green;'>Proveedor actualizado exitosamente.</p>";

        // Redirigir a la misma página para reiniciar los campos y el formulario
        header("Location: proveedores.php");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Eliminar proveedor con dependencias
if (isset($_GET['delete'])) {
    $id_proveedor = $_GET['delete'];

    // Primero, eliminar los registros relacionados en la tabla de distribucion
    $sql_delete_distribucion = "DELETE FROM distribucion WHERE id_proveedor = $id_proveedor";
    $conn->query($sql_delete_distribucion);  // Ejecutar la eliminación en distribucion

    // Ahora eliminar el proveedor
    $sql_delete_proveedor = "DELETE FROM proveedores WHERE id = $id_proveedor";
    if ($conn->query($sql_delete_proveedor) === TRUE) {
        echo "<p style='color: green;'>Proveedor y sus distribuciones eliminados exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error al eliminar proveedor: " . $conn->error . "</p>";
    }
}

// Obtener los proveedores
$sql = "SELECT * FROM proveedores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Proveedor</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form method="POST">
                <label for="nombre_proveedor">Nombre del Proveedor:</label>
                <input type="text" name="nombre_proveedor" value="<?php echo $nombre_proveedor; ?>" required><br>

                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" value="<?php echo $direccion; ?>" required><br>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $telefono; ?>" required><br>

                <label for="correo">Correo Electrónico:</label>
                <input type="email" name="correo" value="<?php echo $correo; ?>" required><br>

                <?php if ($is_edit): ?>
                    <input type="hidden" name="id_proveedor" value="<?php echo $id_proveedor; ?>">
                    <input type="submit" name="update_proveedor" value="Guardar Cambios">
                <?php else: ?>
                    <input type="submit" name="add_proveedor" value="Agregar Proveedor">
                <?php endif; ?>
            </form>

            <h2>Proveedores Registrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Proveedor</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre_proveedor']; ?></td>
                        <td><?php echo $row['direccion']; ?></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo $row['correo']; ?></td>
                        <td>
                            <a href="proveedores.php?edit=<?php echo $row['id']; ?>" class="btn">Editar</a>
                            <a href="proveedores.php?delete=<?php echo $row['id']; ?>" class="btn">Eliminar</a>
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

