<?php
include 'db.php';
session_start();

$equipo_id = $_SESSION['equipo_id'] ?? null;

if (!$equipo_id) {
    echo json_encode(["error" => "Sesión no iniciada"]);
    exit();
}

$query = "SELECT p.id AS partido_id, p.fecha, p.hora, e1.nombre AS rival, 
          CASE 
              WHEN p.de_equipo = :equipo_id THEN 'Enviado'
              WHEN p.para_equipo = :equipo_id THEN 'Recibido'
          END AS tipo, p.estado
          FROM partidos p
          JOIN equipos e1 ON 
              (p.de_equipo = :equipo_id AND e1.id = p.para_equipo) OR 
              (p.para_equipo = :equipo_id AND e1.id = p.de_equipo)
          WHERE (p.de_equipo = :equipo_id OR p.para_equipo = :equipo_id) 
          AND p.estado = 'aceptado'
          ORDER BY p.fecha DESC, p.hora DESC";

$stmt = $conn->prepare($query);
$stmt->bindValue(":equipo_id", $equipo_id, PDO::PARAM_INT);
$stmt->execute();
$historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($historial);
?>
