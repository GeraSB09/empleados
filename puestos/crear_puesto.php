<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitizar y validar entrada
        $nombre_puesto = trim(strtoupper($_POST['nombre_puesto']));
        $salario = filter_var($_POST['salario'], FILTER_VALIDATE_FLOAT);
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $fk_departamento = intval($_POST['fk_departamento']);
        $hora = date('H:i:s');
        $fecha_creacion = date('Y-m-d');

        // Validaciones
        if (empty($nombre_puesto)) {
            throw new Exception("El nombre del puesto es obligatorio");
        }

        if (strlen($nombre_puesto) < 3 || strlen($nombre_puesto) > 50) {
            throw new Exception("El nombre debe tener entre 3 y 50 caracteres");
        }

        if (!preg_match("/^[A-ZÁÉÍÓÚÑ\s]+$/u", $nombre_puesto)) {
            throw new Exception("El nombre solo puede contener letras y espacios");
        }

        if ($salario === false || $salario <= 0) {
            throw new Exception("El salario debe ser un número válido mayor a 0");
        }

        if ($fk_departamento <= 0) {
            throw new Exception("Debe seleccionar un departamento válido");
        }

        // Verificar si existe el departamento y está activo
        $stmt = $conn->prepare("SELECT pk_departamento FROM departamento WHERE pk_departamento = ? AND estado = 1");
        $stmt->bind_param("i", $fk_departamento);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            throw new Exception("El departamento seleccionado no existe o está inactivo");
        }
        $stmt->close();

        // Verificar si ya existe un puesto con el mismo nombre en el mismo departamento
        $stmt = $conn->prepare("SELECT pk_puesto FROM puesto WHERE UPPER(nombre_puesto) = ? AND fk_departamento = ?");
        $stmt->bind_param("si", $nombre_puesto, $fk_departamento);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Ya existe un puesto con este nombre en el departamento seleccionado");
        }
        $stmt->close();

        // Preparar y ejecutar la consulta de inserción
        $stmt = $conn->prepare("INSERT INTO puesto (nombre_puesto, salario, estado, hora, fecha_creacion, fk_departamento) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdissi", $nombre_puesto, $salario, $estado, $hora, $fecha_creacion, $fk_departamento);

        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Puesto registrado correctamente',
                'redirect' => 'datos_puestos.php'
            ];
        } else {
            throw new Exception("Error al registrar el puesto: " . $stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    // Enviar respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $conn->close();
    exit();
}

// Si se accede directamente al archivo sin POST, redirigir
header("Location: formulario_puestos.php");
exit();
?> 