
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['equipo_id'])) {
    echo json_encode(["success" => false, "error" => "No hay sesión activa"]);
    exit();
}

$equipo_id = $_SESSION['equipo_id'];
$data = json_decode(file_get_contents("php://input"), true);

// Validar datos
if (!isset($data['para_equipo'], $data['fecha'], $data['hora'])) {
    echo json_encode(["success" => false, "error" => "Datos incompletos"]);
    exit();
}

$para_equipo = intval($data['para_equipo']);
$fecha = $data['fecha'];
$hora = $data['hora'];

try {
    $stmt = $conn->prepare("INSERT INTO partidos (de_equipo, para_equipo, fecha, hora) VALUES (:de_equipo, :para_equipo, :fecha, :hora)");
    $stmt->bindParam(":de_equipo", $equipo_id, PDO::PARAM_INT);
    $stmt->bindParam(":para_equipo", $para_equipo, PDO::PARAM_INT);
    $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
