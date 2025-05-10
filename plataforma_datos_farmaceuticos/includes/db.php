<?php
// db.php
$host = 'localhost';
$user = 'root'; 
$password = '';
$dbname = 'farmaceutica_db';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
