<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = hash('sha256', $_POST['password']); // Hash SHA-256
    $edad_min = intval($_POST['edad_min']);
    $edad_max = intval($_POST['edad_max']);
    $distrito = $_POST['distrito'];
    $rango = $_POST['rango'];
    $jugadores = $_POST['jugadores'];

    try {
        $stmt = $conn->prepare("INSERT INTO equipos (nombre, password, edad_min, edad_max, victorias, derrotas, distrito, rango, jugadores)
                                VALUES (:nombre, :password, :edad_min, :edad_max, 0, 0, :distrito, :rango, :jugadores)");
        
        $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":edad_min", $edad_min, PDO::PARAM_INT);
        $stmt->bindValue(":edad_max", $edad_max, PDO::PARAM_INT);
        $stmt->bindValue(":distrito", $distrito, PDO::PARAM_STR);
        $stmt->bindValue(":rango", $rango, PDO::PARAM_STR);
        $stmt->bindValue(":jugadores", $jugadores, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registro exitoso. Puedes iniciar sesión ahora.</p>";
        } else {
            echo "<p style='color:red;'>Error al registrar equipo.</p>";
        }

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
