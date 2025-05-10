<?php
// Iniciar sesión
session_start();

// Cerrar sesión y redirigir a login.php
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php'); // Redirige a login.php
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Farmacéutica</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenido a la Plataforma para la Estandarización de Datos Farmacéuticos</h1>
        </div>
    </header>

    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="medicamentos.php">Medicamentos</a></li>
                <li><a href="proveedores.php">Proveedores</a></li>
                <li><a href="distribucion.php">Distribución</a></li>
                <li><a href="reguladores.php">Reguladores</a></li>
                <!-- Botón de Informes y Gráficos añadido al final de la barra -->
                <li><a href="informes.php" class="btn">Ver Informes y Gráficos</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="container">
            <h2>Contenido protegido para usuarios autenticados</h2>

            <!-- Botón para cerrar sesión -->
            <form method="POST">
                <input type="submit" name="logout" value="Cerrar sesión" class="btn">
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Plataforma Farmacéutica</p>
        </div>
    </footer>
</body>
</html>

