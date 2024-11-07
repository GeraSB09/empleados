<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

header('Content-Type: application/json');

if (isset($_GET['numero'])) {
    $numero = $_GET['numero'];
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM empleados WHERE numero_empleado = ?");
    $stmt->bind_param("i", $numero);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode([
        'disponible' => $row['count'] == 0
    ]);
    
    $stmt->close();
} else {
    echo json_encode([
        'disponible' => false,
        'error' => 'No se proporcionó número de empleado'
    ]);
}

$conn->close();
?> 