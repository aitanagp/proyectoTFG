<?php
require_once "funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);
$nombre = $_POST['nombre'];
$password = $_POST['password'];
session_start();
$_SESSION['nombre'] = $nombre;

// Crear conexión
$conexion = mysqli_connect("localhost", "root", "root", "mydb");

$consulta = "SELECT idlogin FROM login
                WHERE nombre='$nombre' 
                AND password='$password'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_fetch_array($resultado);
$stmt = $dbcon->prepare($consulta);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    if ($filas['idlogin'] == 1) { //administrador
        header("location:index.php");//este usuario tiene permisos de añadir, eliminar y editar
    } else if ($filas['idlogin'] == 2){//usuario
        header("location:index.php");//este usuario solo tiene permisos de consulta
    }
}


mysqli_free_result($resultado);
mysqli_close($conexion);
?>