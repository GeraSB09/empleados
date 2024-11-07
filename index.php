<?php
require_once __DIR__ . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Registro de Empleados</title>
  <?php include path('@componentes'); ?>
  <link rel="stylesheet" href="<?php echo path('@global:css'); ?>" type="text/css">
</head>

<body class="bg-dark">
  <?php include path('@nav'); ?>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container mb-5">
      <div class="hero-content">
        <h1 class="hero-title">Gestión de Empleados</h1>
        <p class="hero-subtitle"></p>
        <a href="<?php echo path('@empleados/formulario_empleados.php'); ?>" class="btn btn-primary btn-hero">
          Registrar nuevo Empleado <i class="fas fa-arrow-right ms-2"></i>
        </a>
      </div>
    </div>


    <div class="container p-5">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="card-body p-4 text-center">
              <i class="fa-solid fa-users feature-icon"></i>
              <h3 class="feature-title">Empleados</h3>
              <p class="feature-text">Gestiona toda la información de tu personal en un solo lugar.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="card-body p-4 text-center">
              <i class="fas fa-building feature-icon"></i>
              <h3 class="feature-title">Departamentos</h3>
              <p class="feature-text">Organiza la estructura de tu empresa por áreas.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="card-body p-4 text-center">
              <i class="fas fa-briefcase feature-icon"></i>
              <h3 class="feature-title">Puestos</h3>
              <p class="feature-text">Administra los diferentes cargos y responsabilidades.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


</body>

</html>