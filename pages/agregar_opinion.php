<?php
/**
 * PÁGINA PARA AGREGAR OPINIONES - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Formulario para que los usuarios agreguen sus opiniones de juegos
 * Basado en la implementación del proyecto lab03
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
 * - ✓ Implementación basada en lab03 existente
 */

// Incluir archivo de conexión a base de datos
require_once '../includes/conex.php';

// Configurar variables para el header
$page_title = 'Agregar Opinión - Críticas al Respawn';
$page_description = 'Agregar opinión - Críticas al Respawn. Comparte tu opinión sobre videojuegos.';
$page_keywords = 'opinión, videojuegos, reseña, calificación, gaming';
$active_page = 'agregar_opinion';

// Variables para manejo de mensajes
$mensaje_exito = '';
$mensaje_error = '';

/**
 * PROCESAMIENTO DEL FORMULARIO DE OPINIONES
 * 
 * DESCRIPCIÓN: Procesa los datos enviados por POST (basado en lab03)
 * FUNCIONAMIENTO:
 * 1. Verifica que la petición sea POST
 * 2. Valida y sanitiza los datos recibidos
 * 3. Inserta los datos en la base de datos usando MySQLi
 * 4. Muestra mensaje de confirmación o error
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recibir datos del formulario (implementación de lab03)
    $juego = trim($_POST['juego'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $estrellas = intval($_POST['estrellas'] ?? 0);
    $opinion = trim($_POST['opinion'] ?? '');
    
    // Array para almacenar errores de validación
    $errores = [];
    
    // Validación de campos obligatorios
    if (empty($juego)) {
        $errores[] = "El nombre del juego es obligatorio";
    }
    
    if (empty($nombre)) {
        $errores[] = "Tu nombre es obligatorio";
    }
    
    if ($estrellas < 1 || $estrellas > 5) {
        $errores[] = "Debes seleccionar entre 1 y 5 estrellas";
    }
    
    if (empty($opinion)) {
        $errores[] = "La opinión es obligatoria";
    } elseif (strlen($opinion) < 10) {
        $errores[] = "La opinión debe tener al menos 10 caracteres";
    }
    
    // Si no hay errores, procesar el formulario (basado en lab03)
    if (empty($errores)) {
        
        // Escapar datos para prevenir inyección SQL
        $juego = $conexion->real_escape_string($juego);
        $nombre = $conexion->real_escape_string($nombre);
        $opinion = $conexion->real_escape_string($opinion);
        
        // Insertar en la base de datos (implementación de lab03)
        $sql = "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('$juego', '$nombre', '$estrellas', '$opinion')";
        
        if ($conexion->query($sql)) {
            $mensaje_exito = "¡Gracias $nombre! Tu opinión sobre '$juego' ha sido agregada correctamente.";
            
            // Limpiar variables para resetear el formulario
            $juego = $nombre = $opinion = '';
            $estrellas = 0;
            
        } else {
            $mensaje_error = "Error en la inserción: " . $conexion->error;
        }
        
    } else {
        // Si hay errores de validación, mostrarlos
        $mensaje_error = "Por favor, corrige los siguientes errores:<br>" . implode("<br>", $errores);
    }
}

// Incluir header reutilizable
include '../includes/header.php';
?>
        
        <section class="seccion">
            <h1><b>Agregar tu Opinión</b></h1>
            <p>¿Has jugado algún videojuego recientemente? <i>¡Comparte tu experiencia!</i><br>
            Tu opinión ayuda a otros gamers a descubrir nuevos títulos.</p>
            
            <?php 
            /**
             * MOSTRAR MENSAJES DE FEEDBACK
             * 
             * DESCRIPCIÓN: Muestra mensajes de éxito o error según el resultado del procesamiento
             */
            if (!empty($mensaje_exito)): ?>
                <div class="mensaje-exito" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #c3e6cb;">
                    <?php echo htmlspecialchars($mensaje_exito); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($mensaje_error)): ?>
                <div class="mensaje-error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #f5c6cb;">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Formulario para agregar opinión (basado en lab03) -->
            <div class="contenedor-formulario-contacto">
                <h2>Califica un Videojuego</h2>
                
                <form id="formularioOpinion" class="formulario-contacto" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    
                    <div class="grupo-formulario">
                        <label for="juego">Nombre del Juego:</label>
                        <input type="text" 
                               id="juego" 
                               name="juego" 
                               required 
                               maxlength="255"
                               value="<?php echo htmlspecialchars($juego ?? ''); ?>"
                               placeholder="Ej: The Legend of Zelda, Cyberpunk 2077, etc.">
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="nombre">Tu Nombre:</label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               required 
                               maxlength="255"
                               value="<?php echo htmlspecialchars($nombre ?? ''); ?>"
                               placeholder="Tu nombre o nickname">
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="estrellas">Calificación:</label>
                        <select id="estrellas" name="estrellas" required>
                            <option value="">Selecciona tu calificación</option>
                            <option value="1" <?php echo (isset($estrellas) && $estrellas == 1) ? 'selected' : ''; ?>>⭐ (1 estrella - Muy malo)</option>
                            <option value="2" <?php echo (isset($estrellas) && $estrellas == 2) ? 'selected' : ''; ?>>⭐⭐ (2 estrellas - Malo)</option>
                            <option value="3" <?php echo (isset($estrellas) && $estrellas == 3) ? 'selected' : ''; ?>>⭐⭐⭐ (3 estrellas - Regular)</option>
                            <option value="4" <?php echo (isset($estrellas) && $estrellas == 4) ? 'selected' : ''; ?>>⭐⭐⭐⭐ (4 estrellas - Bueno)</option>
                            <option value="5" <?php echo (isset($estrellas) && $estrellas == 5) ? 'selected' : ''; ?>>⭐⭐⭐⭐⭐ (5 estrellas - Excelente)</option>
                        </select>
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="opinion">Tu Opinión:</label>
                        <textarea id="opinion" 
                                  name="opinion" 
                                  rows="6" 
                                  required 
                                  minlength="10"
                                  maxlength="1000"
                                  placeholder="Comparte tu experiencia con este juego. ¿Qué te gustó? ¿Qué no te gustó? ¿Lo recomendarías?"><?php echo htmlspecialchars($opinion ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="boton-enviar">Publicar Opinión</button>
                </form>
            </div>
            
            <!-- Filtros de opiniones con FETCH -->
            <div class="filtros-opiniones" style="margin-top: 40px;">
                <h2>Opiniones de la Comunidad</h2>
                
                <div class="contenedor-filtros" style="margin-bottom: 20px;">
                    <label for="filtroOpiniones" style="font-weight: bold; margin-right: 10px;">Filtrar por:</label>
                    <select id="filtroOpiniones" style="padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="todas">📋 Todas las opiniones</option>
                        <option value="5estrellas">⭐⭐⭐⭐⭐ Solo 5 estrellas</option>
                        <option value="4mas">⭐⭐⭐⭐ 4 estrellas o más</option>
                        <option value="3menos">⭐⭐⭐ 3 estrellas o menos</option>
                        <option value="recientes">🕒 Más recientes (5)</option>
                        <option value="antiguas">📅 Más antiguas (5)</option>
                    </select>
                </div>
                
                <!-- Contenedor donde se mostrarán las opiniones filtradas -->
                <div id="contenedorOpiniones">
                    <p>Selecciona un filtro para ver las opiniones...</p>
                </div>
            </div>
            
            <!-- Mostrar todas las opiniones (versión original como respaldo) -->
            <div class="todas-opiniones-respaldo" style="margin-top: 40px; display: none;">
                <h2>Todas las Opiniones (Respaldo)</h2>
                
                <?php
                /**
                 * LISTAR TODAS LAS OPINIONES
                 * 
                 * DESCRIPCIÓN: Muestra todas las opiniones de la base de datos (implementación de lab03)
                 * FUNCIONAMIENTO:
                 * 1. Consulta todas las opiniones ordenadas por fecha
                 * 2. Las muestra en formato de tarjetas
                 * 3. Incluye nombre, juego, calificación y opinión
                 */
                
                // Listar todos los elementos de la tabla (implementación de lab03)
                $sql = "SELECT * FROM opiniones ORDER BY fecha DESC";
                $resultado = $conexion->query($sql);
                
                if ($resultado && $resultado->num_rows > 0) {
                    echo '<div class="grilla-reseñas">';
                    
                    while($fila = $resultado->fetch_assoc()) {
                        echo '<article class="tarjeta-reseña">';
                        echo '<h3><b>' . htmlspecialchars($fila["juego"]) . '</b></h3>';
                        echo '<p>' . htmlspecialchars($fila["opinion"]) . '</p>';
                        echo '<div class="calificacion">' . str_repeat('★', $fila["estrellas"]) . str_repeat('☆', 5-$fila["estrellas"]) . '</div>';
                        echo '<small>Por: ' . htmlspecialchars($fila["nombre"]) . ' - ' . date('d/m/Y', strtotime($fila["fecha"])) . '</small>';
                        echo '</article>';
                    }
                    
                    echo '</div>';
                } else {
                    echo '<p>Aún no hay opiniones. ¡Sé el primero en compartir tu experiencia!</p>';
                }
                ?>
            </div>
        </section>

<?php
// Incluir footer reutilizable
include '../includes/footer.php';
?>