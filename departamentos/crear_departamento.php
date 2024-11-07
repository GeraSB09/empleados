<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitizar y validar entrada
        $nombre_departamento = trim(strtoupper($_POST['nombre_departamento']));
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $hora = date('H:i:s');
        $fecha_creacion = date('Y-m-d');

        // Validaciones
        if (empty($nombre_departamento)) {
            throw new Exception("El nombre del departamento es obligatorio");
        }

        if (strlen($nombre_departamento) < 3 || strlen($nombre_departamento) > 50) {
            throw new Exception("El nombre debe tener entre 3 y 50 caracteres");
        }

        if (!preg_match("/^[A-ZÁÉÍÓÚÑ\s]+$/u", $nombre_departamento)) {
            throw new Exception("El nombre solo puede contener letras y espacios");
        }

        // Verificar si ya existe un departamento con el mismo nombre
        $stmt = $conn->prepare("SELECT pk_departamento FROM departamento WHERE UPPER(nombre_departamento) = ?");
        $stmt->bind_param("s", $nombre_departamento);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("Ya existe un departamento con este nombre");
        }
        $stmt->close();

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("INSERT INTO departamento (nombre_departamento, estado, hora, fecha_creacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $nombre_departamento, $estado, $hora, $fecha_creacion);

        if ($stmt->execute()) {
            // Registro exitoso
            echo json_encode([
                'status' => 'success',
                'message' => 'Departamento registrado correctamente',
                'redirect' => 'datos_departamentos.php'
            ]);
        } else {
            throw new Exception("Error al registrar el departamento: " . $stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        // Manejo de errores
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }

    $conn->close();
    exit();
}

// Si se accede directamente al archivo sin POST, redirigir
header("Location: formulario_departamentos.php");
exit();
?> 