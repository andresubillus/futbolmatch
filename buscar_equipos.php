<?php
include 'db.php'; // Asegúrate de que db.php usa PDO para conectarse a SQL Server

try {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT nombre, distrito, rango, jugadores, celular FROM equipos");
    $stmt->execute();
    
    // Obtener los resultados como un array asociativo
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al obtener datos: " . $e->getMessage()]);
}
?>
