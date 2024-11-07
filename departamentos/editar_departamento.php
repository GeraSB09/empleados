<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se recibió un ID
if (!isset($_GET['id'])) {
    header('Location: datos_departamentos.php?error=No se especificó el ID del departamento');
    exit;
}

$id = $_GET['id'];

// Obtener los datos del departamento
$sql = "SELECT * FROM departamento WHERE pk_departamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header('Location: datos_departamentos.php?error=Departamento no encontrado');
    exit;
}

$departamento = $resultado->fetch_assoc();

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
    <title>Editar Departamento</title>
    <link rel="stylesheet" href="<?php echo path('@global:css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo path('@custom:css'); ?>" type="text/css">
    <?php 
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
                        <h3 class="text-center font-weight-light my-2">
                            Editar Departamento: <?php echo htmlspecialchars($departamento['nombre_departamento']); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="procesar_departamento.php" method="POST" id="formularioDepartamento">
                            <input type="hidden" name="pk_departamento" value="<?php echo h($departamento['pk_departamento']); ?>">

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
                                                   value="<?php echo h($departamento['nombre_departamento']); ?>"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{3,50}"
                                                   title="Solo se permiten letras y espacios. Mínimo 3 caracteres, máximo 50"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="estado">Estado*</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="1" <?php echo ($departamento['estado'] == 1) ? 'selected' : ''; ?>>
                                                    Activo
                                                </option>
                                                <option value="0" <?php echo ($departamento['estado'] == 0) ? 'selected' : ''; ?>>
                                                    Inactivo
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro*</label>
                                            <input type="time" class="form-control" id="hora" 
                                                   name="hora"
                                                   value="<?php echo h($departamento['hora']); ?>" 
                                                   readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación*</label>
                                            <input type="date" class="form-control" id="fecha_creacion" 
                                                   name="fecha_creacion"
                                                   value="<?php echo h($departamento['fecha_creacion']); ?>" 
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_modificacion">Fecha de Modificación</label>
                                            <input type="date" class="form-control" id="fecha_modificacion" 
                                                   name="fecha_modificacion"
                                                   value="<?php echo date('Y-m-d'); ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-dark btn-lg" name="btnSubmit">
                                    <i class="fas fa-save me-2"></i>Actualizar Departamento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('formularioDepartamento').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const nombreDepartamento = document.getElementById('nombre_departamento').value.trim();
        
        // Validaciones
        if (nombreDepartamento.length < 3 || nombreDepartamento.length > 50) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El nombre del departamento debe tener entre 3 y 50 caracteres'
            });
            return;
        }

        if (!/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreDepartamento)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El nombre del departamento solo puede contener letras y espacios'
            });
            return;
        }

        // Confirmar actualización
        Swal.fire({
            title: '¿Está seguro de actualizar este departamento?',
            text: 'Verifique que los datos sean correctos',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
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
<?php
$conn->close();
?> 