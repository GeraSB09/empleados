<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Puestos</title>
    <link rel="stylesheet" href="<?php echo path('@global:css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo path('@custom:css'); ?>" type="text/css">
    <?php
    include path('@conexion');
    include path('@componentes');
    date_default_timezone_set('America/Mazatlan');
    ?>
</head>

<body class="bg-pattern">
    <?php include path('@nav'); ?>
    <div class="container-fluid mt-5 px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mb-5">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center font-weight-light my-2">Registro de Puestos</h3>
                    </div>
                    <div class="card-body">
                        <form action="crear_puesto.php" method="POST" id="formularioPuesto">
                            <!-- Información del Puesto -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Puesto</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="nombre_puesto">Nombre del Puesto*</label>
                                            <input type="text" class="form-control" id="nombre_puesto"
                                                name="nombre_puesto"
                                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{3,50}"
                                                title="Solo se permiten letras y espacios. Mínimo 3 caracteres, máximo 50"
                                                required>
                                            <div class="invalid-feedback">
                                                Por favor ingrese un nombre válido (solo letras y espacios, 3-50 caracteres)
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="salario">Salario*</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="salario"
                                                    name="salario"
                                                    step="0.01"
                                                    min="0.01"
                                                    required>
                                            </div>
                                            <div class="form-text">Ingrese el salario sin comas (ejemplo: 15000.00)</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="fk_departamento">Departamento*</label>
                                            <select class="form-select" id="fk_departamento" name="fk_departamento" required>
                                                <option value="" disabled selected>Seleccione un departamento...</option>
                                                <?php
                                                $sql = "SELECT pk_departamento, nombre_departamento 
                                                       FROM departamento 
                                                       WHERE estado = 1 
                                                       ORDER BY nombre_departamento";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['pk_departamento'] . "'>"
                                                            . $row['nombre_departamento'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor seleccione un departamento válido
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="estado">Estado*</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor seleccione un estado válido
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro</label>
                                            <input type="time" class="form-control" id="hora"
                                                name="hora"
                                                value="<?php echo date('H:i'); ?>"
                                                readonly>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación</label>
                                            <input type="date" class="form-control" id="fecha_creacion"
                                                name="fecha_creacion"
                                                value="<?php echo date('Y-m-d'); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-dark btn-lg" name="btnSubmit">
                                    <i class="fas fa-save me-2"></i>Registrar Puesto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formularioPuesto').addEventListener('submit', function(e) {
            e.preventDefault();

            const nombrePuesto = document.getElementById('nombre_puesto').value.trim();
            const salario = parseFloat(document.getElementById('salario').value);
            const departamento = document.getElementById('fk_departamento').value;

            // Validaciones
            if (nombrePuesto.length < 3 || nombrePuesto.length > 50) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El nombre del puesto debe tener entre 3 y 50 caracteres'
                });
                return;
            }

            if (salario <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El salario debe ser mayor a 0'
                });
                return;
            }

            if (!departamento) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Debe seleccionar un departamento'
                });
                return;
            }

            // Confirmar envío
            Swal.fire({
                title: '¿Está seguro de registrar este puesto?',
                text: 'Verifique que los datos sean correctos',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar formulario mediante AJAX
                    const formData = new FormData(this);

                    fetch('crear_puesto.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: data.message,
                                    confirmButtonColor: '#198754'
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                            } else {
                                throw new Error(data.message);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message,
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });
        });

        // Convertir a mayúsculas mientras se escribe
        document.getElementById('nombre_puesto').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Formatear el campo de salario
        document.getElementById('salario').addEventListener('blur', function(e) {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });

        // Evitar espacios múltiples
        document.getElementById('nombre_puesto').addEventListener('keyup', function(e) {
            this.value = this.value.replace(/\s+/g, ' ');
        });

        // Evitar pegar contenido con caracteres no permitidos
        document.getElementById('nombre_puesto').addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.originalEvent || e).clipboardData.getData('text/plain');
            const sanitized = text.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, '');
            document.execCommand('insertText', false, sanitized);
        });
    </script>
</body>

</html>