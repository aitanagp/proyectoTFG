<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Intérpretes</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>
<body>
    <header>
        <h1>Alta de Intérpretes</h1>
    </header>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="idinterprete">Id película:</label>
        <input type="number" id="idinterprete" name="idinterprete" required><br>
        <label for="nombre_inter">Título:</label>
        <input type="text" id="nombre_inter" name="nombre_inter" required><br>
        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" id="nacionalidad" name="nacionalidad" required><br>
        <label for="anyo_nacimiento">Año producción:</label>
        <input type="number" id="anyo_nacimiento" name="anyo_nacimiento" required><br>
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br>
        <input type="submit" value="Agregar Película">
    </form>

    <?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $idinterprete = $_POST['idinterprete'];
    $nombre_inter = $_POST['nombre_inter'];
    $nacionalidad = $_POST['nacionalidad'];
    $anyo_nacimiento = $_POST['anyo_nacimiento'];

    // Manejar la carga de la imagen
    $target_dir = "uploads/"; // Directorio donde se guardarán las imágenes
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Insertar los datos en la base de datos
    $dbname = "mydb";
    $dbcon = conectaDB($dbname);

    if ($dbcon) {
        // Guardar la ruta de la imagen en la base de datos
        $imagen_path = $target_file;

        $sql = "INSERT INTO pelicula (idinterprete, nombre_inter, nacionalidad, iddirector, idguion, idremake, anyo_nacimiento_produccion, imagen)
                VALUES (:idinterprete, :nombre_inter, :nacionalidad, :iddirector, :idguion, :idremake, :anyo_nacimiento, :imagen)";
        $stmt = $dbcon->prepare($sql);
        $stmt->bindParam(':idinterprete', $idinterprete);
        $stmt->bindParam(':nombre_inter', $nombre_inter);
        $stmt->bindParam(':nacionalidad', $nacionalidad);
        $stmt->bindParam(':anyo_nacimiento', $anyo_nacimiento);
        $stmt->bindParam(':imagen', $imagen_path);

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