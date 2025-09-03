// ===== NAVEGACIÓN SIMPLE =====
document.addEventListener('DOMContentLoaded', function() {
    // Navegación suave para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===== EVENTO 1: FORMULARIO DE CONTACTO =====
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Evita que se envíe el formulario
            
            // Muestra mensaje simple
            alert('¡Mensaje enviado! Te responderemos pronto.');
            
            // Limpia el formulario
            contactForm.reset();
        });
    }

    // ===== EVENTO 2: CAMBIO DE COLOR EN BOTONES =====
    const botones = document.querySelectorAll('.submit-btn, .contact-btn');
    
    botones.forEach(boton => {
        // Cuando pasas el mouse por encima
        boton.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        // Cuando quitas el mouse
        boton.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
