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
    <title>Alta de Intérpretes</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <a href="../index.php" class="home-link">&#8962;</a>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <br>
        <nav>
            <ul>
                <li><a href="../alta/alta_interpretes.php">Alta</a></li>
                <li><a href="../eliminar/elimina_interpretes.php">Eliminación</a></li>
                <li><a href="../interpretes/consulta_interpretes.php">Consulta</a></li>
                <li><a href="../interpretes/consulta_nacionalidad_actor.php">Por nacionalidad</a></li>
                <li><a href="../interpretes/consulta_nacimineto_actor.php">Por nacimiento</a></li>
                <li><a href="../interpretes/consulta_peliculas_actor.php">Por películas</a></li>
                <li><a href="../interpretes/consulta_premios_actor.php">Por premios</a></li>
                <li><a href="../index.php">Volver al menú</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo "<h2>Añadir intérpretes</h2>"; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="idinterprete">Id intérprete:</label>
            <input type="number" id="idinterprete" name="idinterprete" required><br>
            <label for="nombre_inter">Nombre:</label>
            <input type="text" id="nombre_inter" name="nombre_inter" required><br>
            <label for="nacionalidad">Nacionalidad:</label>
            <input type="text" id="nacionalidad" name="nacionalidad" required><br>
            <label for="anyo_nacimiento">Año nacimiento:</label>
            <input type="number" id="anyo_nacimiento" name="anyo_nacimiento" required><br>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br>
            <button type="submit" name="interprete" value="Agregar interprete">Agregar interprete</button>
        </form>
        <br><br>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombre_inter">Nombre interprete:</label>
            <input type="text" id="nombre_inter" name="nombre_inter" required><br>
            <label for="titulo">Titulo película:</label>
            <input type="text" id="titulo" name="titulo" required><br>
            <button type="submit" name="actua">Agregar</button>
        </form>

        <?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['interprete'])) {
    // Recoger los datos del formulario
    $idinterprete = $_POST['idinterprete'];
    $nombre_inter = $_POST['nombre_inter'];
    $nacionalidad = $_POST['nacionalidad'];
    $anyo_nacimiento = $_POST['anyo_nacimiento'];

    // Manejar la carga de la imagen
    $target_dir = "uploads/"; // Directorio donde se guardarán las imágenes
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Comprobar si la conexión a la base de datos es correcta
    if ($dbcon) {
        // Guardar la ruta de la imagen en la base de datos
        $imagen_path = $target_file;

        $sql = "INSERT INTO interprete (idinterprete, nombre_inter, nacionalidad, anyo_nacimiento, imagen)
                VALUES (:idinterprete, :nombre_inter, :nacionalidad, :anyo_nacimiento, :imagen)";
        $stmt = $dbcon->prepare($sql);
        $stmt->bindParam(':idinterprete', $idinterprete);
        $stmt->bindParam(':nombre_inter', $nombre_inter);
        $stmt->bindParam(':nacionalidad', $nacionalidad);
        $stmt->bindParam(':anyo_nacimiento', $anyo_nacimiento);
        $stmt->bindParam(':imagen', $imagen_path);

        if ($stmt->execute()) {
            echo "El intérprete se ha insertado correctamente.";
        } else {
            echo "Error al insertar el intérprete.";
        }
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actua'])) {
    $nombre_inter = $_POST['nombre_inter'];
    $titulo = $_POST['titulo'];

    // Comprobar si la conexión a la base de datos es correcta
    if ($dbcon) {
        $sql_idinterprete = "SELECT idinterprete FROM interprete WHERE nombre_inter LIKE :nombre_inter";
        $stmt_idinterprete = $dbcon->prepare($sql_idinterprete);
        $stmt_idinterprete->bindParam(':nombre_inter', $nombre_inter);
        $stmt_idinterprete->execute();
        $idinterprete = $stmt_idinterprete->fetchColumn();

        $sql_idpelicula = "SELECT idpelicula FROM pelicula WHERE titulo LIKE :titulo";
        $stmt_idpelicula = $dbcon->prepare($sql_idpelicula);
        $stmt_idpelicula->bindParam(':titulo', $titulo);
        $stmt_idpelicula->execute();
        $idpelicula = $stmt_idpelicula->fetchColumn();

        $sql_insert = "INSERT INTO actua (idpelicula, idinterprete) VALUES (:idpelicula, :idinterprete)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':idinterprete', $idinterprete);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);

        if ($stmt_insert->execute()) {
            echo "El intérprete se ha insertado correctamente en la película.";
        } else {
            echo "Error al insertar el intérprete en la película.";
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