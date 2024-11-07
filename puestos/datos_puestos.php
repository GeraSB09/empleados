<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

$estado = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : 'Puestos';

function MostrarPuestos($estado, $titulo)
{
    global $conn;
    $sql = "SELECT p.*, d.nombre_departamento 
            FROM puesto p 
            JOIN departamento d ON p.fk_departamento = d.pk_departamento 
            WHERE p.estado = $estado 
            ORDER BY p.pk_puesto ASC";
    return $conn->query($sql);
}

$resultado = MostrarPuestos($estado, $titulo);
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
        <h1><?php echo $estado == 1 ? '<i class="fa-solid fa-briefcase"></i>  ' . $titulo : '<i class="fa-solid fa-briefcase-blank"></i>  ' . $titulo; ?></h1>
    </div>

    <?php if ($resultado->num_rows > 0) { ?>
        <div class="container-fluid p-4">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Nombre del Puesto</th>
                            <th class="px-4 py-3">Salario</th>
                            <th class="px-4 py-3">Departamento</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Hora</th>
                            <th class="px-4 py-3">Fecha Creación</th>
                            <th class="px-4 py-3">Última Modificación</th>
                            <th class="px-4 py-3"><?php echo $estado == 1 ? 'Ocultar' : 'Mostrar'; ?></th>
                            <th class="px-4 py-3"><?php echo $estado == 1 ? 'Editar' : 'Eliminar'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()) { ?>
                            <tr class="text-center">
                                <td class="px-4 py-3"><?php echo $row['pk_puesto']; ?></td>
                                <td class="px-4 py-3"><?php echo $row['nombre_puesto']; ?></td>
                                <td class="px-4 py-3">$<?php echo number_format($row['salario'], 2); ?></td>
                                <td class="px-4 py-3"><?php echo $row['nombre_departamento']; ?></td>
                                <td class="px-4 py-3">
                                    <span class="badge <?php echo $estado == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $estado == 1 ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3"><?php echo $row['hora']; ?></td>
                                <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($row['fecha_creacion'])); ?></td>
                                <td class="px-4 py-3"><?php echo $row['fecha_modificacion'] ? date('d/m/Y', strtotime($row['fecha_modificacion'])) : 'N/A'; ?></td>
                                <td class="px-4 py-3">
                                    <?php if ($estado == 1) { ?>
                                        <button onclick="ocultarPuesto(<?php echo $row['pk_puesto']; ?>, 0)"
                                            class="btn btn-warning btn-sm mx-1"
                                            title="Ocultar">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </button>
                                    <?php } elseif ($estado == 0) { ?>
                                        <button onclick="mostrarPuesto(<?php echo $row['pk_puesto']; ?>, 1)"
                                            class="btn btn-success btn-sm mx-1"
                                            title="Mostrar">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($estado == 1) { ?>
                                        <button onclick="editarPuesto(<?php echo $row['pk_puesto']; ?>)"
                                            class="btn btn-primary btn-sm mx-1"
                                            title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    <?php } elseif ($estado == 0) { ?>
                                        <button onclick="eliminarPuesto(<?php echo $row['pk_puesto']; ?>)"
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
        <?php } else { ?>
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">No hay registros</h4>
                    <p>No se encontraron puestos <?php echo $estado == 1 ? 'activos' : 'inactivos'; ?> en el sistema.</p>
                </div>
            </div>
        <?php } ?>

        <script src="<?php echo path('@js/SweetAlerts.puestos.js'); ?>"></script>


</html>
<?php
$conn->close();
?>