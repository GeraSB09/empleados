
<!-- Nav Lateral -->
<nav class="side-nav">
    <ul class="nav-buttons">
        <li>
            <a href="<?php echo path('@index'); ?>" class="nav-btn" title="Inicio" aria-label="Ir a inicio">
                <i class="fa-solid fa-house text-primary"></i>
            </a>
        </li>
        <li>
            <a href="<?php echo path('@acercade'); ?>" class="nav-btn" title="Acerca de" aria-label="Ir a acerca de">
                <i class="fa-solid fa-circle-info text-primary"></i>
            </a>
        </li>
        <li>
            <button onclick="history.back()" class="nav-btn" title="Regresar" aria-label="Regresar a página anterior">
                <i class="fa-solid fa-arrow-left text-secondary"></i>
            </button>
        </li>
        <li>
            <button onclick="location.reload()" class="nav-btn" title="Recargar" aria-label="Recargar página">
                <i class="fa-solid fa-rotate-right text-secondary"></i>
            </button>
        </li>
    </ul>
</nav>
