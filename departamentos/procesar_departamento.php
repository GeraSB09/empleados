<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener y sanitizar datos
        $pk_departamento = isset($_POST['pk_departamento']) ? intval($_POST['pk_departamento']) : 0;
        $nombre_departamento = trim(strtoupper($_POST['nombre_departamento']));
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $fecha_modificacion = date('Y-m-d');

        // Validaciones
        if ($pk_departamento <= 0) {
            throw new Exception("ID de departamento inválido");
        }

        if (empty($nombre_departamento)) {
            throw new Exception("El nombre del departamento es obligatorio");
        }

        if (strlen($nombre_departamento) < 3 || strlen($nombre_departamento) > 50) {
            throw new Exception("El nombre debe tener entre 3 y 50 caracteres");
        }

        if (!preg_match("/^[A-ZÁÉÍÓÚÑ\s]+$/u", $nombre_departamento)) {
            throw new Exception("El nombre solo puede contener letras y espacios");
        }

        // Verificar si existe otro departamento con el mismo nombre (excluyendo el actual)
        $stmt = $conn->prepare("SELECT pk_departamento FROM departamento 
                               WHERE UPPER(nombre_departamento) = ? 
                               AND pk_departamento != ?");
        $stmt->bind_param("si", $nombre_departamento, $pk_departamento);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Ya existe otro departamento con este nombre");
        }
        $stmt->close();

        // Verificar si el departamento existe
        $stmt = $conn->prepare("SELECT pk_departamento FROM departamento WHERE pk_departamento = ?");
        $stmt->bind_param("i", $pk_departamento);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            throw new Exception("El departamento no existe");
        }
        $stmt->close();

        // Preparar y ejecutar la actualización
        $stmt = $conn->prepare("UPDATE departamento 
                               SET nombre_departamento = ?, 
                                   estado = ?, 
                                   fecha_modificacion = ? 
                               WHERE pk_departamento = ?");
        
        $stmt->bind_param("sisi", 
            $nombre_departamento, 
            $estado, 
            $fecha_modificacion, 
            $pk_departamento
        );

        if ($stmt->execute()) {
            // Verificar si se actualizó algún registro
            if ($stmt->affected_rows > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Departamento actualizado correctamente',
                    'redirect' => 'datos_departamentos.php'
                ];
            } else {
                throw new Exception("No se realizaron cambios en el departamento");
            }
        } else {
            throw new Exception("Error al actualizar el departamento: " . $stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    // Si es una petición AJAX, devolver JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Si no es AJAX, redirigir con mensaje
    if ($response['status'] === 'success') {
        header("Location: datos_departamentos.php?success=" . urlencode($response['message']));
    } else {
        header("Location: editar_departamento.php?id=" . $pk_departamento . "&error=" . urlencode($response['message']));
    }
    exit;
}

// Si se accede directamente al archivo sin POST, redirigir
header("Location: datos_departamentos.php");
exit;
?> 