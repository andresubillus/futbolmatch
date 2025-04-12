<?php
session_start();
include('db.php'); // Asegúrate de que este archivo existe y tiene la conexión PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipo_envia = $_SESSION['equipo'] ?? null;
    $equipo_recibe = $_POST['equipo_destino'] ?? null;

    if ($equipo_envia && $equipo_recibe) {
        $stmt = $conn->prepare("INSERT INTO invitaciones (equipo_envia, equipo_recibe) VALUES (:equipo_envia, :equipo_recibe)");
        $stmt->bindValue(':equipo_envia', $equipo_envia, PDO::PARAM_STR);
        $stmt->bindValue(':equipo_recibe', $equipo_recibe, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "Invitación enviada a $equipo_recibe.";
        } else {
            echo "Error al enviar la invitación.";
        }
    } else {
        echo "Datos incompletos.";
    }
}
?>
