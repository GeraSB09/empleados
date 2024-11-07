// Alertas para puestos
function editarPuesto(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea editar este puesto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, editar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `editar_puesto.php?id=${id}`;
        }
    });
}

function ocultarPuesto(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea ocultar este puesto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ocultar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `actualizar_estado.php?id=${id}&estado=${nuevoEstado}`;
        }
    });
}

function mostrarPuesto(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea mostrar este puesto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, mostrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `actualizar_estado.php?id=${id}&estado=${nuevoEstado}`;
        }
    });
}

function eliminarPuesto(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `eliminar_puesto.php?id=${id}`;
        }
    });
} 