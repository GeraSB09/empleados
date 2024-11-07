<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

ob_start();

try {
    require_once __DIR__ . '/../config/config.php';
    include path('@conexion');

    ob_clean();

    if (!isset($_POST['pk_empleado'])) {
        throw new Exception('ID de empleado no proporcionado');
    }

    // Verificar campos requeridos
    $camposRequeridos = [
        'numero_empleado',
        'nombres',
        'primer_apellido',
        'edad',
        'sexo',
        'fecha_nacimiento',
        'estado',
        'fk_puesto',
        'fk_carrera'
    ];

    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo $campo es requerido");
        }
    }

    // Preparar valores
    $segundo_apellido = empty($_POST['segundo_apellido']) ? null : $_POST['segundo_apellido'];
    $telefono = empty($_POST['telefono']) ? null : $_POST['telefono'];
    $rfc = empty($_POST['rfc']) ? null : strtoupper($_POST['rfc']);
    $curp = empty($_POST['curp']) ? null : strtoupper($_POST['curp']);
    $nss = empty($_POST['nss']) ? null : $_POST['nss'];
    $email = empty($_POST['email']) ? null : $_POST['email'];
    $turno = empty($_POST['turno']) ? null : $_POST['turno'];
    $fecha_modificacion = date('Y-m-d');
    $hora_actual = date('H:i');

    $sql = "UPDATE empleados SET 
            numero_empleado = ?, 
            nombres = ?,
            primer_apellido = ?,
            segundo_apellido = ?,
            edad = ?,
            sexo = ?,
            fecha_nacimiento = ?,
            telefono = ?,
            rfc = ?,
            curp = ?,
            nss = ?,
            email = ?,
            turno = ?,
            estado = ?,
            hora = ?,
            fecha_modificacion = ?,
            fk_puesto = ?,
            fk_carrera = ?
            WHERE pk_empleado = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssississsssssssii",
        $_POST['numero_empleado'],
        $_POST['nombres'],
        $_POST['primer_apellido'],
        $segundo_apellido,
        $_POST['edad'],
        $_POST['sexo'],
        $_POST['fecha_nacimiento'],
        $telefono,
        $rfc,
        $curp,
        $nss,
        $email,
        $turno,
        $_POST['estado'],
        $hora_actual,
        $fecha_modificacion,
        $_POST['fk_puesto'],
        $_POST['fk_carrera'],
        $_POST['pk_empleado']
    );

    if ($stmt->execute()) {
        // Procesar la fotografía si se proporcionó una nueva
        if (isset($_FILES['fotografia']) && $_FILES['fotografia']['size'] > 0) {
            try {
                $extension = pathinfo($_FILES['fotografia']['name'], PATHINFO_EXTENSION);
                $nombreArchivo = $_POST['numero_empleado'] . '_' . time() . '.' . $extension;
                $rutaDestino = 'fotos/' . $nombreArchivo;

                if (!file_exists('fotos')) {
                    mkdir('fotos', 0777, true);
                }

                if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $rutaDestino)) {
                    $stmt = $conn->prepare("UPDATE empleados SET fotografia = ? WHERE numero_empleado = ?");
                    $stmt->bind_param("si", $rutaDestino, $_POST['numero_empleado']);
                    $stmt->execute();
                }
            } catch (Exception $e) {
                error_log("Error procesando la fotografía: " . $e->getMessage());
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Empleado actualizado correctamente'
        ]);
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

ob_end_flush();
$conn->close();
