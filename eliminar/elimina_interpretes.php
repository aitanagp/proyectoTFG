<?php
//seguridad de session
session_start();
if(!isset($_SESSION['nombre']) || $_SESSION['nombre']!='Administrador'){
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
    <title>Eliminar Intérprete</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <a href="../index.php" class="home-link">&#8962;</a>
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
        <?php echo "<h2>Elimina Intérpretes</h2>"; ?>

        <form action="" method="post">
            <label for="nombre_interprete">Nombre del Intérprete:</label>
            <select name="nombre_interprete" id="nombre_interprete">

                <br><br>
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
            <button type="submit" value="Eliminar interprete">Eliminar interprete</button>
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
    </main>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>