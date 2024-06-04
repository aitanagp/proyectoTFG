<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Base de Datos de Películas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="login-container">
        <img src="imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <br>
        <div class="">
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre de Usuario</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>

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

    // Consulta para verificar el nombre de usuario y la contraseña
    $consulta = "SELECT idlogin FROM login WHERE nombre = ? AND password = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("ss", $nombre, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $filas = $resultado->fetch_assoc();
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $filas['idlogin'];

        if ($filas['idlogin'] == 1) { // administrador
            header("Location: index.php"); // este usuario tiene permisos de añadir, eliminar y editar
        } else if ($filas['idlogin'] == 2) { // usuario
            header("Location: index.php"); // este usuario solo tiene permisos de consulta
        }
        exit();
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $resultado->free();
    $conexion->close();
}
?>
