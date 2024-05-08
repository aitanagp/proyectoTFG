<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Intérprete</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>
<body>
    <header>
        <h1>Eliminar Intérprete</h1>
</header>
    <form action="" method="post">
        <label for="nombre_interprete">Nombre del Intérprete:</label>
        <select name="nombre_interprete" id="nombre_interprete">
            <?php
            // Realizar la consulta para obtener los nombres de los intérpretes
            require_once "../funciones.php";
            $ruta = obtenerdirseg();
            require_once $ruta . "conectaDB.php";

            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if ($dbcon) {
                $sql = "SELECT nombre_inter FROM interprete";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute();

                // Iterar sobre los resultados y agregar cada nombre_inter como una opción en el select
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['nombre_inter'] . "'>" . $row['nombre_inter'] . "</option>";
                }
            } else {
                echo "<option value=''>Error al conectar con la base de datos</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Eliminar Intérprete">
    </form>

    <?php
    // Procesar el formulario de eliminación
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger el nombre del intérprete a eliminar
        $nombre_interprete = $_POST['nombre_interprete'];

        // Realizar la eliminación en la base de datos
        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        if ($dbcon) {
            $sql = "DELETE FROM interprete WHERE nombre_inter = :nombre_interprete";
            $stmt = $dbcon->prepare($sql);
            $stmt->bindParam(':nombre_interprete', $nombre_interprete);

            if ($stmt->execute()) {
                echo "El intérprete se ha eliminado correctamente.";
            } else {
                echo "Error al eliminar el intérprete.";
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
