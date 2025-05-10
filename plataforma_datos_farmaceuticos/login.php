<?php
// login.php
session_start();
include 'includes/db.php';  // Conexión a la base de datos

// Verificar si el usuario ya está logueado
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consultar en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = MD5(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, iniciar sesión
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $row['usuario'];  // Guardar usuario en sesión
        header('Location: index.php');  // Redirigir a index.php
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Agregar estilos específicos solo para esta página sin afectar el archivo style.css */
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: #003366;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="text"], input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        input[type="submit"] {
            padding: 12px;
            background-color: #0066cc;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005bb5;
        }

        p {
            color: red;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>

        <!-- Mostrar error si las credenciales son incorrectas -->
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" placeholder="Ingrese su usuario" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" placeholder="Ingrese su contraseña" required><br>

            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
</body>
</html>
