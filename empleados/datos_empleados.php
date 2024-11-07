<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

function DatosDeEmpleados($estado, $titulo)
{
    global $conn;

    // consulta de datos
    $sql = "SELECT e.*, p.nombre_puesto, c.nombre_carrera 
            FROM empleados e 
            LEFT JOIN puesto p ON e.fk_puesto = p.pk_puesto 
            LEFT JOIN carrera c ON e.fk_carrera = c.pk_carrera 
            WHERE e.estado = $estado";
    $resultado = $conn->query($sql);
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title><?php echo $titulo; ?></title>
        <?php include path('@componentes'); ?>
        <link rel="stylesheet" href="<?php echo path('@custom:css'); ?>" type="text/css">

    </head>

    <body class="bg-pattern">
        <?php include path('@nav'); ?><br>

        <div align="center" class="p-4">
            <h1><?php echo $estado == 1 ? '<i class="fa-solid fa-user-check"></i>  ' . $titulo : '<i class="fa-solid fa-user-xmark"></i>  ' . $titulo; ?></h1>
        </div>

        <?php
        if ($resultado->num_rows > 0) { ?>
            <div class="container-fluid p-4">
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th class="px-4 py-3">No. Empleado</th>
                                <th class="px-4 py-3">Nombres</th>
                                <th class="px-4 py-3">Primer Apellido</th>
                                <th class="px-4 py-3">Segundo Apellido</th>
                                <th class="px-4 py-3">Edad</th>
                                <th class="px-4 py-3">Sexo</th>
                                <th class="px-4 py-3">Fecha Nac.</th>
                                <th class="px-4 py-3">Foto</th>
                                <th class="px-4 py-3">Teléfono</th>
                                <th class="px-4 py-3">RFC</th>
                                <th class="px-4 py-3">CURP</th>
                                <th class="px-4 py-3">NSS</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Turno</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Hora</th>
                                <th class="px-4 py-3">Fecha Creación</th>
                                <th class="px-4 py-3">Fecha Modif.</th>
                                <th class="px-4 py-3">Puesto</th>
                                <th class="px-4 py-3">Carrera</th>
                                <th class="px-4 py-3"><?php echo $estado == 1 ? 'Ocultar' : 'Mostrar'; ?></th>
                                <th class="px-4 py-3"><?php echo $estado == 1 ? 'Editar' : 'Eliminar'; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($reglon = $resultado->fetch_assoc()) { ?>
                                <tr class="text-center">

                                    <td class="px-4 py-3"><?php echo $reglon['numero_empleado']; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['nombres']; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['primer_apellido']; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['segundo_apellido'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['edad']; ?></td>
                                    <td class="px-4 py-3">
                                        <span class="badge <?php echo $reglon['sexo'] == 'h' ? 'bg-primary' : 'bg-info'; ?>">
                                            <?php echo $reglon['sexo'] == 'h' ? 'Hombre' : 'Mujer'; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($reglon['fecha_nacimiento'])); ?></td>
                                    <td class="px-4 py-3">
                                        <?php if (!empty($reglon['fotografia'])) { ?>
                                            <div class="mb-3 img-thumbnail text-center">
                                                <img src="<?php echo $reglon['fotografia']; ?>" alt="Foto ..." class="rounded-circle" style="max-width: 50px;">
                                            </div>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Sin foto</span>
                                        <?php } ?>
                                    </td>
                                    <td class="px-4 py-3"><?php echo $reglon['telefono'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['rfc'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['curp'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['nss'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['email'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['turno'] ?: 'N/A'; ?></td>
                                    <td class="px-4 py-3">
                                        <span class="badge <?php echo $estado == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $estado == 1 ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3"><?php echo $reglon['hora']; ?></td>
                                    <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($reglon['fecha_creacion'])); ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['fecha_modificacion'] ? date('d/m/Y', strtotime($reglon['fecha_modificacion'])) : 'N/A'; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['nombre_puesto']; ?></td>
                                    <td class="px-4 py-3"><?php echo $reglon['nombre_carrera']; ?></td>
                                    <td class="px-4 py-3">
                                        <?php if ($estado == 1) { ?>
                                            <button onclick="ocultarEmpleado(<?php echo $reglon['pk_empleado']; ?>, 0)"
                                                class="btn btn-warning btn-sm mx-1"
                                                title="Ocultar">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </button>
                                        <?php } elseif ($estado == 0) { ?>
                                            <button onclick="mostrarEmpleado(<?php echo $reglon['pk_empleado']; ?>, 1)"
                                                class="btn btn-success btn-sm mx-1"
                                                title="Mostrar">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if ($estado == 1) { ?>
                                            <button onclick="editarEmpleado(<?php echo $reglon['pk_empleado']; ?>)"
                                                class="btn btn-primary btn-sm mx-1"
                                                title="Editar">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        <?php } elseif ($estado == 0) { ?>
                                            <button onclick="eliminarEmpleado(<?php echo $reglon['pk_empleado']; ?>)"
                                                class="btn btn-secondary btn-sm mx-1"
                                                title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">No hay registros</h4>
                    <p>No se encontraron empleados <?php echo $estado == 1 ? 'activos' : 'inactivos'; ?> en el sistema.</p>
                </div>
            </div>
        <?php } ?>

        <script src="<?php echo path('@js/SweetAlerts.empleados.js'); ?>"></script>
    </body>

    </html>
<?php
}

// Obtener parámetros de la URL
$estado = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : 'Empleados';

DatosDeEmpleados($estado, $titulo);

$conn->close();
?>