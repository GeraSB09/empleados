<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Empleados</title>
    <link rel="stylesheet" href="<?php echo path('@global:css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo path('@custom:css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo path('@image:css'); ?>" type="text/css">
    <?php
    include path('@conexion');
    include path('@componentes');
    date_default_timezone_set('America/Mazatlan');
    ?>
    <style>

    </style>
</head>

<body class="bg-pattern">
    <?php include path('@nav'); ?>
    <div class="container-fluid mt-5 px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mb-5">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center font-weight-light my-2">Registro de Empleados</h3>
                    </div>
                    <div class="card-body">
                        <form action="crear_empleado.php" method="POST" enctype="multipart/form-data" id="formularioEmpleado">

                            <!-- Información Básica -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Básica</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row" style="padding-left: 150px;">
                                        <!-- Fotografía -->
                                        <div class="col-md-3 mb-3 p-2">
                                            <label class="small mb-3" for="fotografia">Fotografía del Empleado</label>
                                            <div id="preview-container" class="mt-2 text-center" style="display: none;">
                                                <img id="preview-image" class="img-fluid rounded mb-2 rounded-circle" src="" alt="Vista previa"
                                                    style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            </div>
                                            <input type="file" class="form-control" id="fotografia" name="fotografia"
                                                accept="image/jpeg,image/png,image/webp">
                                            <div class="form-text mb-2">Formatos permitidos: JPG, PNG, WebP. Tamaño máximo: 5MB</div>
                                        </div>

                                        <!-- Datos básicos -->
                                        <div class="col-md-8" style="padding: 55px;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="small mb-3" for="numero_empleado">Número de Empleado*</label>
                                                    <input type="number" class="form-control" id="numero_empleado" name="numero_empleado" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="small mb-3" for="nombres">Nombres*</label>
                                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 p-2">
                                                    <label class="small mb-1" for="primer_apellido">Primer Apellido*</label>
                                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
                                                </div>
                                                <div class="col-md-6 mb-3 p-2">
                                                    <label class="small mb-1" for="segundo_apellido">Segundo Apellido</label>
                                                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
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
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="edad">Edad</label>
                                            <input type="number" class="form-control" id="edad" name="edad" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1">Sexo*</label>
                                            <div class="d-flex gap-3 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" id="sexoM" value="m" required>
                                                    <label class="form-check-label" for="sexoM">Mujer</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" id="sexoH" value="h" required>
                                                    <label class="form-check-label" for="sexoH">Hombre</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="rfc">RFC</label>
                                            <input type="text" class="form-control" id="rfc" name="rfc" maxlength="20">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="curp">CURP</label>
                                            <input type="text" class="form-control" id="curp" name="curp" maxlength="20">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="nss">NSS</label>
                                            <input type="text" class="form-control" id="nss" name="nss" maxlength="20">
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
                                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="email">Email*</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
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
                                        <div class="col-md-4 mb-3">
                                            <label for="fk_carrera" class="form-label">Carrera</label>
                                            <select class="form-select" id="fk_carrera" name="fk_carrera" required>
                                                <option class="text-muted" value="" disabled selected>Seleccione...</option>
                                                <?php
                                                $sql = "SELECT pk_carrera, nombre_carrera FROM carrera WHERE estado = 1 ORDER BY nombre_carrera";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['pk_carrera'] . "'>" . $row['nombre_carrera'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay carreras disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="fk_puesto" class="form-label">Puesto</label>
                                            <select class="form-select" id="fk_puesto" name="fk_puesto" required>
                                                <option class="text-muted" value="" disabled selected>Seleccione...</option>
                                                <?php
                                                $sql = "SELECT pk_puesto, nombre_puesto FROM puesto WHERE estado = 1 ORDER BY nombre_puesto";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['pk_puesto'] . "'>" . $row['nombre_puesto'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay puestos disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="turno" class="form-label">Turno</label>
                                            <select class="form-select" id="turno" name="turno">
                                                <option class="text-muted" value="" disabled selected>Seleccione...</option>
                                                <option value="matutino">Matutino</option>
                                                <option value="vespertino">Vespertino</option>
                                                <option value="nocturno">Nocturno</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="estado">Estado</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option class="text-muted" value="" disabled selected>Seleccione...</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro*</label>
                                            <input type="time" class="form-control" id="hora" name="hora" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación*</label>
                                            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion"
                                                value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-dark btn-lg" name="btnSubmit">
                                    <i class="fas fa-save me-2"></i>Registrar Empleado
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
    <script src="<?php echo path('@js/validaciones.empleados.insertar.js'); ?>"></script>
</body>

</html>