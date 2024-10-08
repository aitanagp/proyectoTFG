<?php
//seguridad de session
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] != 'Administrador') {
    header("Location:../error.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
//

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de directores</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
        <?php if (isset($_SESSION['foto_perfil'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['foto_perfil']); ?>" alt="Foto de Perfil"
                class="perfil-pequeno">
        <?php endif; ?>
        <span class="material-symbols-outlined">
            <a href="../logout.php" class="logout">logout</a>
        </span>
        <span class="material-symbols-outlined">
            <a href="../index.php" class="home-link">home</a>
        </span>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <br>
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
            <input type="year" id="anyo_nacimiento" name="anyo_nacimiento" required><br>
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen"><br>
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
            // Recibir datos de la imagen
            $imagen = $_FILES['imagen']['tmp_name'];
            $tipo_imagen = $_FILES['imagen']['type'];
            $tamanyo_imagen = $_FILES['imagen']['size'];
            $tmp_name = $_FILES['imagen']['tmp_name'];

            // Verificar que el archivo temporal existe
            if (!is_uploaded_file($imagen)) {
                die("Error: El archivo temporal no existe.");
            }

            // Obtener el contenido del archivo
            $imagen_data = file_get_contents($imagen);
            if ($imagen_data === false) {
                die("Error: No se pudo leer el contenido del archivo.");
            }

            // Insertar los datos en la base de datos
            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if ($dbcon) {
                //guarda la ruta de la imagen
                $imagen_ruta = '/htdocs/php/imagenes/directores/' . basename($imagen);

                $sql = "INSERT INTO director (iddirector, nombre, nacionalidad, anyo_nacimiento, imagen)
                VALUES (:iddirector, :nombre, :nacionalidad, :anyo_nacimiento, :imagen)";
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(':iddirector', $iddirector);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':nacionalidad', $nacionalidad);
                $stmt->bindParam(':anyo_nacimiento', $anyo_nacimiento);
                $stmt->bindParam(':imagen', $imagen_data, PDO::PARAM_LOB);


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