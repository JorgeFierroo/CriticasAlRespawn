<?php
/**
 * HEADER REUTILIZABLE - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Header común para todas las páginas del sitio
 * Autor: Críticas al Respawn
 * Fecha: 2025
 * 
 * PARÁMETROS REQUERIDOS:
 * $page_title - Título de la página
 * $page_description - Descripción meta de la página
 * $page_keywords - Palabras clave meta
 * $active_page - Página activa para resaltar en navegación
 */

// Valores por defecto si no se definen
$page_title = $page_title ?? 'Críticas al Respawn - Reseñas de Videojuegos';
$page_description = $page_description ?? 'Tu fuente confiable de reseñas de videojuegos. Descubre los mejores juegos, noticias gaming y rankings actualizados.';
$page_keywords = $page_keywords ?? 'reseñas videojuegos, gaming, noticias juegos, ranking videojuegos, críticas juegos';
$active_page = $active_page ?? 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="author" content="Críticas al Respawn">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:type" content="website">
    
    <!-- REQUERIMIENTO: CSS en archivo externo -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    
    <!-- REQUERIMIENTO: Imágenes en carpeta assets/imagenes -->
    <link rel="icon" type="image/png" href="../assets/imagenes/logo-invert.png">
    
    <title><?php echo htmlspecialchars($page_title); ?></title>
</head>
<body>
    <!-- REQUERIMIENTO: Etiquetas semánticas <header> y <nav> -->
    <header>
        <nav class="barra-navegacion">
            <div class="contenedor-nav">
                <div class="logo-nav">
                    <!-- REQUERIMIENTO: Etiquetas semánticas <figure> y <figcaption> -->
                    <figure>
                        <!-- REQUERIMIENTO: Imágenes en carpeta assets/imagenes -->
                        <img src="../assets/imagenes/logo-invert.png" alt="Criticas al Respawn" class="imagen-logo">
                        <figcaption class="texto-logo">Críticas al Respawn</figcaption>
                    </figure>
                </div>
                
                <ul class="menu-nav">
                    <li><a href="index.php" class="enlace-nav <?php echo ($active_page === 'inicio') ? 'active' : ''; ?>">Inicio</a></li>
                    <li><a href="index.php#reseñas" class="enlace-nav <?php echo ($active_page === 'reseñas') ? 'active' : ''; ?>">Reseñas</a></li>
                    <li><a href="index.php#noticias" class="enlace-nav <?php echo ($active_page === 'noticias') ? 'active' : ''; ?>">Noticias</a></li>
                    <li><a href="index.php#ranking" class="enlace-nav <?php echo ($active_page === 'ranking') ? 'active' : ''; ?>">Ranking</a></li>
                    <li><a href="agregar_opinion.php" class="enlace-nav <?php echo ($active_page === 'agregar_opinion') ? 'active' : ''; ?>">Agregar Opinión</a></li>
                    <li><a href="contacto.php" class="enlace-nav <?php echo ($active_page === 'contacto') ? 'active' : ''; ?>">Contacto</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- REQUERIMIENTO: Etiqueta semántica <main> -->
    <main class="contenido-principal">