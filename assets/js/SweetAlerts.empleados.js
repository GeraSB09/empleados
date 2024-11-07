 // alertas para empleados
 function editarEmpleado(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea editar este empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, editar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `editar_empleado.php?id=${id}`;
        }
    });
}

function ocultarEmpleado(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea ocultar este empleado?',
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

function mostrarEmpleado(id, nuevoEstado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea mostrar este empleado?',
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

function eliminarEmpleado(id) {
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
            window.location.href = `eliminar_empleado.php?id=${id}`;
        }
    });
}