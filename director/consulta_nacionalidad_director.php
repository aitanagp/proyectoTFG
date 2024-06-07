<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por director</title>
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
    <br>
    <main>
        <?php echo "<h2>Por año de nacionalidad</h2>"; ?>

        <form action="" method="post">
            <label for="nacionalidad">Nacionalidad de director:</label>
            <input type="text" name="nacionalidad" id="nacionalidad" required>
            <button type="submit">Buscar</button>
        </form>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        if (isset($dbcon)) {
            if (isset($_POST['nacionalidad'])) {
                $nacionalidad = $_POST['nacionalidad'];

                $sql = "SELECT nombre, nacionalidad, imagen
                        FROM director 
                        WHERE nacionalidad LIKE :nacionalidad";

                $stmt = $dbcon->prepare($sql);

                // Agregar % al principio y al final para hacer una búsqueda parcial
                $nacionalidad_like = '%' . $nacionalidad . '%';

                $stmt->bindParam(':nacionalidad', $nacionalidad_like);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class ='actor-section'>";
                        echo "<div class='actor-info'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'>";
                        echo "<div class='actor-details'>";
                        echo "<h3>{$row['nombre']}</h3>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "No se encontró ninguna película con el nombre de actor '$nacionalidad'.";
                }

                $dbcon = null;
            }
        } else {
            echo "Error: No se pudo establecer la conexión con la base de datos.";
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