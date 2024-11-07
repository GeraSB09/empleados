<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener y sanitizar datos
        $pk_puesto = isset($_POST['pk_puesto']) ? intval($_POST['pk_puesto']) : 0;
        $nombre_puesto = trim(strtoupper($_POST['nombre_puesto']));
        $salario = filter_var($_POST['salario'], FILTER_VALIDATE_FLOAT);
        $fk_departamento = intval($_POST['fk_departamento']);
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $fecha_modificacion = date('Y-m-d');

        // Validaciones básicas
        if ($pk_puesto <= 0) {
            throw new Exception("ID de puesto inválido");
        }

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
        $stmt = $conn->prepare("SELECT pk_departamento FROM departamento 
                               WHERE pk_departamento = ? AND estado = 1");
        $stmt->bind_param("i", $fk_departamento);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            throw new Exception("El departamento seleccionado no existe o está inactivo");
        }
        $stmt->close();

        // Verificar si ya existe otro puesto con el mismo nombre en el mismo departamento
        $stmt = $conn->prepare("SELECT pk_puesto FROM puesto 
                               WHERE UPPER(nombre_puesto) = ? 
                               AND fk_departamento = ? 
                               AND pk_puesto != ?");
        $stmt->bind_param("sii", $nombre_puesto, $fk_departamento, $pk_puesto);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Ya existe otro puesto con este nombre en el mismo departamento");
        }
        $stmt->close();

        // Verificar si el puesto existe
        $stmt = $conn->prepare("SELECT pk_puesto FROM puesto WHERE pk_puesto = ?");
        $stmt->bind_param("i", $pk_puesto);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            throw new Exception("El puesto no existe");
        }
        $stmt->close();

        // Preparar y ejecutar la actualización
        $stmt = $conn->prepare("UPDATE puesto 
                               SET nombre_puesto = ?, 
                                   salario = ?,
                                   fk_departamento = ?,
                                   estado = ?, 
                                   fecha_modificacion = ? 
                               WHERE pk_puesto = ?");

        $stmt->bind_param(
            "sdissi",
            $nombre_puesto,
            $salario,
            $fk_departamento,
            $estado,
            $fecha_modificacion,
            $pk_puesto
        );

        if ($stmt->execute()) {
            // Verificar si se actualizó algún registro
            if ($stmt->affected_rows > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Puesto actualizado correctamente',
                    'redirect' => 'datos_puestos.php'
                ];
            } else {
                throw new Exception("No se realizaron cambios en el puesto");
            }
        } else {
            throw new Exception("Error al actualizar el puesto: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    // Si es una petición AJAX, devolver JSON
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Si no es AJAX, redirigir con mensaje
    if ($response['status'] === 'success') {
        header("Location: datos_puestos.php?success=" . urlencode($response['message']));
    } else {
        header("Location: editar_puesto.php?id=" . $pk_puesto . "&error=" . urlencode($response['message']));
    }
    exit;
}

// Si se accede directamente al archivo sin POST, redirigir
header("Location: datos_puestos.php");
exit;
