// Restringir fechas futuras
const fechaNacimiento = document.getElementById("fecha_nacimiento");
fechaNacimiento.max = new Date().toISOString().split("T")[0];

// Validación de formatos y longitudes
const validaciones = {
  telefono: {
    element: document.getElementById("telefono"),
    maxLength: 10,
    pattern: "^[0-9]{10}$",
    message: "El teléfono debe tener 10 dígitos numéricos",
  },
  rfc: {
    element: document.getElementById("rfc"),
    maxLength: 20,
    pattern: "^[A-Z&Ñ]{4}[0-9]{6}[A-Z0-9]{3}$",
    message: "Formato de RFC inválido (AAAA999999AAA)",
  },
  curp: {
    element: document.getElementById("curp"),
    maxLength: 20,
    pattern: "^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$",
    message: "Formato de CURP inválido",
  },
  nss: {
    element: document.getElementById("nss"),
    maxLength: 20,
    pattern: "^[0-9]{11}$",
    message: "El NSS debe tener 11 dígitos numéricos",
  },
};

// Aplicar validaciones
Object.keys(validaciones).forEach((key) => {
  const campo = validaciones[key];
  const elemento = campo.element;

  if (elemento) {
    elemento.maxLength = campo.maxLength;
    elemento.pattern = campo.pattern;

    elemento.addEventListener("input", function () {
      this.value = this.value.toUpperCase();
      if (this.value && !new RegExp(campo.pattern).test(this.value)) {
        this.setCustomValidity(campo.message);
      } else {
        this.setCustomValidity("");
      }
    });
  }
});

// Validar formato de imagen y tamaño
document.getElementById("fotografia").addEventListener("change", function () {
  const file = this.files[0];
  const validTypes = ["image/jpeg", "image/png", "image/webp"];
  const maxSize = 5 * 1024 * 1024; // 5MB máximo

  if (file) {
    if (!validTypes.includes(file.type)) {
      Swal.fire({
        icon: "error",
        title: "Formato no válido",
        text: "Solo se permiten archivos PNG, JPG y WebP",
      });
      this.value = "";
      return;
    }

    if (file.size > maxSize) {
      Swal.fire({
        icon: "error",
        title: "Archivo muy grande",
        text: "La imagen no debe superar los 5MB",
      });
      this.value = "";
      return;
    }
  }
});

// Validación de sexo
document.querySelectorAll('input[name="sexo"]').forEach((radio) => {
  radio.addEventListener("change", function () {
    if (this.value !== "m" && this.value !== "h") {
      Swal.fire({
        icon: "error",
        title: "Valor inválido",
        text: 'El sexo debe ser "m" para mujer o "h" para hombre',
      });
      this.checked = false;
    }
  });
});

// Validación de estado (1 o 0)
document.getElementById("estado").addEventListener("change", function () {
  const valor = parseInt(this.value);
  if (valor !== 0 && valor !== 1) {
    Swal.fire({
      icon: "error",
      title: "Valor inválido",
      text: "El estado debe ser 1 (activo) o 0 (inactivo)",
    });
    this.value = "1"; // Valor por defecto
  }
});

// Validación de longitud para campos de texto
document.querySelectorAll('input[type="text"]').forEach((input) => {
  if (
    input.name === "nombres" ||
    input.name === "primer_apellido" ||
    input.name === "segundo_apellido"
  ) {
    input.maxLength = 50;
    input.addEventListener("input", function () {
      if (this.value.length > 50) {
        Swal.fire({
          icon: "warning",
          title: "Texto muy largo",
          text: "Este campo no puede exceder los 50 caracteres",
        });
        this.value = this.value.substring(0, 50);
      }
    });
  }
});

// Validación de email
document.getElementById("email").addEventListener("input", function () {
  if (this.value && !this.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
    this.setCustomValidity("Por favor, ingrese un email válido");
  } else {
    this.setCustomValidity("");
  }
});

// Validación de turno
document.getElementById("turno").addEventListener("input", function () {
  if (this.value.length > 20) {
    Swal.fire({
      icon: "warning",
      title: "Texto muy largo",
      text: "El turno no puede exceder los 20 caracteres",
    });
    this.value = this.value.substring(0, 20);
  }
});

// Modificar la parte del envío del formulario
document
  .getElementById("formularioEmpleado")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!this.checkValidity()) {
      e.stopPropagation();
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Por favor, complete todos los campos requeridos correctamente",
      });
      return;
    }

    try {
      const result = await Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Deseas actualizar este empleado?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, actualizar",
        cancelButtonText: "Cancelar",
      });

      if (result.isConfirmed) {
        const formData = new FormData(this);
        formData.append("accion", "actualizar"); // Identificador de acción

        // Agregar la fecha de modificación actual
        const fechaActual = new Date().toISOString().split("T")[0];
        formData.append("fecha_modificacion", fechaActual);

        const response = await fetch("actualizar_empleado.php", {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          throw new Error("Error en la respuesta del servidor");
        }

        const data = await response.json();

        if (data.success) {
          await Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: data.message,
            confirmButtonColor: "#3085d6",
          });
          const estadoActual = document.getElementById("estado").value;
          const tituloEstado = estadoActual == 1 ? "Activos" : "Inactivos";
          window.location.href = `datos_empleados.php?estado=${estadoActual}&titulo=Empleados ${tituloEstado}`;
        } else {
          throw new Error(data.message || "Error al actualizar el empleado");
        }
      }
    } catch (error) {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: error.message,
      });
    }
  });

// Mantener el código existente de actualización de hora
function actualizarHora() {
  let now = new Date();
  let hora = String(now.getHours()).padStart(2, "0");
  let minutos = String(now.getMinutes()).padStart(2, "0");
  document.getElementById("hora").value = `${hora}:${minutos}`;
}

actualizarHora();
setInterval(actualizarHora, 1000);

document
  .getElementById("numero_empleado")
  .addEventListener("input", function () {
    if (this.value < 1) {
      Swal.fire({
        icon: "error",
        title: "Número inválido",
        text: "El número de empleado debe ser mayor a 0",
      });
      this.value = "";
    }
  });
