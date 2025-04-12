<?php
include 'db.php';
session_start();

if (!isset($_SESSION['equipo_id'])) {
    echo json_encode([]);
    exit();
}

$equipo_id = $_SESSION['equipo_id'];

try {
    $query = "SELECT e.nombre AS nombre_equipo, e.distrito, e.rango, e.celular
              FROM invitaciones i
              JOIN equipos e ON (i.de_equipo = e.id OR i.para_equipo = e.id)
              WHERE (i.de_equipo = :equipo_id OR i.para_equipo = :equipo_id)
              AND i.estado = 'aceptado' AND e.id != :equipo_id";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':equipo_id', $equipo_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($matches);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
