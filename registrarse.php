<!DOCTYPE html>
<html lang="es">

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
            <form action="registrarse.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Foto de perfil:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <button type="submit">Registrarse</button>
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

    // Verificar que el archivo ha sido subido
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $imagenTipo = $_FILES['imagen']['type'];
        $imagenContenido = file_get_contents($imagenTmp);

        // Crear conexión
        $conexion = new mysqli("localhost", "root", "", "mydb");

        if ($conexion->connect_error) {
            die("La conexión falló: " . $conexion->connect_error);
        }

        // Consulta para insertar el nuevo usuario
        $consulta = "INSERT INTO login (nombre, password, imagen) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($consulta);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $nombre, $hashedPassword, $imagenContenido);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['foto_perfil'] = $imagenContenido;
            header("Location: index.php");
            exit();
        } else {
            echo "Error al registrarse. Inténtelo de nuevo.";
        }

        $stmt->close();
        $conexion->close();
    } else {
        echo "Error al subir la imagen.";
    }
}
?>

