<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "empleado";

try {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        error_log("Error de conexión: " . $conn->connect_error);
        die("Error de conexión: " . $conn->connect_error);
    }

    error_log("Conexión exitosa a la base de datos");
} catch (Exception $e) {
    error_log("Error al conectar: " . $e->getMessage());
    die("Error al conectar: " . $e->getMessage());
}
