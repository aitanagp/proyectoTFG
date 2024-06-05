<?php
session_start();
require_once "funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // Crear conexión
    $conexion = new mysqli("localhost", "root", "", "mydb");

    if ($conexion->connect_error) {
        die("La conexión falló: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO login(nombre, password) VALUES(:nombre, :password)";

    $stmt = $dbcon->prepare($sql);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':nombre', $nombre);
}
?>