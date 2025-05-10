<?php
include 'includes/db.php';

// Variables para mantener los valores del formulario
$id_medicamento = '';
$id_proveedor = '';
$cantidad = '';
$fecha_entrega = '';

// Variable para controlar si es un modo de edición
$is_edit = false;

// Agregar nuevo registro de distribución
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_distribucion'])) {
    $id_medicamento = $_POST['id_medicamento'];
    $id_proveedor = $_POST['id_proveedor'];
    $cantidad = $_POST['cantidad'];
    $fecha_entrega = $_POST['fecha_entrega'];

    // Verificar si el id_medicamento existe en la tabla medicamentos
    $sql_check_medicamento = "SELECT id FROM medicamentos WHERE id = $id_medicamento";
    $result_medicamento = $conn->query($sql_check_medicamento);
    if ($result_medicamento->num_rows == 0) {
        echo "<p style='color: red;'>Error: El medicamento no existe.</p>";
    } else {
        // Verificar si el id_proveedor existe en la tabla proveedores
        $sql_check_proveedor = "SELECT id FROM proveedores WHERE id = $id_proveedor";
        $result_proveedor = $conn->query($sql_check_proveedor);
        if ($result_proveedor->num_rows == 0) {
            echo "<p style='color: red;'>Error: El proveedor no existe.</p>";
        } else {
            // Insertar el nuevo registro de distribución
            $sql = "INSERT INTO distribucion (id_medicamento, id_proveedor, cantidad, fecha_entrega)
                    VALUES ('$id_medicamento', '$id_proveedor', '$cantidad', '$fecha_entrega')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='color: green;'>Nuevo registro de distribución agregado exitosamente.</p>";
            } else {
                echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }
    }
}

// Eliminar registro de distribución
if (isset($_GET['delete'])) {
    $id_distribucion = $_GET['delete'];

    $sql = "DELETE FROM distribucion WHERE id = $id_distribucion";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Registro de distribución eliminado exitosamente.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Editar registro de distribución
if (isset($_GET['edit'])) {
    $id_distribucion = $_GET['edit'];
    $sql = "SELECT * FROM distribucion WHERE id = $id_distribucion";
    $result = $conn->query($sql);
    $distribucion = $result->fetch_assoc();

    // Verificar si los campos existen antes de asignarlos
    $id_medicamento = isset($distribucion['id_medicamento']) ? $distribucion['id_medicamento'] : '';
    $id_proveedor = isset($distribucion['id_proveedor']) ? $distribucion['id_proveedor'] : '';
    $cantidad = isset($distribucion['cantidad']) ? $distribucion['cantidad'] : '';
    $fecha_entrega = isset($distribucion['fecha_entrega']) ? $distribucion['fecha_entrega'] : '';

    // Establecer la variable de edición en true
    $is_edit = true;
}

// Actualizar registro de distribución
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_distribucion'])) {
    $id_distribucion = $_POST['id_distribucion'];
    $id_medicamento = $_POST['id_medicamento'];
    $id_proveedor = $_POST['id_proveedor'];
    $cantidad = $_POST['cantidad'];
    $fecha_entrega = $_POST['fecha_entrega'];

    $sql = "UPDATE distribucion SET id_medicamento='$id_medicamento', id_proveedor='$id_proveedor', cantidad='$cantidad', fecha_entrega='$fecha_entrega' WHERE id = $id_distribucion";

    if ($conn->query($sql) === TRUE) {
        // Vaciar los campos después de guardar los cambios
        $id_medicamento = '';
        $id_proveedor = '';
        $cantidad = '';
        $fecha_entrega = '';
        echo "<p style='color: green;'>Registro de distribución actualizado exitosamente.</p>";

        // Redirigir a la misma página para reiniciar los campos y el formulario
        header("Location: distribucion.php");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener los registros de distribución
$sql = "SELECT * FROM distribucion";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Distribución</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form method="POST">
                <label for="id_medicamento">ID Medicamento:</label>
                <input type="number" name="id_medicamento" value="<?php echo $id_medicamento; ?>" required><br>

                <label for="id_proveedor">ID Proveedor:</label>
                <input type="number" name="id_proveedor" value="<?php echo $id_proveedor; ?>" required><br>

                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" required><br>

                <label for="fecha_entrega">Fecha de Entrega:</label>
                <input type="date" name="fecha_entrega" value="<?php echo $fecha_entrega; ?>" required><br>

                <?php if ($is_edit): ?>
                    <input type="hidden" name="id_distribucion" value="<?php echo $distribucion['id']; ?>">
                    <input type="submit" name="update_distribucion" value="Guardar Cambios">
                <?php else: ?>
                    <input type="submit" name="add_distribucion" value="Agregar Distribución">
                <?php endif; ?>
            </form>

            <h2>Distribuciones Registradas</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>ID Medicamento</th>
                    <th>ID Proveedor</th>
                    <th>Cantidad</th>
                    <th>Fecha de Entrega</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['id_medicamento']; ?></td>
                        <td><?php echo $row['id_proveedor']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td><?php echo $row['fecha_entrega']; ?></td>
                        <td>
                            <a href="distribucion.php?edit=<?php echo $row['id']; ?>" class="btn">Editar</a>
                            <a href="distribucion.php?delete=<?php echo $row['id']; ?>" class="btn">Eliminar</a>
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

