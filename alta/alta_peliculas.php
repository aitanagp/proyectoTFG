<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de películas</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas por Director</h1>
        </div>
    </header>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="idpelicula">Id película:</label>
        <input type="number" id="idpelicula" name="idpelicula" required><br>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>
        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" id="nacionalidad" name="nacionalidad" required><br>
        <label for="iddirector">Id director:</label>
        <input type="number" id="iddirector" name="iddirector" required><br>
        <label for="idguion">Id guion:</label>
        <input type="number" id="idguion" name="idguion" required><br>
        <label for="idremake">Id remake:</label>
        <input type="number" id="idremake" name="idremake" required><br>
        <label for="anyo">Año producción:</label>
        <input type="number" id="anyo" name="anyo" required><br>
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br>
        <input type="submit" value="Agregar Película">
    </form>
</body>
</html>
<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $idpelicula = $_POST['idpelicula'];
    $titulo = $_POST['titulo'];
    $nacionalidad = $_POST['nacionalidad'];
    $iddirector = $_POST['iddirector'];
    $idguion = $_POST['idguion'];
    $idremake = $_POST['idremake'];
    $anyo = $_POST['anyo'];

    // Manejar la carga de la imagen
    $imagen_path = $_FILES["imagen"]["tmp_name"];
    $imagen_contenido = file_get_contents($imagen_path); // Obtener el contenido binario de la imagen

    // Insertar los datos en la base de datos
    $dbname = "peliculas";
    $dbcon = conectaDB($dbname);

    if ($dbcon) {
        $sql = "INSERT INTO pelicula (idpelicula, titulo, nacionalidad, iddirector, idguion, idremake, anyo_produccion, imagen)
                VALUES (:idpelicula, :titulo, :nacionalidad, :iddirector, :idguion, :idremake, :anyo, :imagen)";
        $stmt = $dbcon->prepare($sql);
        $stmt->bindParam(':idpelicula', $idpelicula);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':nacionalidad', $nacionalidad);
        $stmt->bindParam(':iddirector', $iddirector);
        $stmt->bindParam(':idguion', $idguion);
        $stmt->bindParam(':idremake', $idremake);
        $stmt->bindParam(':anyo', $anyo);
        $stmt->bindParam(':imagen', $imagen_contenido, PDO::PARAM_LOB); // Establecer el parámetro como LOB (Binary Large Object)

        if ($stmt->execute()) {
            echo "La película se ha insertado correctamente.";
        } else {
            echo "Error al insertar la película.";
        }
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }
}
?>

<br><br>
<footer>
    <li><a href="../index.php">Volver al menú</a></li>
    <p>© 2024 AGarcía. Todos los derechos reservados.</p>
</footer>
</body>
</html>