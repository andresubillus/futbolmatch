<?php
session_start();
include 'db.php';

if (!isset($_SESSION['equipo'])) {
    echo json_encode([]);
    exit();
}

$equipo_actual = $_SESSION['equipo'];

try {
    // Preparar la consulta
    $stmt = $conn->prepare("SELECT equipo_envia FROM invitaciones WHERE equipo_recibe = :equipo_actual AND estado = 'pendiente'");
    $stmt->bindValue(':equipo_actual', $equipo_actual, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener resultados
    $invitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($invitaciones);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
