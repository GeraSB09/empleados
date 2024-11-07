// Restringir fechas futuras
const fechaNacimiento = document.getElementById('fecha_nacimiento');
fechaNacimiento.max = new Date().toISOString().split('T')[0];

// Validación de formatos y longitudes
const validaciones = {
    telefono: {
        element: document.getElementById('telefono'),
        maxLength: 10,
        pattern: '^[0-9]{10}$',
        message: 'El teléfono debe tener 10 dígitos numéricos'
    },
    rfc: {
        element: document.getElementById('rfc'),
        maxLength: 20,
        pattern: '^[A-Z&Ñ]{4}[0-9]{6}[A-Z0-9]{3}$',
        message: 'Formato de RFC inválido (AAAA999999AAA)'
    },
    curp: {
        element: document.getElementById('curp'),
        maxLength: 20,
        pattern: '^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$',
        message: 'Formato de CURP inválido'
    },
    nss: {
        element: document.getElementById('nss'),
        maxLength: 20,
        pattern: '^[0-9]{11}$',
        message: 'El NSS debe tener 11 dígitos numéricos'
    }
};

// Aplicar validaciones
Object.keys(validaciones).forEach(key => {
    const campo = validaciones[key];
    const elemento = campo.element;

    if (elemento) {
        elemento.maxLength = campo.maxLength;
        elemento.pattern = campo.pattern;

        elemento.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            if (this.value && !new RegExp(campo.pattern).test(this.value)) {
                this.setCustomValidity(campo.message);
            } else {
                this.setCustomValidity('');
            }
        });
    }
});

// Validar formato de imagen y tamaño
document.getElementById('fotografia').addEventListener('change', function() {
    const file = this.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    if (file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Formato no válido',
                text: 'Solo se permiten archivos PNG, JPG y WebP'
            });
            this.value = '';
            previewContainer.style.display = 'none';
            return;
        }

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'La imagen no debe superar los 5MB'
            });
            this.value = '';
            previewContainer.style.display = 'none';
            return;
        }

        // Mostrar vista previa
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
            document.getElementById('remove-image').style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
        document.getElementById('remove-image').style.display = 'none';
    }
});

// Agregar botón para eliminar la imagen
document.getElementById('preview-container').innerHTML += `
    <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-image" style="display: none;">
        <i class="fas fa-trash-alt"></i>
    </button>
`;

// Evento para eliminar la imagen
document.getElementById('remove-image').addEventListener('click', function() {
    document.getElementById('fotografia').value = '';
    document.getElementById('preview-container').style.display = 'none';
    this.style.display = 'none';
});

// Validación de sexo
document.querySelectorAll('input[name="sexo"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value !== 'm' && this.value !== 'h') {
            Swal.fire({
                icon: 'error',
                title: 'Valor inválido',
                text: 'El sexo debe ser "m" para mujer o "h" para hombre'
            });
            this.checked = false;
        }
    });
});

// Validación de estado (1 o 0)
document.getElementById('estado').addEventListener('change', function() {
    const valor = parseInt(this.value);
    if (valor !== 0 && valor !== 1) {
        Swal.fire({
            icon: 'error',
            title: 'Valor inválido',
            text: 'El estado debe ser 1 (activo) o 0 (inactivo)'
        });
        this.value = '1'; // Valor por defecto
    }
});

// Validación de longitud para campos de texto
document.querySelectorAll('input[type="text"]').forEach(input => {
    if (input.name === 'nombres' || input.name === 'primer_apellido' || input.name === 'segundo_apellido') {
        input.maxLength = 50;
        input.addEventListener('input', function() {
            if (this.value.length > 50) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Texto muy largo',
                    text: 'Este campo no puede exceder los 50 caracteres'
                });
                this.value = this.value.substring(0, 50);
            }
        });
    }
});

// Validación de email
document.getElementById('email').addEventListener('input', function() {
    if (this.value && !this.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        this.setCustomValidity('Por favor, ingrese un email válido');
    } else {
        this.setCustomValidity('');
    }
});

// Validación de turno
document.getElementById('turno').addEventListener('input', function() {
    if (this.value.length > 20) {
        Swal.fire({
            icon: 'warning',
            title: 'Texto muy largo',
            text: 'El turno no puede exceder los 20 caracteres'
        });
        this.value = this.value.substring(0, 20);
    }
});

// Modificar la parte del envío del formulario
document.getElementById('formularioEmpleado').addEventListener('submit', async function(e) {
    e.preventDefault();
    console.log('Formulario interceptado');

    // Validar todos los campos requeridos
    if (!this.checkValidity()) {
        e.stopPropagation();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, complete todos los campos requeridos correctamente'
        });
        return;
    }

    const formulario = this;
    const formData = new FormData(formulario);

    try {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas registrar este empleado?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            console.log('Enviando formulario');

            try {
                const response = await fetch('procesar_empleado.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                console.log('Respuesta del servidor:', data);

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        confirmButtonColor: '#3085d6'
                    });
                    window.location.href = 'empleados.php';
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error al procesar la respuesta del servidor'
                });
            }
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
});

// Mantener el código existente de actualización de hora
function actualizarHora() {
    let now = new Date();
    let hora = String(now.getHours()).padStart(2, '0');
    let minutos = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('hora').value = `${hora}:${minutos}`;
}

actualizarHora();
setInterval(actualizarHora, 1000);

document.getElementById('numero_empleado').addEventListener('input', function() {
    if (this.value < 1) {
        Swal.fire({
            icon: 'error',
            title: 'Número inválido',
            text: 'El número de empleado debe ser mayor a 0'
        });
        this.value = '';
    }
});