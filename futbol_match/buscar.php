<?php
include 'db.php'; // Asegúrate de que db.php usa PDO para conectar con SQL Server

$distrito = isset($_GET['distrito']) ? trim($_GET['distrito']) : '';
$rango = isset($_GET['rango']) ? trim($_GET['rango']) : '';

// Construir consulta base
$sql = "SELECT * FROM equipos WHERE 1=1";
$params = [];

// Filtro distrito
if (!empty($distrito)) {
    $sql .= " AND distrito LIKE :distrito";
    $params[':distrito'] = "%$distrito%";
}

// Filtro rango edad (ej: 17-20)
if (!empty($rango) && strpos($rango, '-') !== false) {
    list($min, $max) = explode('-', $rango);
    $min = intval($min);
    $max = intval($max);
    $sql .= " AND edad_min >= :min AND edad_max <= :max";
    $params[':min'] = $min;
    $params[':max'] = $max;
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al obtener datos: " . $e->getMessage()]);
}
?>
