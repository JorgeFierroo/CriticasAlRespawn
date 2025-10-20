<?php
/**
 * PÁGINA DE CONTACTO - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Página con formulario de contacto que guarda datos en BD
 * Autor: Críticas al Respawn
 * Fecha: 2025
 * 
 * CUMPLIMIENTO DE REQUERIMIENTOS:
 * - ✓ Página en PHP con extensión .php
 * - ✓ CSS en archivo externo (../assets/css/styles.css)
 * - ✓ JavaScript en archivo externo (../assets/js/script.js)
 * - ✓ Imágenes en carpeta ../assets/imagenes
 * - ✓ Conexión BD en archivo independiente (../includes/conex.php)
 * - ✓ Header y Footer reutilizables
 */

// Incluir archivo de conexión a base de datos
require_once '../includes/conex.php';

// Configurar variables para el header
$page_title = 'Contacto - Críticas al Respawn | Formulario de Contacto';
$page_description = 'Formulario de contacto - Críticas al Respawn. Envíanos tus sugerencias, solicita reseñas o colabora con nosotros.';
$page_keywords = 'contacto, formulario, sugerencias, reseñas, colaboración, gaming';
$active_page = 'contacto';

// Variables para manejo de mensajes
$mensaje_exito = '';
$mensaje_error = '';

/**
 * PROCESAMIENTO DEL FORMULARIO DE CONTACTO
 * 
 * DESCRIPCIÓN: Procesa los datos enviados por POST desde el formulario
 * FUNCIONAMIENTO:
 * 1. Verifica que la petición sea POST
 * 2. Valida y sanitiza los datos recibidos
 * 3. Inserta los datos en la base de datos
 * 4. Muestra mensaje de confirmación o error
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitizar y validar datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    
    // Array para almacenar errores de validación
    $errores = [];
    
    // Validación de campos obligatorios
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    } elseif (strlen($nombre) < 2) {
        $errores[] = "El nombre debe tener al menos 2 caracteres";
    }
    
    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no tiene un formato válido";
    }
    
    if (empty($asunto)) {
        $errores[] = "Debe seleccionar un asunto";
    }
    
    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio";
    } elseif (strlen($mensaje) < 10) {
        $errores[] = "El mensaje debe tener al menos 10 caracteres";
    }
    
    // Si no hay errores, procesar el formulario (adaptado a MySQLi)
    if (empty($errores)) {
        
        // Escapar datos para prevenir inyección SQL
        $nombre = $conexion->real_escape_string($nombre);
        $email = $conexion->real_escape_string($email);
        $asunto = $conexion->real_escape_string($asunto);
        $mensaje = $conexion->real_escape_string($mensaje);
        
        // Insertar en la base de datos usando MySQLi
        $sql = "INSERT INTO contactos (nombre, email, asunto, mensaje, fecha_envio) VALUES ('$nombre', '$email', '$asunto', '$mensaje', NOW())";
        
        if ($conexion->query($sql)) {
            $mensaje_exito = "¡Gracias $nombre! Tu mensaje ha sido enviado correctamente. Te responderemos pronto a $email.";
            
            // Limpiar variables para resetear el formulario
            $nombre = $email = $asunto = $mensaje = '';
            
        } else {
            $mensaje_error = "Error al enviar el mensaje: " . $conexion->error;
        }
        
    } else {
        // Si hay errores de validación, mostrarlos
        $mensaje_error = "Por favor, corrige los siguientes errores:<br>" . implode("<br>", $errores);
    }
}

// Incluir header reutilizable
include '../includes/header.php';
?>
    
        <!-- Sección de contacto -->
        <section class="seccion">
            <h1><b>Contacto</b></h1>
            <p>¿Tienes alguna <i>pregunta</i>, <i>sugerencia</i> o quieres colaborar con nosotros?<br>
            ¡Escríbenos!</p>
            
            <?php 
            /**
             * MOSTRAR MENSAJES DE FEEDBACK
             * 
             * DESCRIPCIÓN: Muestra mensajes de éxito o error según el resultado del procesamiento
             * FUNCIONAMIENTO:
             * 1. Verifica si hay mensajes para mostrar
             * 2. Aplica clases CSS apropiadas para el estilo
             * 3. Muestra el mensaje con formato HTML seguro
             */
            if (!empty($mensaje_exito)): ?>
                <div class="mensaje-exito" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #c3e6cb;">
                    <?php echo htmlspecialchars($mensaje_exito); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($mensaje_error)): ?>
                <div class="mensaje-error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #f5c6cb;">
                    <?php echo $mensaje_error; // Ya contiene HTML seguro ?>
                </div>
            <?php endif; ?>
            
            <!-- Información de contacto -->
            <div class="info-contacto">
                <div class="elemento-contacto">
                    <h3>Email</h3>
                    <p>contacto@criticasalrespawn.com</p>
                </div>
                <div class="elemento-contacto">
                    <h3>Redes Sociales</h3>
                    <p>@CriticasAlRespawn</p>
                </div>
                <div class="elemento-contacto">
                    <h3>Discord</h3>
                    <p>CriticasAlRespawn#1234</p>
                </div>
            </div>

            <!-- REQUERIMIENTO: Formulario de contacto -->
            <div class="contenedor-formulario-contacto">
                <h2>Envíanos un mensaje</h2>
                
                <!-- REQUERIMIENTO: Etiqueta <form> con validación HTML5 y procesamiento PHP -->
                <form id="formularioContacto" class="formulario-contacto" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    
                    <!-- REQUERIMIENTO: Campos del formulario con validación HTML5 (required) -->
                    <div class="grupo-formulario">
                        <label for="nombre">Nombre:</label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               required 
                               minlength="2"
                               maxlength="100"
                               value="<?php echo htmlspecialchars($nombre ?? ''); ?>"
                               placeholder="Tu nombre completo">
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="email">Email:</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               maxlength="150"
                               value="<?php echo htmlspecialchars($email ?? ''); ?>"
                               placeholder="tu@email.com">
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="asunto">Asunto:</label>
                        <select id="asunto" name="asunto" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="reseña" <?php echo (isset($asunto) && $asunto === 'reseña') ? 'selected' : ''; ?>>Solicitar reseña</option>
                            <option value="colaboracion" <?php echo (isset($asunto) && $asunto === 'colaboracion') ? 'selected' : ''; ?>>Colaboración</option>
                            <option value="sugerencia" <?php echo (isset($asunto) && $asunto === 'sugerencia') ? 'selected' : ''; ?>>Sugerencia</option>
                            <option value="reporte" <?php echo (isset($asunto) && $asunto === 'reporte') ? 'selected' : ''; ?>>Reportar problema</option>
                            <option value="otro" <?php echo (isset($asunto) && $asunto === 'otro') ? 'selected' : ''; ?>>Otro</option>
                        </select>
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="mensaje">Mensaje:</label>
                        <textarea id="mensaje" 
                                  name="mensaje" 
                                  rows="6" 
                                  required 
                                  minlength="10"
                                  maxlength="1000"
                                  placeholder="Escribe tu mensaje aquí..."><?php echo htmlspecialchars($mensaje ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="boton-enviar">Enviar Mensaje</button>
                </form>
            </div>

            <!-- Información adicional -->
            <div class="contacto-extra">
                <h3>¿Por qué contactarnos?</h3>
                <div class="razones-contacto">
                    <div class="elemento-razon">
                        <h4>Solicitar Reseña</h4>
                        <p>¿Tienes un juego que te gustaría que reseñemos? Cuéntanos sobre él.</p>
                    </div>
                    <div class="elemento-razon">
                        <h4>Colaboración</h4>
                        <p>¿Eres desarrollador o tienes un proyecto interesante? Hablemos.</p>
                    </div>
                    <div class="elemento-razon">
                        <h4>Sugerencias</h4>
                        <p>¿Cómo podemos mejorar nuestro contenido? Tu opinión es importante.</p>
                    </div>
                </div>
            </div>
        </section>

<?php
// Incluir footer reutilizable
include '../includes/footer.php';
?>