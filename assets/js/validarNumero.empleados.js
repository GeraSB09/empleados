
// Función para validar número de empleado
 document.getElementById('numero_empleado').addEventListener('change', async function() {
    const numero = this.value;
    try {
        const response = await fetch('validar_empleado.php?numero=' + numero);
        const data = await response.json();
        if (!data.disponible) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Este número de empleado ya está en uso'
            });
            this.value = '';
            this.focus();
        }
    } catch (error) {
        console.error('Error:', error);
    }
});