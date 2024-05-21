<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intérpretes</title>
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
            <li><a href="../alta/alta_interpretes.php">Alta</a></li>
            <li><a href="../eliminar/elimina_interpretes.php">Eliminación</a></li>
            <li><a href="../interpretes/consulta_interpretes.php">Consulta</a></li>
            <li><a href="../interpretes/consulta_nacionalidad_actor.php">Por nacionalidad</a></li>
            <li><a href="../interpretes/consulta_nacimineto_actor.php">Por nacimiento</a></li>
            <li><a href="../interpretes/consulta_peliculas_actor.php">Por películas</a></li>
            <li><a href="../interpretes/consulta_premios_actor.php">Por premios</a></li>
        </ul>
    </nav>
    <main>
        <h2>Intérpretes</h2>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        $sql = "SELECT * FROM interprete";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='actor-section'>";
                echo "<div class='actor-info'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['imagen']) . "' alt='Imagen del intérprete'>";
                echo "<div class='actor-details'>";
                echo "<h2>{$row['nombre_inter']}</h2>";
                echo "<p><strong>Año de nacimiento:</strong> {$row['anyo_nacimiento']}</p>";
                echo "<p><strong>Nacionalidad:</strong> {$row['nacionalidad']}</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            $dbcon = null;
        } else {
            echo "Error: No se encontraron intérpretes en la base de datos.";
        }
        ?>
    </main>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
