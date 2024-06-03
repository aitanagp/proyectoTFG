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
    <title>Alta de películas</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
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
                <li><a href="../alta/alta_peliculas.php">Alta</a></li>
                <li><a href="../eliminar/elimina_peliculas.php">Eliminación</a></li>
                <li><a href="../peliculas/consulta_pelicula.php">Consulta</a></li>
                <li><a href="../peliculas/consulta_fecha.php">Por Fecha</a></li>
                <li><a href="../peliculas/consulta_director.php">Por director</a></li>
                <li><a href="../peliculas/consulta_titulo.php">Por título</a></li>
                <li><a href="../peliculas/consulta_actor.php">Por Actor</a></li>
                <li><a href="../peliculas/consulta_premios.php">Por premios</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo "<h2>Añadir Peliculas</h2>"; ?>

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
            <label for="text">Nombre Guión:</label>
            <input type="text" id="nombreguion" name="nombreguion"><br>
            <label for="idremake">Id remake:</label>
            <input type="number" id="idremake" name="idremake"><br>
            <label for="anyo">Año producción:</label>
            <input type="number" id="anyo" name="anyo" required><br>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br>
            <button type="submit" value="Agregar Película">Agregar pelicula</button>
        </form>
    </main>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
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
    $nombreguion = $_POST['nombreguion'];

    // Manejar la carga de la imagen
    $imagen_path = $_FILES["imagen"]["tmp_name"];
    $imagen_contenido = file_get_contents($imagen_path); // Obtener el contenido binario de la imagen

    // Insertar los datos en la base de datos
    $dbname = "mydb";
    $dbcon = conectaDB($dbname);

    if ($dbcon) {
        try {
            // Verificar si el idpelicula ya existe
            $sqlCheck = "SELECT COUNT(*) FROM pelicula WHERE idpelicula = :idpelicula";
            $stmtCheck = $dbcon->prepare($sqlCheck);
            $stmtCheck->bindParam(':idpelicula', $idpelicula);
            $stmtCheck->execute();
            if ($stmtCheck->fetchColumn() > 0) {
                echo "Error: El ID de la película ya existe.";
            } else {
                $dbcon->beginTransaction();

                $sql = "INSERT INTO pelicula (idpelicula, titulo, nacionalidad, idguion, idremake, anyo_prod, imagen)
                        VALUES (:idpelicula, :titulo, :nacionalidad, :idguion, :idremake, :anyo, :imagen)";
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(':idpelicula', $idpelicula);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':nacionalidad', $nacionalidad);
                $stmt->bindParam(':idguion', $idguion);
                $stmt->bindParam(':idremake', $idremake);
                $stmt->bindParam(':anyo', $anyo);
                $stmt->bindParam(':imagen', $imagen_contenido, PDO::PARAM_LOB);
                $stmt->execute();

                $sql2 = "INSERT INTO dirige (iddirector, idpelicula) VALUES (:iddirector, :idpelicula)";
                $stmt2 = $dbcon->prepare($sql2);
                $stmt2->bindParam(':iddirector', $iddirector);
                $stmt2->bindParam(':idpelicula', $idpelicula);
                $stmt2->execute();

                $sql3 = "INSERT INTO guion (idguion, nombre_guion) 
                        VALUES (:idguion, :nombreguion)";
                $stmt3 = $dbcon->prepare($sql3);
                $stmt3->bindParam(':idguion', $idguion);
                $stmt3->bindParam(':nombreguion', $nombreguion);
                $stmt3->execute();

                $dbcon->commit();

                echo "La película se ha insertado correctamente.";
            }
        } catch (PDOException $e) {
            $dbcon->rollBack();
            if ($e->getCode() == 23000) {
                echo "Error: El ID de la película ya existe.";
            } else {
                echo "Error en la base de datos: " . $e->getMessage();
            }
        }
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }
}
?>