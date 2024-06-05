<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Crear cuenta</title>
</head>

<body>
    <div class="login-container">
        <img src="imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <div class="login-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Registrarse</button>
            </form>
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

    // Consulta para comprobar si el nombre de usuario ya existe
    $checkNombre = "SELECT * FROM login WHERE nombre = ?";
    $stmt = $conexion->prepare($checkNombre);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<div class='alert alert-warning mt-4' role='alert'>
                <p>Este nombre ya está en uso.</p>
                <p><a href='login.html'>Conectar Aquí</a></p>
              </div>";
    } else {
        // Hashear la contraseña antes de almacenarla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Consulta para insertar el nuevo usuario
        $sql = "INSERT INTO login (nombre, password) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre, $hashed_password);

        if ($stmt->execute()) {
            echo "Registro exitoso!";
            // Iniciar sesión automáticamente después del registro
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rol'] = $conexion->insert_id; // Obtener el ID del usuario recién registrado

            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
}
?>
