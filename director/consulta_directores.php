<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
    </header>
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
    <main>
        <?php
        echo "<h2>Directores</h2>";

        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        $sql = "SELECT * FROM director";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th>Año de nacimiento</th>
                        <th>Imagen</th>
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>" . $row["nombre"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td>" . $row["anyo_nacimiento"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Imagen del director' width='100'></td>
                  </tr>";
            }
            echo "</table>";
            $dbcon = null;
        } else {
            echo "Error: No se encontraron directores en la base de datos.";
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