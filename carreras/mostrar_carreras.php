<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

function MostrarCarreras($estado, $titulo)
{
    global $conn;

    $sql = "SELECT * FROM carrera WHERE estado = $estado ORDER BY pk_carrera ASC";
    $resultado = $conn->query($sql);
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title><?php echo $titulo; ?></title>
        <?php include path('@componentes'); ?>
        <link rel="stylesheet" href="<?php echo path('@custom'); ?>" type="text/css">
    </head>

    <body class="bg-pattern">
        <?php include path('@nav'); ?><br>

        <div align="center" class="p-4">
            <h1><?php echo $estado == 1 ? $titulo : '<i class="fa-solid fa-trash"></i> ' . $titulo; ?></h1>
        </div>


        <?php if ($resultado->num_rows > 0) { ?>
            <div class="container-fluid p-4">
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nombre de Carrera</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Fecha Creación</th>
                                <th class="px-4 py-3">Última Modificación</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $resultado->fetch_assoc()) { ?>
                                <tr class="text-center">
                                    <td class="px-4 py-3"><?php echo $row['pk_carrera']; ?></td>
                                    <td class="px-4 py-3"><?php echo $row['nombre_carrera']; ?></td>
                                    <td class="px-4 py-3">
                                        <span class="badge <?php echo $estado == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $estado == 1 ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($row['fecha_creacion'])); ?></td>
                                    <td class="px-4 py-3"><?php echo $row['fecha_modificacion'] ? date('d/m/Y', strtotime($row['fecha_modificacion'])) : 'N/A'; ?></td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <?php if ($estado == 1) { ?>
                                                <a href="editar_carrera.php?id=<?php echo $row['pk_carrera']; ?>"
                                                    class="btn btn-primary btn-sm"
                                                    title="Editar">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button onclick="cambiarEstado(<?php echo $row['pk_carrera']; ?>, 0)"
                                                    class="btn btn-warning btn-sm"
                                                    title="Desactivar">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button onclick="cambiarEstado(<?php echo $row['pk_carrera']; ?>, 1)"
                                                    class="btn btn-success btn-sm"
                                                    title="Activar">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button onclick="eliminarCarrera(<?php echo $row['pk_carrera']; ?>)"
                                                    class="btn btn-danger btn-sm"
                                                    title="Eliminar">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">No hay registros</h4>
                    <p>No se encontraron carreras <?php echo $estado == 1 ? 'activas' : 'inactivas'; ?> en el sistema.</p>
                </div>
            <?php } ?>
            </div>
            </div>
            </div>

            <script>
                function cambiarEstado(id, nuevoEstado) {
                    if (confirm('¿Está seguro de cambiar el estado de la carrera?')) {
                        window.location.href = `actualizar_estado.php?id=${id}&estado=${nuevoEstado}`;
                    }
                }

                function eliminarCarrera(id) {
                    if (confirm('¿Está seguro de eliminar esta carrera? Esta acción no se puede deshacer.')) {
                        window.location.href = `eliminar_carrera.php?id=${id}`;
                    }
                }
            </script>
    </body>

    </html>
<?php
}

$estado = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : 'Carreras';

MostrarCarreras($estado, $titulo);
$conn->close();
?>