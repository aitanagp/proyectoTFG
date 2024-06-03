<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Base de Datos de Películas</title>
    <style>
        .header-container {
            text-align: center;
            margin-top: 50px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .title h1 {
            font-size: 2em;
        }

        .login-container {
            width: 300px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <img src="imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <br>
        <div class="login-container">
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
require_once "funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['nombre'] = $nombre;

    // Crear conexión
    $conexion = mysqli_connect("localhost", "root", "", "mydb");

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
        } else if ($filas['idlogin'] == 2) {//usuario
            header("location:index.php");//este usuario solo tiene permisos de consulta
        }
    }
}
mysqli_free_result($resultado);
mysqli_close($conexion);
?>