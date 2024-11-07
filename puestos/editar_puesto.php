<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

// Verificar si se recibió un ID
if (!isset($_GET['id'])) {
    header('Location: datos_puestos.php?error=No se especificó el ID del puesto');
    exit;
}

$id = $_GET['id'];

// Obtener los datos del puesto
$sql = "SELECT p.*, d.nombre_departamento 
        FROM puesto p 
        JOIN departamento d ON p.fk_departamento = d.pk_departamento 
        WHERE p.pk_puesto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header('Location: datos_puestos.php?error=Puesto no encontrado');
    exit;
}

$puesto = $resultado->fetch_assoc();

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
    <title>Editar Puesto</title>
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
                            Editar Puesto: <?php echo htmlspecialchars($puesto['nombre_puesto']); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="procesar_puesto.php" method="POST" id="formularioPuesto">
                            <input type="hidden" name="pk_puesto" value="<?php echo h($puesto['pk_puesto']); ?>">

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
                                                   value="<?php echo h($puesto['nombre_puesto']); ?>"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{3,50}"
                                                   title="Solo se permiten letras y espacios. Mínimo 3 caracteres, máximo 50"
                                                   required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="salario">Salario*</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="salario" 
                                                       name="salario"
                                                       value="<?php echo h($puesto['salario']); ?>"
                                                       step="0.01" 
                                                       min="0.01"
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="fk_departamento">Departamento*</label>
                                            <select class="form-select" id="fk_departamento" name="fk_departamento" required>
                                                <option value="">Seleccione un departamento</option>
                                                <?php
                                                $sql_dep = "SELECT pk_departamento, nombre_departamento 
                                                           FROM departamento 
                                                           WHERE estado = 1 
                                                           ORDER BY nombre_departamento";
                                                $result_dep = $conn->query($sql_dep);
                                                while ($dep = $result_dep->fetch_assoc()) {
                                                    $selected = ($dep['pk_departamento'] == $puesto['fk_departamento']) ? 'selected' : '';
                                                    echo "<option value='" . h($dep['pk_departamento']) . "' $selected>" . 
                                                         h($dep['nombre_departamento']) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1" for="estado">Estado*</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="1" <?php echo ($puesto['estado'] == 1) ? 'selected' : ''; ?>>
                                                    Activo
                                                </option>
                                                <option value="0" <?php echo ($puesto['estado'] == 0) ? 'selected' : ''; ?>>
                                                    Inactivo
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="hora">Hora de Registro*</label>
                                            <input type="time" class="form-control" id="hora" 
                                                   name="hora"
                                                   value="<?php echo h($puesto['hora']); ?>" 
                                                   readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="small mb-1" for="fecha_creacion">Fecha de Creación*</label>
                                            <input type="date" class="form-control" id="fecha_creacion" 
                                                   name="fecha_creacion"
                                                   value="<?php echo h($puesto['fecha_creacion']); ?>" 
                                                   readonly>
                                        </div>

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
                                    <i class="fas fa-save me-2"></i>Actualizar Puesto
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
        const salario = document.getElementById('salario').value;
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

        if (!/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test(nombrePuesto)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El nombre del puesto solo puede contener letras y espacios'
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

        // Confirmar actualización
        Swal.fire({
            title: '¿Está seguro de actualizar este puesto?',
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
    document.getElementById('nombre_puesto').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });

    // Formatear el salario
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
<?php
$conn->close();
?> 