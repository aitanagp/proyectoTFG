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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Director</title>
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
        <?php echo "<h2>Elimina Directores</h2>"; ?>

        <form action="" method="post">
            <label for="nombre_director">Nombre del Director:</label>
            <select name="nombre_director" id="nombre_director">
                <?php
                // Realizar la consulta para obtener los nombres de los director
                require_once "../funciones.php";
                $ruta = obtenerdirseg();
                require_once $ruta . "conectaDB.php";

                $dbname = "mydb";
                $dbcon = conectaDB($dbname);

                if ($dbcon) {
                    $sql = "SELECT nombre FROM director";
                    $stmt = $dbcon->prepare($sql);
                    $stmt->execute();

                    // Iterar sobre los resultados y agregar cada nombre como una opción en el select
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Error al conectar con la base de datos</option>";
                }
                ?>
            </select><br>
            <button type="submit" value="Eliminar Director">Eliminar director</button>
        </form>

        <?php
        // Procesar el formulario de eliminación
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger el nombre del director a eliminar
            $nombre_director = $_POST['nombre_director'];

            // Realizar la eliminación en la base de datos
            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if ($dbcon) {
                $sql = "DELETE FROM director WHERE nombre = :nombre_director";
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(':nombre_director', $nombre_director);

                if ($stmt->execute()) {
                    echo "El director se ha eliminado correctamente.";
                } else {
                    echo "Error al eliminar el director.";
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