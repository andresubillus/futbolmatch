<?php
// responder_invitacion.php
include 'db.php'; // Conexión a tu base de datos

$equipo_envia = $_POST['equipo_envia'];
$accion = $_POST['accion']; // 'aceptar' o 'rechazar'

session_start();
$equipo_responde = $_SESSION['equipo']; // Ajusta según cómo manejas sesiones

try {
    // Actualizar estado de la invitación
    $stmt = $conn->prepare("UPDATE invitaciones SET estado = :accion WHERE equipo_envia = :envia AND equipo_recibe = :recibe");
    $stmt->bindValue(":accion", $accion, PDO::PARAM_STR);
    $stmt->bindValue(":envia", $equipo_envia, PDO::PARAM_STR);
    $stmt->bindValue(":recibe", $equipo_responde, PDO::PARAM_STR);
    $stmt->execute();

    // Insertar notificación para el equipo que envió la invitación
    $mensaje = "El equipo '$equipo_responde' ha $accion tu invitación.";
    $stmt2 = $conn->prepare("INSERT INTO notificaciones (equipo_destino, mensaje, leido) VALUES (:destino, :mensaje, 0)");
    $stmt2->bindValue(":destino", $equipo_envia, PDO::PARAM_STR);
    $stmt2->bindValue(":mensaje", $mensaje, PDO::PARAM_STR);
    $stmt2->execute();

    echo "Has $accion la invitación.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
