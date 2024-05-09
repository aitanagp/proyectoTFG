<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Película</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas por Director</h1>
        </div>
    </header>
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
        <input type="submit" value="Eliminar Película">
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
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>