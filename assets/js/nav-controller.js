document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const sideNav = document.querySelector('.side-nav');
    const navs = [navbar, sideNav];
    let timeoutId;
    let isHovering = false;

    function hideNavs() {
        if (!isHovering) {
            navs.forEach(nav => nav.classList.add('hide'));
        }
    }

    function showNavs() {
        navs.forEach(nav => nav.classList.remove('hide'));
        // Solo reiniciar el temporizador si no está en hover
        if (!isHovering) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(hideNavs, 3000);
        }
    }

    // Mostrar los navs inicialmente
    showNavs();

    // Eventos para mostrar/ocultar
    navs.forEach(nav => {
        nav.addEventListener('mouseenter', () => {
            isHovering = true;
            showNavs();
            clearTimeout(timeoutId); // Limpiar el temporizador en hover
        });

        nav.addEventListener('mouseleave', () => {
            isHovering = false;
            timeoutId = setTimeout(hideNavs, 3000);
        });
    });

    document.addEventListener('mousemove', function(e) {
        const isNearTop = e.clientY < 100;
        const isNearLeft = e.clientX < 100;

        if (isNearTop || isNearLeft) {
            showNavs();
        }
    });
}); 