<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Departamentos</title>
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
                        <h3 class="text-center font-weight-light my-2">Registro de Departamentos</h3>
                    </div>
                    <div class="card-body">
                        <form action="crear_departamento.php" method="POST" id="formularioDepartamento">
                            <!-- Información del Departamento -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Departamento</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="small mb-1" for="nombre_departamento">Nombre del Departamento*</label>
                                            <input type="text" class="form-control" id="nombre_departamento" 
                                                   name="nombre_departamento" 
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{3,50}"
                                                   title="Solo se permiten letras y espacios. Mínimo 3 caracteres, máximo 50"
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor ingrese un nombre válido (solo letras y espacios, 3-50 caracteres)
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="estado">Estado*</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro*</label>
                                            <input type="time" class="form-control" id="hora" name="hora" 
                                                   value="<?php echo date('H:i'); ?>" readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación*</label>
                                            <input type="date" class="form-control" id="fecha_creacion" 
                                                   name="fecha_creacion" 
                                                   value="<?php echo date('Y-m-d'); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-dark btn-lg" name="btnSubmit">
                                    <i class="fas fa-save me-2"></i>Registrar Departamento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validaciones del formulario
        document.getElementById('formularioDepartamento').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombreDepartamento = document.getElementById('nombre_departamento').value.trim();
            
            // Validar longitud del nombre
            if (nombreDepartamento.length < 3 || nombreDepartamento.length > 50) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El nombre del departamento debe tener entre 3 y 50 caracteres'
                });
                return;
            }

            // Validar que solo contenga letras y espacios
            if (!/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreDepartamento)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El nombre del departamento solo puede contener letras y espacios'
                });
                return;
            }

            // Confirmar envío
            Swal.fire({
                title: '¿Está seguro de registrar este departamento?',
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
                    
                    fetch('crear_departamento.php', {
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
        document.getElementById('nombre_departamento').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Evitar espacios múltiples mientras se escribe
        document.getElementById('nombre_departamento').addEventListener('keyup', function(e) {
            this.value = this.value.replace(/\s+/g, ' ');
        });

        // Evitar pegar contenido con caracteres no permitidos
        document.getElementById('nombre_departamento').addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.originalEvent || e).clipboardData.getData('text/plain');
            const sanitized = text.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, '');
            document.execCommand('insertText', false, sanitized);
        });
    </script>
</body>

</html> 