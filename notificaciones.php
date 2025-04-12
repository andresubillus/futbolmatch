<?php
include 'db.php';
session_start();

if (!isset($_SESSION['equipo_id'])) {
    echo json_encode([]);
    exit();
}

$equipo_id = $_SESSION['equipo_id'];

try {
    $query = "SELECT invitaciones.id, equipos.nombre FROM invitaciones
              JOIN equipos ON invitaciones.de_equipo = equipos.id
              WHERE invitaciones.para_equipo = :equipo_id AND invitaciones.estado = 'pendiente'";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':equipo_id', $equipo_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $invitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($invitaciones);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
