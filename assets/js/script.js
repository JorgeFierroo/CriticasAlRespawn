/**
 * ARCHIVO JAVASCRIPT SIMPLE - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Funcionalidades básicas del sitio
 * Autor: Críticas al Respawn
 * Fecha: 2025
 */

/**
 * EVENTO PRINCIPAL: DOMContentLoaded
 */
document.addEventListener('DOMContentLoaded', function () {
    console.log('🚀 JavaScript cargado');
    
    // Inicializar funcionalidades básicas
    inicializarNavegacionSuave();
    inicializarEfectosBotones();
    inicializarFormularioContacto();
    inicializarFiltrosOpiniones();
});

/**
 * FUNCIÓN: inicializarNavegacionSuave
 * USO DE 'this': Se refiere al enlace clickeado
 */
function inicializarNavegacionSuave() {
    console.log('🔗 Inicializando navegación suave');
    
    const enlaces = document.querySelectorAll('a[href^="#"]');
    
    enlaces.forEach(function (enlace) {
        enlace.addEventListener('click', function (evento) {
            evento.preventDefault();
            console.log('Click en enlace - this:', this);
            
            const href = this.getAttribute('href');
            const elemento = document.querySelector(href);
            
            if (elemento) {
                elemento.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

/**
 * FUNCIÓN: inicializarEfectosBotones
 * USO DE 'this': Se refiere al botón con hover/click
 */
function inicializarEfectosBotones() {
    console.log('✨ Inicializando efectos de botones');
    
    const botones = document.querySelectorAll('button, .boton-enviar, .boton-contacto');
    
    botones.forEach(function (boton) {
        boton.addEventListener('mouseenter', function () {
            console.log('Hover en botón - this:', this);
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s';
        });
        
        boton.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1)';
        });
    });
}

/**
 * FUNCIÓN: inicializarFormularioContacto
 * USO DE 'this': Se refiere al formulario enviado
 */
function inicializarFormularioContacto() {
    console.log('📝 Inicializando formulario');
    
    const formulario = document.getElementById('formularioContacto');
    
    if (formulario) {
        formulario.addEventListener('submit', function (evento) {
            evento.preventDefault();
            console.log('Formulario enviado - this:', this);
            
            const datos = new FormData(this);
            const nombre = datos.get('nombre');
            
            alert(`¡Gracias ${nombre}! Mensaje enviado.`);
            this.reset();
        });
    }
}

/**
 * FUNCIÓN: inicializarFiltrosOpiniones
 * USO DE 'this': Se refiere al select de filtros
 */
function inicializarFiltrosOpiniones() {
    console.log('🔍 Inicializando filtros');
    
    const selectFiltro = document.getElementById('filtroOpiniones');
    
    if (selectFiltro) {
        selectFiltro.addEventListener('change', function () {
            console.log('Filtro cambiado - this:', this);
            filtrarOpiniones(this.value);
        });
        
        // Cargar todas al inicio
        filtrarOpiniones('todas');
    }
}

/**
 * FUNCIÓN: filtrarOpiniones
 * Hace FETCH para obtener opiniones filtradas
 */
function filtrarOpiniones(filtro) {
    console.log('🚀 Filtrando:', filtro);
    
    const contenedor = document.getElementById('contenedorOpiniones');
    if (contenedor) {
        contenedor.innerHTML = '<p>Cargando...</p>';
    }
    
    fetch(`filtrar_opiniones.php?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);
            mostrarOpiniones(data);
        })
        .catch(error => {
            console.log('Error:', error);
            if (contenedor) {
                contenedor.innerHTML = '<p>Error al cargar.</p>';
            }
        });
}

/**
 * FUNCIÓN: mostrarOpiniones
 * Muestra las opiniones en el contenedor
 */
function mostrarOpiniones(data) {
    console.log('🎨 Mostrando opiniones');
    
    const contenedor = document.getElementById('contenedorOpiniones');
    if (!contenedor) return;
    
    if (data.success && data.opiniones && data.opiniones.length > 0) {
        let html = `<h3>${data.total} opiniones</h3><div class="grilla-reseñas">`;
        
        data.opiniones.forEach(opinion => {
            const estrellas = '★'.repeat(opinion.estrellas) + '☆'.repeat(5 - opinion.estrellas);
            html += `
                <article class="tarjeta-reseña">
                    <h3><b>${opinion.juego}</b></h3>
                    <p>${opinion.opinion}</p>
                    <div class="calificacion">${estrellas}</div>
                    <small>Por: ${opinion.nombre} - ${opinion.fecha}</small>
                </article>
            `;
        });
        
        html += '</div>';
        contenedor.innerHTML = html;
    } else {
        contenedor.innerHTML = '<p>No hay opiniones.</p>';
    }
}

console.log('📄 Script cargado completamente');