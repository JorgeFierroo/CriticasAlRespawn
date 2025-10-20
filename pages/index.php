<?php
/**
 * PÁGINA PRINCIPAL - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Página principal del sitio web de reseñas de videojuegos
 * Autor: Críticas al Respawn
 * Fecha: 2025
 * 
 * CUMPLIMIENTO DE REQUERIMIENTOS:
 * - ✓ Página principal se llama index.php
 * - ✓ CSS en archivo externo (../assets/css/styles.css)
 * - ✓ JavaScript en archivo externo (../assets/js/script.js)
 * - ✓ Imágenes en carpeta ../assets/imagenes
 * - ✓ Conexión BD en archivo independiente (../includes/conex.php)
 * - ✓ Header y Footer reutilizables
 */

// Incluir archivo de conexión a base de datos
require_once '../includes/conex.php';

// Configurar variables para el header
$page_title = 'Críticas al Respawn - Reseñas de Videojuegos | Gaming News';
$page_description = 'Tu fuente confiable de reseñas de videojuegos. Descubre los mejores juegos, noticias gaming y rankings actualizados.';
$page_keywords = 'reseñas videojuegos, gaming, noticias juegos, ranking videojuegos, críticas juegos';
$active_page = 'inicio';

// Obtener datos dinámicos de la base de datos (adaptado de lab03)
$opiniones = [];
$noticias = [];

// Consulta para obtener las últimas opiniones (basado en lab03)
$sql_opiniones = "SELECT * FROM opiniones ORDER BY fecha DESC LIMIT 6";
$resultado_opiniones = $conexion->query($sql_opiniones);

if ($resultado_opiniones && $resultado_opiniones->num_rows > 0) {
    while($fila = $resultado_opiniones->fetch_assoc()) {
        $opiniones[] = $fila;
    }
}

// Consulta para obtener las últimas noticias
$sql_noticias = "SELECT * FROM noticias WHERE activo = 1 ORDER BY fecha_publicacion DESC LIMIT 3";
$resultado_noticias = $conexion->query($sql_noticias);

if ($resultado_noticias && $resultado_noticias->num_rows > 0) {
    while($fila = $resultado_noticias->fetch_assoc()) {
        $noticias[] = $fila;
    }
}

// Incluir header reutilizable
include '../includes/header.php';
?>

        <!-- REQUERIMIENTO: Etiqueta semántica <section> -->
        <section id="inicio" class="seccion">
            <!-- REQUERIMIENTO: Etiquetas <h1>, <p>, <b>, <i>, <br> -->
            <h1>Bienvenido a <b>Críticas al Respawn</b></h1>
            <p>Tu fuente <i>confiable</i> de reseñas de videojuegos<br>
                Descubre los mejores títulos y mantente actualizado con las últimas novedades del mundo gaming.</p>
        </section>

        <!-- Sección Reseñas -->
        <section id="reseñas" class="seccion">
            <h2>Últimas Reseñas</h2>
            <div class="grilla-reseñas">
                <?php 
                /**
                 * INTEGRACIÓN CON BASE DE DATOS - OPINIONES
                 * Muestra opiniones dinámicas desde la BD (basado en lab03)
                 */
                if (!empty($opiniones)): 
                    // Mostrar solo las primeras 3 opiniones para la sección de reseñas
                    $opiniones_mostrar = array_slice($opiniones, 0, 3);
                    foreach($opiniones_mostrar as $opinion): ?>
                        <!-- REQUERIMIENTO: Etiqueta semántica <article> -->
                        <article class="tarjeta-reseña">
                            <h3><b><?php echo htmlspecialchars($opinion['juego']); ?></b></h3>
                            <p><?php echo htmlspecialchars($opinion['opinion']); ?></p>
                            <div class="calificacion"><?php echo str_repeat('★', $opinion['estrellas']) . str_repeat('☆', 5-$opinion['estrellas']); ?></div>
                            <small>Por: <?php echo htmlspecialchars($opinion['nombre']); ?></small>
                        </article>
                    <?php endforeach;
                else: 
                    // Datos estáticos como fallback ?>
                    <article class="tarjeta-reseña">
                        <h3><b>Cyberpunk 2077</b></h3>
                        <p>Un mundo abierto <i>impresionante</i> con una narrativa envolvente.</p>
                        <div class="calificacion">★★★★☆</div>
                    </article>
                    <article class="tarjeta-reseña">
                        <h3><b>Elden Ring</b></h3>
                        <p>Una <i>obra maestra</i> de FromSoftware que redefine el género souls.</p>
                        <div class="calificacion">★★★★★</div>
                    </article>
                    <article class="tarjeta-reseña">
                        <h3><b>God of War Ragnarök</b></h3>
                        <p>Una secuela <i>épica</i> que supera todas las expectativas.</p>
                        <div class="calificacion">★★★★★</div>
                    </article>
                <?php endif; ?>
            </div>
            
            <h3 style="margin-top:32px;">¿Cómo enviar tu propia reseña?</h3>
            <!-- REQUERIMIENTO: Etiquetas <ol> y <li> -->
            <ol style="max-width:500px;margin:16px auto 0 auto;text-align:left;">
                <li>Ingresa a la sección de <a href="agregar_opinion.php">Agregar Opinión</a>.</li>
                <li>Completa el formulario con tus datos y tu reseña.</li>
                <li>Haz clic en "Publicar Opinión".</li>
                <li>¡Listo! Tu reseña será visible inmediatamente.</li>
            </ol>
        </section>

        <!-- Sección Noticias -->
        <section id="noticias" class="seccion">
            <h2>Noticias Gaming</h2>
            <div class="lista-noticias">
                <?php 
                /**
                 * INTEGRACIÓN CON BASE DE DATOS - NOTICIAS
                 * Muestra noticias dinámicas desde la BD o datos estáticos como fallback
                 */
                if (!empty($noticias)): 
                    foreach($noticias as $noticia): ?>
                        <article class="elemento-noticia">
                            <h3><b><?php echo htmlspecialchars($noticia['titulo']); ?></b></h3>
                            <p><?php echo htmlspecialchars($noticia['contenido']); ?></p>
                            <time class="fecha"><?php echo date('d \d\e F, Y', strtotime($noticia['fecha_publicacion'])); ?></time>
                        </article>
                    <?php endforeach;
                else: 
                    // Datos estáticos como fallback ?>
                    <article class="elemento-noticia">
                        <h3><b>Nuevo trailer de The Legend of Zelda: Tears of the Kingdom</b></h3>
                        <p>Nintendo revela <i>nuevas mecánicas</i> y detalles del próximo juego.</p>
                        <time class="fecha">15 de Marzo, 2024</time>
                    </article>
                    <article class="elemento-noticia">
                        <h3><b>PlayStation 5 Pro confirmado para 2024</b></h3>
                        <p>Sony anuncia <i>oficialmente</i> la nueva consola con mejoras significativas.</p>
                        <time class="fecha">12 de Marzo, 2024</time>
                    </article>
                    <article class="elemento-noticia">
                        <h3><b>Xbox Game Pass añade 10 nuevos juegos</b></h3>
                        <p>Microsoft expande su catálogo con títulos <i>indie</i> y <i>AAA</i>.</p>
                        <time class="fecha">10 de Marzo, 2024</time>
                    </article>
                <?php endif; ?>
            </div>
        </section>

        <!-- REQUERIMIENTO: Etiqueta <hr> -->
        <hr style="margin: 40px auto; border: none; border-top: 2px solid #A08AC0; width: 80%;">

        <!-- Sección Ranking -->
        <section id="ranking" class="seccion">
            <h2>Top 10 Juegos por Categoría 2024</h2>
            <div style="overflow-x:auto;">
                <!-- REQUERIMIENTO: Etiqueta <table> (tabla de rankings) -->
                <table class="tabla-comparativa" border="1" cellpadding="6" cellspacing="0"
                    style="width:100%; background:#fff; border-radius:10px; border-collapse:collapse;">
                    <thead style="background:#2d2573; color:#fff;">
                        <tr>
                            <th>Puesto</th>
                            <th>RPG</th>
                            <th>Acción</th>
                            <th>Aventura</th>
                            <th>Deportes</th>
                            <th>Carreras</th>
                            <th>Estrategia</th>
                            <th>Simulación</th>
                            <th>Indie</th>
                            <th>Horror</th>
                            <th>Multijugador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        /**
                         * DATOS ESTÁTICOS DE RANKING
                         * En una implementación completa, estos datos vendrían de la BD
                         */
                        $ranking_data = [
                            [1, "Baldur's Gate 3 (9.5)", "Spider-Man 2 (9.4)", "The Legend of Zelda: TotK (9.7)", "FIFA 25 (9.1)", "Forza Motorsport (9.3)", "Age of Empires IV (9.2)", "The Sims 5 (9.0)", "Hollow Knight: Silksong (9.6)", "Alan Wake 2 (9.2)", "Call of Duty: MW3 (9.0)"],
                            [2, "Starfield (9.3)", "God of War Ragnarök (9.3)", "Uncharted: Legacy (9.4)", "NBA 2K25 (9.0)", "Gran Turismo 8 (9.1)", "Civilization VII (9.0)", "Flight Simulator 2024 (8.9)", "Celeste 2 (9.4)", "Resident Evil 9 (9.1)", "Fortnite (8.9)"],
                            [3, "Hogwarts Legacy (9.0)", "Devil May Cry 6 (9.0)", "Life is Strange 3 (9.2)", "eFootball 2025 (8.8)", "Mario Kart 9 (9.0)", "Starcraft III (8.9)", "Planet Zoo 2 (8.8)", "Stardew Valley 2 (9.2)", "Silent Hill: Return (8.9)", "Apex Legends (8.8)"]
                        ];
                        
                        foreach($ranking_data as $fila): ?>
                            <tr>
                                <?php foreach($fila as $celda): ?>
                                    <td><?php echo htmlspecialchars($celda); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p style="margin-top:10px; font-size:0.95em; color:#555;">*Datos ficticios y categorías de ejemplo para
                fines comparativos.</p>
        </section>

        <!-- Sección Contacto -->
        <section id="contacto" class="seccion">
            <h2>Contacto</h2>
            <p>¿Quieres ponerte en contacto con nosotros? Visita nuestra página de contacto.</p>

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

            <!-- Botón para ir al formulario -->
            <div class="llamada-contacto">
                <a href="contacto.php" class="boton-contacto">Ir al Formulario de Contacto</a>
            </div>
        </section>

<?php
// Incluir footer reutilizable
include '../includes/footer.php';
?>