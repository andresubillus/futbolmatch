<?php
include 'db.php';
session_start();

// Verificar si la sesión está iniciada correctamente
if (!isset($_SESSION['equipo_id'])) {
    echo json_encode(["success" => false, "error" => "Sesión no iniciada"]);
    exit();
}

// Verificar que los datos POST existen
if (!isset($_POST['partido_id'], $_POST['comentario'], $_POST['calificacion'])) {
    echo json_encode(["success" => false, "error" => "Datos incompletos"]);
    exit();
}

$equipo_id = $_SESSION['equipo_id'];
$partido_id = intval($_POST['partido_id']);
$comentario = trim($_POST['comentario']);
$calificacion = intval($_POST['calificacion']); // Asegurar que es un número

$query = "INSERT INTO calificaciones (partido_id, equipo_id, comentario, calificacion) VALUES (:partido_id, :equipo_id, :comentario, :calificacion)";
$stmt = $conn->prepare($query);

$stmt->bindValue(':partido_id', $partido_id, PDO::PARAM_INT);
$stmt->bindValue(':equipo_id', $equipo_id, PDO::PARAM_INT);
$stmt->bindValue(':comentario', $comentario, PDO::PARAM_STR);
$stmt->bindValue(':calificacion', $calificacion, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->errorInfo()]);
}

$stmt = null;
$conn = null;
?>
