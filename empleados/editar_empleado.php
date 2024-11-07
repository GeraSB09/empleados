<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se recibió un ID
if (!isset($_GET['id'])) {
    header('Location: datos_empleados.php?error=No se especificó el ID del empleado');
    exit;
}

$id = $_GET['id'];

// Obtener los datos del empleado incluyendo la información de carrera y puesto
$sql = "SELECT e.*, p.nombre_puesto, c.nombre_carrera 
        FROM empleados e 
        LEFT JOIN puesto p ON e.fk_puesto = p.pk_puesto 
        LEFT JOIN carrera c ON e.fk_carrera = c.pk_carrera 
        WHERE e.pk_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header('Location: datos_empleados.php?error=Empleado no encontrado');
    exit;
}

$empleado = $resultado->fetch_assoc();

// Función auxiliar para manejar valores nulos
function h($value)
{
    if (!isset($value)) return '';
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar datos del Empleado</title>
    <link rel="stylesheet" href="<?php echo path('@global:css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo path('@custom:css'); ?>" type="text/css">
    <?php include path('@componentes');
    date_default_timezone_set('America/Mazatlan');
    ?>
</head>

<body class="bg-pattern">
    <?php include path('@nav'); ?>
    <div class="container-fluid mt-5 px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mb-5">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center font-weight-light my-2">Editar datos del Empleado: <?php echo htmlspecialchars($empleado['nombres'] . ' ' . $empleado['primer_apellido']); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="procesar_empleado.php" method="POST" enctype="multipart/form-data" id="formularioEmpleado">
                            <input type="hidden" name="pk_empleado" value="<?php echo h($empleado['pk_empleado']); ?>">

                            <!-- Información Básica -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Básica</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Fotografía -->
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-3" for="fotografia">Fotografía del Empleado</label>
                                            <div class="text-center mb-3">
                                                <?php if (!empty($empleado['fotografia'])): ?>
                                                    <img src="<?php echo h($empleado['fotografia']); ?>"
                                                        alt="Fotografía actual"
                                                        class="img-fluid rounded mb-2 rounded-circle"
                                                        style="max-height: 150px;">
                                                    <div class="text-center form-text">Ruta actual: <?php echo h($empleado['fotografia']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="file" class="form-control" id="fotografia" name="fotografia"
                                                accept="image/jpeg,image/png,image/webp">
                                            <div class="form-text">Formatos permitidos: JPG, PNG, WebP. Tamaño máximo: 5MB</div>

                                        </div>

                                        <!-- Datos básicos -->
                                        <div class="col-md-8" style="padding: 55px;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="small mb-3" for="numero_empleado">Número de Empleado*</label>
                                                    <input type="number" class="form-control" id="numero_empleado" name="numero_empleado"
                                                        value="<?php echo h($empleado['numero_empleado']); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="small mb-3" for="nombres">Nombres*</label>
                                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                                        value="<?php echo h($empleado['nombres']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 p-2">
                                                    <label class="small mb-1" for="primer_apellido">Primer Apellido*</label>
                                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido"
                                                        value="<?php echo h($empleado['primer_apellido']); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3 p-2">
                                                    <label class="small mb-1" for="segundo_apellido">Segundo Apellido</label>
                                                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                                                        value="<?php echo h($empleado['segundo_apellido']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Personal -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Personal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_nacimiento">Fecha de Nacimiento*</label>
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                                value="<?php echo isset($empleado['fecha_nacimiento']) ? date('Y-m-d', strtotime($empleado['fecha_nacimiento'])) : ''; ?>"
                                                required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="edad">Edad</label>
                                            <input type="number" class="form-control" id="edad" name="edad"
                                                value="<?php echo isset($empleado['edad']) ? $empleado['edad'] : ''; ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1">Sexo*</label>
                                            <div class="d-flex gap-3 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" id="sexoM" value="m"
                                                        <?php echo (isset($empleado['sexo']) && $empleado['sexo'] === 'm') ? 'checked' : ''; ?>
                                                        required>
                                                    <label class="form-check-label" for="sexoM">Mujer</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" id="sexoH" value="h"
                                                        <?php echo (isset($empleado['sexo']) && $empleado['sexo'] === 'h') ? 'checked' : ''; ?>
                                                        required>
                                                    <label class="form-check-label" for="sexoH">Hombre</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="rfc">RFC</label>
                                            <input type="text" class="form-control" id="rfc" name="rfc"
                                                value="<?php echo h($empleado['rfc']); ?>"
                                                maxlength="20">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="curp">CURP</label>
                                            <input type="text" class="form-control" id="curp" name="curp"
                                                value="<?php echo h($empleado['curp']); ?>"
                                                maxlength="20">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="nss">NSS</label>
                                            <input type="text" class="form-control" id="nss" name="nss"
                                                value="<?php echo h($empleado['nss']); ?>"
                                                maxlength="20">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información de Contacto</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="telefono">Teléfono*</label>
                                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                                value="<?php echo isset($empleado['telefono']) ? $empleado['telefono'] : ''; ?>"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="email">Email*</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="<?php echo isset($empleado['email']) ? $empleado['email'] : ''; ?>"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Laboral -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Laboral</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Carrera -->
                                        <div class="col-md-4 mb-3">
                                            <label for="fk_carrera" class="form-label">Carrera</label>
                                            <select class="form-select" id="fk_carrera" name="fk_carrera" required>
                                                <option value="">Seleccione...</option>
                                                <?php
                                                $sql_carrera = "SELECT pk_carrera, nombre_carrera FROM carrera WHERE estado = 1 ORDER BY nombre_carrera";
                                                $result_carrera = $conn->query($sql_carrera);
                                                if ($result_carrera && $result_carrera->num_rows > 0) {
                                                    while ($row = $result_carrera->fetch_assoc()) {
                                                        $selected = (isset($empleado['fk_carrera']) && $empleado['fk_carrera'] == $row['pk_carrera']) ? 'selected' : '';
                                                        echo "<option value='" . $row['pk_carrera'] . "' $selected>" . htmlspecialchars($row['nombre_carrera']) . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Puesto -->
                                        <div class="col-md-4 mb-3">
                                            <label for="fk_puesto" class="form-label">Puesto</label>
                                            <select class="form-select" id="fk_puesto" name="fk_puesto" required>
                                                <option value="">Seleccione...</option>
                                                <?php
                                                $sql_puesto = "SELECT pk_puesto, nombre_puesto FROM puesto WHERE estado = 1 ORDER BY nombre_puesto";
                                                $result_puesto = $conn->query($sql_puesto);
                                                if ($result_puesto && $result_puesto->num_rows > 0) {
                                                    while ($row = $result_puesto->fetch_assoc()) {
                                                        $selected = (isset($empleado['fk_puesto']) && $empleado['fk_puesto'] == $row['pk_puesto']) ? 'selected' : '';
                                                        echo "<option value='" . $row['pk_puesto'] . "' $selected>" . htmlspecialchars($row['nombre_puesto']) . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Turno -->
                                        <div class="col-md-4 mb-3">
                                            <label for="turno" class="form-label">Turno</label>
                                            <select class="form-select" id="turno" name="turno">
                                                <option value="">Seleccione...</option>
                                                <option value="matutino" <?php echo ($empleado['turno'] === 'matutino') ? 'selected' : ''; ?>>Matutino</option>
                                                <option value="vespertino" <?php echo ($empleado['turno'] === 'vespertino') ? 'selected' : ''; ?>>Vespertino</option>
                                                <option value="nocturno" <?php echo ($empleado['turno'] === 'nocturno') ? 'selected' : ''; ?>>Nocturno</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="estado">Estado</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="1" <?php echo ($empleado['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                                <option value="0" <?php echo ($empleado['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro*</label>
                                            <input type="time" class="form-control" id="hora" name="hora"
                                                value="<?php echo h($empleado['hora']); ?>" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación*</label>
                                            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion"
                                                value="<?php echo h($empleado['fecha_creacion']); ?>" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_modificacion">Fecha de Modificación</label>
                                            <input type="date" class="form-control" id="fecha_modificacion" name="fecha_modificacion"
                                                value="<?php echo h($empleado['fecha_modificacion']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-dark btn-lg" name="btnSubmit">
                                    <i class="fas fa-save me-2"></i>Actualizar Empleado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="<?php echo path('@js/validarNumero.empleados.js'); ?>"></script>
    <script src="<?php echo path('@js/campoEdad.empleados.js'); ?>"></script>
    <script src="<?php echo path('@js/validaciones.empleados.editar.js'); ?>"></script>
</body>

</html>