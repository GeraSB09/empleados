<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se recibieron los parámetros necesarios
if (!isset($_GET['id']) || !isset($_GET['estado'])) {
    header("Location: " . path('@empleados/datos_empleados.php?error=Parámetros incompletos'));
    exit;
}

// Obtener y sanitizar los parámetros
$id = intval($_GET['id']);
$estado = intval($_GET['estado']);

// Validar que el estado sea 0 o 1
if ($estado !== 0 && $estado !== 1) {
    header("Location: " . path('@empleados/datos_empleados.php?error=Estado inválido'));
    exit;
}

try {
    // Preparar la consulta SQL
    $sql = "UPDATE empleados SET 
            estado = ?, 
            fecha_modificacion = NOW() 
            WHERE pk_empleado = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $estado, $id);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        $titulo = $estado == 1 ? 'Activos' : 'Inactivos';
        header("Location: " . path('@empleados/datos_empleados.php?estado=' . $estado . '&titulo=Empleados ' . $titulo));
    } else {
        header("Location: " . path('@empleados/datos_empleados.php?estado=' . $estado . '&error=Error al actualizar el estado'));
    }

} catch (Exception $e) {
    header("Location: " . path('@empleados/datos_empleados.php?estado=' . $estado . '&error=Error: ' . $e->getMessage()));
} finally {
    $stmt->close();
    $conn->close();
}
?> 