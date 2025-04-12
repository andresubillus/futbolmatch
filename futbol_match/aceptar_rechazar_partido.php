
<?php
include 'db.php';
session_start();
$equipo_id = $_SESSION['equipo_id'];
$data = json_decode(file_get_contents("php://input"), true);
$partido_id = $data['partido_id'];
$accion = $data['accion'];

if ($accion === 'aceptar') {
    $stmt = $conn->prepare("UPDATE partidos SET estado = 'aceptado' WHERE id = ? AND para_equipo = ?");
    $stmt->bind_param("ii", $partido_id, $equipo_id);
    $stmt->execute();
    echo json_encode(["success" => true, "mensaje" => "Has aceptado el partido."]);
} elseif ($accion === 'rechazar') {
    $stmt = $conn->prepare("DELETE FROM partidos WHERE id = ? AND para_equipo = ?");
    $stmt->bind_param("ii", $partido_id, $equipo_id);
    $stmt->execute();
    echo json_encode(["success" => true, "mensaje" => "Has rechazado el partido."]);
}
?>
