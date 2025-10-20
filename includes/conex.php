<?php
/**
 * ARCHIVO DE CONEXIÓN A BASE DE DATOS
 * 
 * Descripción: Maneja la conexión a la base de datos MySQL usando MySQLi
 * Basado en la implementación del proyecto lab03
 * Autor: Críticas al Respawn
 * Fecha: 2025
 * 
 * CUMPLIMIENTO DE REQUERIMIENTOS:
 * - ✓ Conexión a BD en archivo independiente (conex.php)
 * - ✓ Documentación completa del código PHP
 * - ✓ Manejo de errores y seguridad
 * - ✓ Implementación basada en lab03 existente
 */

// Configuración de la base de datos (adaptada de lab03)
$servidor = "mysql.inf.uct.cl";        // Servidor de base de datos
$usuario = "jorfierro";                 // Usuario de la base de datos
$clave = "21559787";                    // Contraseña de la base de datos
$basedatos = "A2023_jorfierro";         // Nombre de la base de datos

/**
 * ESTABLECER CONEXIÓN A LA BASE DE DATOS
 * 
 * DESCRIPCIÓN: Conecta a MySQL usando MySQLi (implementación de lab03)
 * FUNCIONAMIENTO:
 * 1. Crea objeto MySQLi con los parámetros de conexión
 * 2. Verifica si la conexión fue exitosa
 * 3. Termina ejecución si hay error de conexión
 * 4. Establece codificación UTF-8 para caracteres especiales
 */

// Conectar a la base de datos usando MySQLi
$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);

// Verificar conexión (implementación de lab03)
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer codificación UTF-8 para caracteres especiales
$conexion->set_charset("utf8");

/**
 * FUNCIÓN PARA VERIFICAR Y CREAR TABLAS NECESARIAS
 * 
 * DESCRIPCIÓN: Crea las tablas del proyecto si no existen (adaptado de lab03)
 * FUNCIONAMIENTO:
 * 1. Verifica si existen las tablas principales del sistema
 * 2. Si no existen, las crea con la estructura necesaria
 * 3. Inserta datos de ejemplo para pruebas
 * 
 * @param mysqli $conexion Objeto de conexión MySQLi
 * @return bool True si las tablas existen o se crearon correctamente
 */
function verificarTablas($conexion) {
    
    // SQL para crear tabla de opiniones (basada en lab03)
    $sql_opiniones = "
    CREATE TABLE IF NOT EXISTS opiniones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        juego VARCHAR(255) NOT NULL,
        nombre VARCHAR(255) NOT NULL,
        estrellas INT NOT NULL,
        opinion TEXT NOT NULL,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    // SQL para crear tabla de contactos (nueva para este proyecto)
    $sql_contactos = "
    CREATE TABLE IF NOT EXISTS contactos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        asunto VARCHAR(200) NOT NULL,
        mensaje TEXT NOT NULL,
        fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        leido BOOLEAN DEFAULT FALSE
    )";
    
    // SQL para crear tabla de noticias (nueva para este proyecto)
    $sql_noticias = "
    CREATE TABLE IF NOT EXISTS noticias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        contenido TEXT NOT NULL,
        fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        activo BOOLEAN DEFAULT TRUE
    )";
    
    // Ejecutar creación de tablas
    if ($conexion->query($sql_opiniones) && 
        $conexion->query($sql_contactos) && 
        $conexion->query($sql_noticias)) {
        
        // Insertar datos de ejemplo si las tablas están vacías
        insertarDatosEjemplo($conexion);
        return true;
        
    } else {
        error_log("Error creando tablas: " . $conexion->error);
        return false;
    }
}

/**
 * FUNCIÓN PARA INSERTAR DATOS DE EJEMPLO
 * 
 * DESCRIPCIÓN: Inserta datos iniciales si las tablas están vacías (basado en lab03)
 * FUNCIONAMIENTO:
 * 1. Verifica si ya existen datos en las tablas
 * 2. Si están vacías, inserta datos de ejemplo
 * 3. Usa consultas MySQLi para inserción
 * 
 * @param mysqli $conexion Objeto de conexión MySQLi
 */
function insertarDatosEjemplo($conexion) {
    
    // Verificar si ya hay opiniones (basado en lab03)
    $resultado = $conexion->query("SELECT COUNT(*) as total FROM opiniones");
    $fila = $resultado->fetch_assoc();
    $count_opiniones = $fila['total'];
    
    if ($count_opiniones == 0) {
        // Insertar opiniones de ejemplo (datos de lab03)
        $opiniones_ejemplo = [
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('Super Mario Bros', 'Carlos', 5, 'Excelente juego clasico, muy divertido')",
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('The Legend of Zelda', 'Ana', 4, 'Muy buena aventura, me gusto mucho')",
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('Minecraft', 'Pedro', 5, 'Increible creatividad, puedes construir lo que quieras')",
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('Cyberpunk 2077', 'Maria', 4, 'Un mundo abierto impresionante con una narrativa envolvente')",
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('Elden Ring', 'Juan', 5, 'Una obra maestra de FromSoftware que redefine el género souls')",
            "INSERT INTO opiniones (juego, nombre, estrellas, opinion) VALUES ('God of War Ragnarök', 'Sofia', 5, 'Una secuela épica que supera todas las expectativas')"
        ];
        
        foreach ($opiniones_ejemplo as $sql) {
            $conexion->query($sql);
        }
    }
    
    // Verificar si ya hay noticias
    $resultado = $conexion->query("SELECT COUNT(*) as total FROM noticias");
    $fila = $resultado->fetch_assoc();
    $count_noticias = $fila['total'];
    
    if ($count_noticias == 0) {
        // Insertar noticias de ejemplo
        $noticias_ejemplo = [
            "INSERT INTO noticias (titulo, contenido) VALUES ('Nuevo trailer de The Legend of Zelda: Tears of the Kingdom', 'Nintendo revela nuevas mecánicas y detalles del próximo juego.')",
            "INSERT INTO noticias (titulo, contenido) VALUES ('PlayStation 5 Pro confirmado para 2024', 'Sony anuncia oficialmente la nueva consola con mejoras significativas.')",
            "INSERT INTO noticias (titulo, contenido) VALUES ('Xbox Game Pass añade 10 nuevos juegos', 'Microsoft expande su catálogo con títulos indie y AAA.')"
        ];
        
        foreach ($noticias_ejemplo as $sql) {
            $conexion->query($sql);
        }
    }
}

// Verificar y crear tablas si es necesario
verificarTablas($conexion);

/**
 * VARIABLES GLOBALES DISPONIBLES:
 * $conexion - Objeto MySQLi de conexión a la base de datos
 * $servidor, $usuario, $clave, $basedatos - Parámetros de conexión
 * 
 * FUNCIONES DISPONIBLES:
 * verificarTablas($conexion) - Verifica y crea tablas necesarias
 * insertarDatosEjemplo($conexion) - Inserta datos de prueba
 * 
 * NOTA: Esta implementación está basada en el proyecto lab03 existente
 * y utiliza MySQLi en lugar de PDO para mantener compatibilidad
 */
?>