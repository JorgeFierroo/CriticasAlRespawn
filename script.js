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
    const mensajeEnviado = document.getElementById('mensajeEnviado');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Evita que se envíe el formulario
            
            // Obtiene los valores del formulario
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const asunto = document.getElementById('asunto').value;
            const mensaje = document.getElementById('mensaje').value;
            
            // Valida que todos los campos estén llenos
            if (nombre && email && asunto && mensaje) {
                // Simula el envío del formulario
                console.log('Formulario enviado:', { nombre, email, asunto, mensaje });
                
                // Oculta el formulario y muestra el mensaje de confirmación
                contactForm.style.display = 'none';
                mensajeEnviado.style.display = 'block';
                
                // Opcional: Limpia el formulario después de 3 segundos
                setTimeout(() => {
                    contactForm.reset();
                    contactForm.style.display = 'block';
                    mensajeEnviado.style.display = 'none';
                }, 3000);
            } else {
                alert('Por favor, completa todos los campos del formulario.');
            }
        });
    }

    // ===== EVENTO 2: CONTADOR DE CARACTERES EN TEXTAREA =====
    const textarea = document.getElementById('mensaje');
    
    if (textarea) {
        // Crea un contador de caracteres
        const contador = document.createElement('div');
        contador.className = 'contador-caracteres';
        contador.style.cssText = `
            text-align: right;
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        `;
        
        // Inserta el contador después del textarea
        textarea.parentNode.appendChild(contador);
        
        // Función para actualizar el contador
        function actualizarContador() {
            const longitud = textarea.value.length;
            const maximo = 500;
            contador.textContent = `${longitud}/${maximo} caracteres`;
            
            // Cambia el color si se acerca al límite
            if (longitud > maximo * 0.8) {
                contador.style.color = '#F6D60D';
            } else if (longitud > maximo * 0.9) {
                contador.style.color = '#ff6b6b';
            } else {
                contador.style.color = '#666';
            }
        }
        
        // Actualiza el contador cuando el usuario escribe
        textarea.addEventListener('input', actualizarContador);
        
        // Actualiza el contador al cargar la página
        actualizarContador();
    }
});
