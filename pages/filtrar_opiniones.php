<?php
/**
 * FILTRAR OPINIONES - CRÍTICAS AL RESPAWN
 * 
 * Descripción: Archivo PHP que filtra opiniones y retorna JSON para FETCH
 * Autor: Críticas al Respawn
 * Fecha: 2025
 */

// Configurar headers para JSON
header('Content-Type: application/json');

// Incluir conexión a la base de datos
require_once '../includes/conex.php';

try {
    // Obtener el filtro desde GET
    $filtro = $_GET['filtro'] ?? 'todas';
    
    // Debug: Log del filtro recibido
    error_log("Filtro recibido: " . $filtro);
    
    // Construir consulta SQL según el filtro
    switch ($filtro) {
        case '5estrellas':
            $sql = "SELECT * FROM opiniones WHERE estrellas = 5 ORDER BY fecha DESC";
            break;
            
        case '4mas':
            $sql = "SELECT * FROM opiniones WHERE estrellas >= 4 ORDER BY fecha DESC";
            break;
            
        case '3menos':
            $sql = "SELECT * FROM opiniones WHERE estrellas <= 3 ORDER BY fecha DESC";
            break;
            
        case 'recientes':
            $sql = "SELECT * FROM opiniones ORDER BY fecha DESC LIMIT 5";
            break;
            
        case 'antiguas':
            $sql = "SELECT * FROM opiniones ORDER BY fecha ASC LIMIT 5";
            break;
            
        case 'todas':
        default:
            $sql = "SELECT * FROM opiniones ORDER BY fecha DESC";
            break;
    }
    
    // Debug: Log de la consulta SQL
    error_log("SQL ejecutada: " . $sql);
    
    // Ejecutar consulta
    $resultado = $conexion->query($sql);
    
    // Debug: Log del resultado
    error_log("Filas encontradas: " . ($resultado ? $resultado->num_rows : 0));
    
    // Convertir resultados a array
    $opiniones = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $opiniones[] = [
                'id' => $fila['id'],
                'juego' => htmlspecialchars($fila['juego']),
                'nombre' => htmlspecialchars($fila['nombre']),
                'estrellas' => (int)$fila['estrellas'],
                'opinion' => htmlspecialchars($fila['opinion']),
                'fecha' => date('d/m/Y', strtotime($fila['fecha']))
            ];
        }
    }
    
    // Respuesta exitosa
    $respuesta = [
        'success' => true,
        'filtro' => $filtro,
        'total' => count($opiniones),
        'opiniones' => $opiniones
    ];
    
} catch (Exception $e) {
    // Respuesta de error
    $respuesta = [
        'success' => false,
        'message' => 'Error al filtrar opiniones: ' . $e->getMessage(),
        'filtro' => $filtro ?? 'desconocido',
        'total' => 0,
        'opiniones' => []
    ];
}

// Cerrar conexión
if (isset($conexion)) {
    $conexion->close();
}

// Retornar JSON
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>