<?php
//seguridad de session
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] != 'Administrador') {
    echo "no tienes acceso";
    header("refresh:1;url=../index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de directores</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <a href="../index.php" class="home-link">&#8962;</a>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>

        <nav>
            <ul>
                <li><a href="../alta/alta_directores.php">Alta</a></li>
                <li><a href="../eliminar/elimina_director.php">Eliminación</a></li>
                <li><a href="../director/consulta_directores.php">Consulta</a></li>
                <li><a href="../director/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
                <li><a href="../director/consulta_nacimiento_director.php">Por fecha de nacimiento</a></li>
                <li><a href="../director/consulta_premios_director.php">Por premios</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo "<h2>Añadir Directores</h2>"; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="iddirector">Id director:</label>
            <input type="number" id="iddirector" name="iddirector" required><br>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="nacionalidad">Nacionalidad:</label>
            <input type="text" id="nacionalidad" name="nacionalidad" required><br>
            <label for="anyo_nacimiento">Año de nacimiento:</label>
            <input type="number" id="anyo_nacimiento" name="anyo_nacimiento" required><br>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br>
            <button type="submit" value="Agregar Director">Agregar director</button>
        </form>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger los datos del formulario
            $iddirector = $_POST['iddirector'];
            $nombre = $_POST['nombre'];
            $nacionalidad = $_POST['nacionalidad'];
            $anyo_nacimiento = $_POST['anyo_nacimiento'];

            // Manejar la carga de la imagen
            $target_dir = "uploads/"; // Directorio donde se guardarán las imágenes
            $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Insertar los datos en la base de datos
            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if ($dbcon) {
                // Guardar la ruta de la imagen en la base de datos
                $imagen_path = $target_file;

                $sql = "INSERT INTO director (iddirector, nombre, nacionalidad, anyo_nacimiento, imagen)
                    VALUES (:iddirector, :nombre, :nacionalidad, :anyo_nacimiento, :imagen)";
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(':iddirector', $iddirector);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':nacionalidad', $nacionalidad);
                $stmt->bindParam(':anyo_nacimiento', $anyo_nacimiento);
                $stmt->bindParam(':imagen', $imagen_path);

                if ($stmt->execute()) {
                    echo "El director se ha insertado correctamente.";
                } else {
                    echo "Error al insertar el director.";
                }
            } else {
                echo "Error: No se pudo establecer la conexión con la base de datos.";
            }
        }
        ?>
    </main>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>