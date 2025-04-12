<?php
// ver_respuestas.php
include 'db.php';
session_start();

if (!isset($_SESSION['equipo'])) {
    echo json_encode([]);
    exit();
}

$equipo_actual = $_SESSION['equipo'];

try {
    // Obtener notificaciones no leídas
    $query = "SELECT id, mensaje FROM notificaciones WHERE equipo_destino = :equipo_actual AND leido = 0";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':equipo_actual', $equipo_actual, PDO::PARAM_STR);
    $stmt->execute();
    
    $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Marcar como leídas solo si hay notificaciones
    if (!empty($notificaciones)) {
        $updateQuery = "UPDATE notificaciones SET leido = 1 WHERE equipo_destino = :equipo_actual";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindValue(':equipo_actual', $equipo_actual, PDO::PARAM_STR);
        $updateStmt->execute();
    }

    header('Content-Type: application/json');
    echo json_encode($notificaciones);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
