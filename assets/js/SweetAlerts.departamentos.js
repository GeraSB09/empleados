// Alertas para departamentos
function editarDepartamento(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea editar este departamento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, editar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `editar_departamento.php?id=${id}`;
        }
    });
}

function ocultarDepartamento(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea ocultar este departamento?',
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

function mostrarDepartamento(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea mostrar este departamento?',
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

function eliminarDepartamento(id) {
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
            window.location.href = `eliminar_departamento.php?id=${id}`;
        }
    });
} 