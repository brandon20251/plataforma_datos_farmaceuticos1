<?php
include 'includes/db.php';

// Obtener los datos para medicamentos
$sql_medicamentos = "SELECT nombre_comercial, COUNT(id) AS cantidad FROM medicamentos GROUP BY nombre_comercial";
$result_medicamentos = $conn->query($sql_medicamentos);

$labels_medicamentos = [];
$data_medicamentos = [];
while ($row = $result_medicamentos->fetch_assoc()) {
    $labels_medicamentos[] = $row['nombre_comercial'];
    $data_medicamentos[] = $row['cantidad'];
}

// Obtener los datos para proveedores
$sql_proveedores = "SELECT nombre_proveedor, COUNT(id) AS cantidad FROM proveedores GROUP BY nombre_proveedor";
$result_proveedores = $conn->query($sql_proveedores);

$labels_proveedores = [];
$data_proveedores = [];
while ($row = $result_proveedores->fetch_assoc()) {
    $labels_proveedores[] = $row['nombre_proveedor'];
    $data_proveedores[] = $row['cantidad'];
}

// Obtener los datos para distribuciones
$sql_distribuciones = "SELECT id_medicamento, COUNT(id) AS cantidad FROM distribucion GROUP BY id_medicamento";
$result_distribuciones = $conn->query($sql_distribuciones);

$labels_distribuciones = [];
$data_distribuciones = [];
while ($row = $result_distribuciones->fetch_assoc()) {
    $labels_distribuciones[] = $row['id_medicamento'];
    $data_distribuciones[] = $row['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes - Gráficos y Datos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Informes y Gráficos</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <!-- Gráfico de Medicamentos Registrados -->
            <h2>Gráfico de Medicamentos Registrados</h2>
            <canvas id="medicamentosChart" width="400" height="200"></canvas>
            <script>
                var ctx = document.getElementById('medicamentosChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels_medicamentos); ?>,
                        datasets: [{
                            label: 'Cantidad de Medicamentos',
                            data: <?php echo json_encode($data_medicamentos); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <!-- Gráfico de Proveedores Registrados -->
            <h2>Gráfico de Proveedores Registrados</h2>
            <canvas id="proveedoresChart" width="400" height="200"></canvas>
            <script>
                var ctx = document.getElementById('proveedoresChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels_proveedores); ?>,
                        datasets: [{
                            label: 'Cantidad de Proveedores',
                            data: <?php echo json_encode($data_proveedores); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <!-- Gráfico de Distribuciones Registradas -->
            <h2>Gráfico de Distribuciones Registradas</h2>
            <canvas id="distribucionesChart" width="400" height="200"></canvas>
            <script>
                var ctx = document.getElementById('distribucionesChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels_distribuciones); ?>,
                        datasets: [{
                            label: 'Cantidad de Distribuciones',
                            data: <?php echo json_encode($data_distribuciones); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <a href="index.php" class="btn">Volver al Inicio</a>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Plataforma Farmacéutica</p>
        </div>
    </footer>
</body>
</html>
