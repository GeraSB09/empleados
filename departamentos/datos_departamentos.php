<?php
require_once __DIR__ . '/../config/config.php';
include path('@conexion');

$estado = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : 'Departamentos';

function MostrarDepartamentos($estado, $titulo)
{
    global $conn;
    $sql = "SELECT * FROM departamento WHERE estado = $estado ORDER BY pk_departamento ASC";
    return $conn->query($sql);
}

$resultado = MostrarDepartamentos($estado, $titulo);

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
        <h1><?php echo $estado == 1 ? '<i class="fa-solid fa-building-circle-check"></i>  ' . $titulo : '<i class="fa-solid fa-building-circle-xmark"></i>  ' . $titulo; ?></h1>
    </div>


    <?php if ($resultado->num_rows > 0) { ?>
        <div class="container-fluid p-4">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Nombre de Departamento</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Fecha Creación</th>
                            <th class="px-4 py-3">Última Modificación</th>
                            <th class="px-4 py-3"><?php echo $estado == 1 ? 'Ocultar' : 'Mostrar'; ?></th>
                            <th class="px-4 py-3"><?php echo $estado == 1 ? 'Editar' : 'Eliminar'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()) { ?>
                            <tr class="text-center">
                                <td class="px-4 py-3"><?php echo $row['pk_departamento']; ?></td>
                                <td class="px-4 py-3"><?php echo $row['nombre_departamento']; ?></td>
                                <td class="px-4 py-3">
                                    <span class="badge <?php echo $estado == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $estado == 1 ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($row['fecha_creacion'])); ?></td>
                                <td class="px-4 py-3"><?php echo $row['fecha_modificacion'] ? date('d/m/Y', strtotime($row['fecha_modificacion'])) : 'N/A'; ?></td>
                                <td class="px-4 py-3">
                                    <?php if ($estado == 1) { ?>
                                        <button onclick="ocultarDepartamento(<?php echo $row['pk_departamento']; ?>, 0)"
                                            class="btn btn-warning btn-sm mx-1"
                                            title="Ocultar">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </button>
                                    <?php } elseif ($estado == 0) { ?>
                                        <button onclick="mostrarDepartamento(<?php echo $row['pk_departamento']; ?>, 1)"
                                            class="btn btn-success btn-sm mx-1"
                                            title="Mostrar">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($estado == 1) { ?>
                                        <button onclick="editarDepartamento(<?php echo $row['pk_departamento']; ?>)"
                                            class="btn btn-primary btn-sm mx-1"
                                            title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    <?php } elseif ($estado == 0) { ?>
                                        <button onclick="eliminarDepartamento(<?php echo $row['pk_departamento']; ?>)"
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
                    <p>No se encontraron departamentos <?php echo $estado == 1 ? 'activos' : 'inactivos'; ?> en el sistema.</p>
                </div>
            </div>
        <?php } ?>

        <script src="<?php echo path('@js/SweetAlerts.departamentos.js'); ?>"></script>
</body>

</html>
<?php

$conn->close();
?>