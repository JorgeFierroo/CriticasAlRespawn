    </main>

    <!-- REQUERIMIENTO: Etiqueta semántica <footer> -->
    <footer class="pie-pagina">
        <div class="contenedor-pie">
            <div class="seccion-pie">
                <h3>Críticas al Respawn</h3>
                <p>Tu fuente confiable de reseñas de videojuegos. Descubre los mejores juegos y mantente al día con las
                    últimas noticias del mundo gaming.</p>
            </div>

            <div class="seccion-pie">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="index.php#reseñas">Reseñas</a></li>
                    <li><a href="index.php#noticias">Noticias</a></li>
                    <li><a href="index.php#ranking">Ranking</a></li>
                    <li><a href="agregar_opinion.php">Agregar Opinión</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>

            <div class="seccion-pie">
                <h4>Redes Sociales</h4>
                <div class="enlaces-sociales">
                    <a href="#" class="enlace-social">Email</a>
                    <a href="#" class="enlace-social">Twitter</a>
                    <a href="#" class="enlace-social">Facebook</a>
                    <a href="#" class="enlace-social">Instagram</a>
                    <a href="#" class="enlace-social">Discord</a>
                </div>
            </div>

            <div class="seccion-pie">
                <h4>Contacto</h4>
                <p>contacto@criticasalrespawn.com</p>
                <p>CriticasAlRespawn#1234</p>
                <p>@CriticasAlRespawn</p>
            </div>
        </div>

        <div class="pie-inferior">
            <p>&copy; 2025 Críticas al Respawn. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- REQUERIMIENTO: JavaScript en archivo externo -->
    <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
/**
 * CERRAR CONEXIÓN A BASE DE DATOS
 * 
 * DESCRIPCIÓN: Cierra la conexión MySQLi si existe
 * NOTA: Solo se ejecuta si la variable $conexion está definida
 */
if (isset($conexion) && $conexion instanceof mysqli) {
    $conexion->close();
}
?>