<?php
require_once __DIR__ . '/../config/config.php';
?>
<link rel="stylesheet" href="<?php echo path('@css/nav.css'); ?>">


<!-- Navbar principal -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="empleadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-users text-primary me-1"></i> Empleados
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="empleadosDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@empleados/formulario_empleados.php'); ?>">
                <i class="fa-solid fa-user-plus text-primary me-2"></i> Registro de Empleados
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@empleados/datos_empleados.php?estado=1&titulo=Empleados Activos'); ?>">
                <i class="fa-solid fa-user-check text-success me-2"></i> Empleados Activos
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="<?php echo path('@empleados/datos_empleados.php?estado=0&titulo=Empleados Inactivos'); ?>">
                <i class="fa-solid fa-user-xmark text-danger me-2"></i> Empleados Inactivos
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="departamentosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-building text-primary me-1"></i> Departamentos
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="departamentosDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@departamentos/formulario_departamentos.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nuevo Departamento
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@departamentos/datos_departamentos.php?estado=1&titulo=Departamentos Activos'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Departamentos Activos
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="<?php echo path('@departamentos/datos_departamentos.php?estado=0&titulo=Departamentos Inactivos'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Departamentos Inactivos
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="puestosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-briefcase text-primary me-1"></i> Puestos
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="puestosDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@puestos/formulario_puestos.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nuevo Puesto
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@puestos/datos_puestos.php?estado=1&titulo=Puestos Activos'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Puestos Activos
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="<?php echo path('@puestos/datos_puestos.php?estado=0&titulo=Puestos Inactivos'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Puestos Inactivos
              </a>
            </li>
          </ul>
        </li>

        <!-- Antigüedad -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="antiguedadDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-clock-rotate-left text-primary me-1"></i> Antigüedad
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="antiguedadDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@antiguedad/formulario_antiguedad.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nueva Antigüedad
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@antiguedad/datos_antiguedad.php?estado=1&titulo=Antigüedad Activa'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Antigüedad Activa
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@antiguedad/datos_antiguedad.php?estado=0&titulo=Antigüedad Inactiva'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Antigüedad Inactiva
              </a>
            </li>
          </ul>
        </li>

        <!-- Carrera -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="carreraDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-graduation-cap text-primary me-1"></i> Carreras
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="carreraDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@carrera/formulario_carrera.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nueva Carrera
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@carrera/datos_carrera.php?estado=1&titulo=Carreras Activas'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Carreras Activas
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@carrera/datos_carrera.php?estado=0&titulo=Carreras Inactivas'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Carreras Inactivas
              </a>
            </li>
          </ul>
        </li>

        <!-- Colonias -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="coloniasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-map-location-dot text-primary me-1"></i> Colonias
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="coloniasDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@colonias/formulario_colonias.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nueva Colonia
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@colonias/datos_colonias.php?estado=1&titulo=Colonias Activas'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Colonias Activas
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@colonias/datos_colonias.php?estado=0&titulo=Colonias Inactivas'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Colonias Inactivas
              </a>
            </li>
          </ul>
        </li>

        <!-- Domicilio -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="domicilioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-house-chimney text-primary me-1"></i> Domicilios
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="domicilioDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@domicilio/formulario_domicilio.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nuevo Domicilio
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@domicilio/datos_domicilio.php?estado=1&titulo=Domicilios Activos'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Domicilios Activos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@domicilio/datos_domicilio.php?estado=0&titulo=Domicilios Inactivos'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Domicilios Inactivos
              </a>
            </li>
          </ul>
        </li>

        <!-- Estados -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="estadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-map text-primary me-1"></i> Estados
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="estadosDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@estados/formulario_estados.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nuevo Estado
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@estados/datos_estados.php?estado=1&titulo=Estados Activos'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Estados Activos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@estados/datos_estados.php?estado=0&titulo=Estados Inactivos'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Estados Inactivos
              </a>
            </li>
          </ul>
        </li>

        <!-- Municipios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="municipiosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-city text-primary me-1"></i> Municipios
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="municipiosDropdown">
            <li>
              <a class="dropdown-item" href="<?php echo path('@municipios/formulario_municipios.php'); ?>">
                <i class="fa-solid fa-plus text-primary me-2"></i> Nuevo Municipio
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@municipios/datos_municipios.php?estado=1&titulo=Municipios Activos'); ?>">
                <i class="fa-solid fa-check text-success me-2"></i> Municipios Activos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo path('@municipios/datos_municipios.php?estado=0&titulo=Municipios Inactivos'); ?>">
                <i class="fa-solid fa-xmark text-danger me-2"></i> Municipios Inactivos
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Agregar el side-nav -->
<?php include path('@side-nav'); ?>

<!-- Agregar el script de navegación -->
<script src="<?php echo path('@js/nav-controller.js'); ?>"></script>
<!-- Termina el menú -->