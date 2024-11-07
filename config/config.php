<?php
define('BASE_PATH', dirname(dirname(__FILE__)));
define('URL_BASE', 'http://localhost/empleados');

// Definir alias comunes
define('ALIASES', [
    // Rutas generales 
    '@includes' => BASE_PATH . '/includes',
    '@empleados' => URL_BASE . '/empleados',
    '@departamentos' => URL_BASE . '/departamentos',
    '@puestos' => URL_BASE . '/puestos',
    '@carreras' => URL_BASE . '/carreras',
    '@js' => URL_BASE . '/assets/js',
    '@css' => URL_BASE . '/assets/css',
    
    // Rutas archivos especificos
    '@acercade' => URL_BASE . '/acercade.php',
    '@index' => URL_BASE . '/index.php',
    '@componentes' => BASE_PATH . '/includes/componentes.php',
    '@conexion' => BASE_PATH . '/includes/conexion.php',
    '@nav' => BASE_PATH . '/includes/nav.php',
    '@side-nav' => BASE_PATH . '/includes/side-nav.php',
    '@global:css' => URL_BASE . '/assets/css/global.css',
    '@custom:css' => URL_BASE . '/assets/css/custom.css',
    '@image:css' => URL_BASE . '/assets/css/image.empleados.css',
 
]);

// Función helper para usar los alias
function path($ruta)
{
    foreach (ALIASES as $alias => $valor) {
        if (strpos($ruta, $alias) === 0) {
            return str_replace($alias, $valor, $ruta);
        }
    }
    return $ruta;
}
