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
    <title>Eliminar Película</title>
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
        <?php echo "<h2>Elimina Peliculas</h2>"; ?>

        <form action="" method="post">
            <label for="titulo_pelicula">Título de la Película:</label>
            <select name="titulo_pelicula" id="titulo_pelicula">
                <?php
                // Realizar la consulta para obtener los títulos de las películas
                require_once "../funciones.php";
                $ruta = obtenerdirseg();
                require_once $ruta . "conectaDB.php";

                $dbname = "mydb";
                $dbcon = conectaDB($dbname);

                if ($dbcon) {
                    $sql = "SELECT titulo FROM pelicula";
                    $stmt = $dbcon->prepare($sql);
                    $stmt->execute();

                    // Iterar sobre los resultados y agregar cada título como una opción en el select
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['titulo'] . "'>" . $row['titulo'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Error al conectar con la base de datos</option>";
                }
                ?>
            </select><br>
            <button type="submit" value="Eliminar pelicula">Eliminar pelicula</button>
        </form>

        <?php
        // Procesar el formulario de eliminación
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger el título de la película a eliminar
            $titulo_pelicula = $_POST['titulo_pelicula'];

            // Realizar la eliminación en la base de datos
            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if ($dbcon) {
                $sql = "DELETE FROM pelicula WHERE titulo = :titulo_pelicula";
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(':titulo_pelicula', $titulo_pelicula);

                if ($stmt->execute()) {
                    echo "La película se ha eliminado correctamente.";
                } else {
                    echo "Error al eliminar la película.";
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