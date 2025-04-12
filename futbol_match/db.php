<?php
$serverName = "1496018s.database.windows.net";
$database = "futbol_match_db";
$username = "andresubillus";
$password = "785612000aD@"; // Recuerda no compartir contraseñas en código real

try {
    // Conexión usando PDO
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
