 // Configurar campo edad como solo lectura
 document.getElementById('edad').readOnly = true;

 // Calcular edad automáticamente y validar que sea 18 o mayor
 document.getElementById('fecha_nacimiento').addEventListener('change', function() {
     const fechaNac = new Date(this.value);
     const hoy = new Date();
     let edad = hoy.getFullYear() - fechaNac.getFullYear();
     const mes = hoy.getMonth() - fechaNac.getMonth();

     if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
         edad--;
     }

     document.getElementById('edad').value = edad;

     if (edad < 18) {
         Swal.fire({
             icon: 'error',
             title: 'Edad no permitida',
             text: 'El empleado debe tener al menos 18 años'
         });
         this.value = '';
         document.getElementById('edad').value = '';
     }
 });