<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // Preparar la consulta con PDO
    $stmt = $conn->prepare("SELECT * FROM equipos WHERE nombre = ?");
    $stmt->execute([$nombre]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Depuración
    var_dump($nombre);
    var_dump($password);
    var_dump($row);

    if ($row && $password == trim($row['password'])) {  // Sin cifrado, comparación simple
        $_SESSION['equipo'] = $row['nombre'];
        $_SESSION['equipo_id'] = $row['id'];
        header("Location: buscar.html");
        exit();
    }
    
    } else {
        echo "<p style='color:red;'>Nombre o contraseña incorrectos.</p>";
 }

?>
