<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Iniciar el buffer de salida
ob_start();

try {
    require_once __DIR__ . '/../config/config.php';
    include path('@conexion');

    // Limpiar cualquier output previo
    ob_clean();

    // Verificar que los campos requeridos estén presentes
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

    // Manejo de la fotografía
    $fotografia = null;
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['size'] > 0) {
        $fotografia = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    // Preparar valores con manejo de nulos
    $segundo_apellido = empty($_POST['segundo_apellido']) ? null : $_POST['segundo_apellido'];
    $telefono = empty($_POST['telefono']) ? null : $_POST['telefono'];
    $rfc = empty($_POST['rfc']) ? null : strtoupper($_POST['rfc']);
    $curp = empty($_POST['curp']) ? null : strtoupper($_POST['curp']);
    $nss = empty($_POST['nss']) ? null : $_POST['nss'];
    $email = empty($_POST['email']) ? null : $_POST['email'];
    $turno = empty($_POST['turno']) ? null : $_POST['turno'];
    $fecha_modificacion = empty($_POST['fecha_modificacion']) ? null : $_POST['fecha_modificacion'];
    $hora_actual = date('H:i');

    // Preparar la consulta SQL
    $sql = "INSERT INTO empleados (
        numero_empleado, nombres, primer_apellido, segundo_apellido,
        edad, sexo, fecha_nacimiento, fotografia, telefono, 
        rfc, curp, nss, email, turno, 
        estado, hora, fecha_creacion, fecha_modificacion,
        fk_puesto, fk_carrera
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "isssissssssssssisii",
            $_POST['numero_empleado'],      // i - número empleado
            $_POST['nombres'],              // s - nombres
            $_POST['primer_apellido'],      // s - primer apellido
            $segundo_apellido,              // s - segundo apellido
            $_POST['edad'],                 // i - edad
            $_POST['sexo'],                 // s - sexo
            $_POST['fecha_nacimiento'],     // s - fecha nacimiento
            $fotografia,                    // s - fotografía
            $telefono,                      // s - teléfono
            $rfc,                           // s - rfc
            $curp,                          // s - curp
            $nss,                           // s - nss
            $email,                         // s - email
            $turno,                         // s - turno
            $_POST['estado'],               // s - estado
            $hora_actual,                   // s - hora
            $fecha_modificacion,            // s - fecha modificación
            $_POST['fk_puesto'],            // i - fk_puesto
            $_POST['fk_carrera']            // i - fk_carrera
        );

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Empleado registrado correctamente'
            ];

            // Procesar la fotografía si existe
            if (isset($_FILES['fotografia']) && $_FILES['fotografia']['size'] > 0) {
                try {
                    $extension = pathinfo($_FILES['fotografia']['name'], PATHINFO_EXTENSION);
                    $nombreArchivo = $_POST['numero_empleado'] . '_' . time() . '.' . $extension;
                    $rutaDestino = 'fotos/' . $nombreArchivo;

                    if (!file_exists('fotos')) {
                        mkdir('fotos', 0777, true);
                    }

                    if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $rutaDestino)) {
                        // Actualizar la ruta de la foto en la base de datos
                        $stmt = $conn->prepare("UPDATE empleados SET fotografia = ? WHERE numero_empleado = ?");
                        $stmt->bind_param("si", $rutaDestino, $_POST['numero_empleado']);
                        $stmt->execute();
                        $stmt->close();
                    }
                } catch (Exception $e) {
                    error_log("Error procesando la fotografía: " . $e->getMessage());
                    // No lanzar excepción aquí, solo registrar el error
                }
            }

            echo json_encode($response);
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Limpiar el buffer de salida y enviar el contenido
ob_end_flush();

$conn->close();
