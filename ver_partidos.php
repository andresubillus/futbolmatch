
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['equipo_id'])) {
    echo json_encode(["success" => false, "error" => "No hay sesión activa"]);
    exit();
}

$equipo_id = $_SESSION['equipo_id'];

try {
    $query = "SELECT p.id, e1.nombre AS de_nombre, e2.nombre AS para_nombre, p.fecha, p.hora, p.estado, p.de_equipo, p.para_equipo
              FROM partidos p
              JOIN equipos e1 ON p.de_equipo = e1.id
              JOIN equipos e2 ON p.para_equipo = e2.id
              WHERE p.de_equipo = :equipo_id OR p.para_equipo = :equipo_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":equipo_id", $equipo_id, PDO::PARAM_INT);
    $stmt->execute();

    $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($partidos);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
