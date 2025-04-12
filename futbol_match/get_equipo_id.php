<?php
session_start();

if (isset($_SESSION['id_equipo'])) {
    echo $_SESSION['id_equipo'];  // Devuelve el ID del equipo logueado
} else {
    echo 0;  // No hay equipo logueado
}
?>
