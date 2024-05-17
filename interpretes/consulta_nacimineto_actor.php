<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas</h1>
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
    <br><br>
    <form action="" method="post">
        <label for="anyo">Buscar por año de nacimiento:</label>
        <input type="number" name="anyo" id="anyo" required><br>
        <button type="submit">Buscar</button>
    </form>
</body>

</html>

<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

if (isset($dbcon)) {
    if (isset($_POST['anyo'])) {
        $anyo = $_POST['anyo'];

        $sql = "SELECT nombre_inter, anyo_nacimiento, imagen 
        FROM interprete WHERE anyo_nacimiento = :anyo";

        $stmt = $dbcon->prepare($sql);

        $stmt->bindParam(':anyo', $anyo);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Actor</th>
                        <th>Año nacimiento</th>
                        <th>Imagen</th>
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . $row["nombre_inter"] . "</td>
                        <td>" . $row["anyo_nacimiento"] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontró ninguna película con el año de nacimiento";
        }
        $dbcon = null;
    }
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
<br><br>
<footer>
    <li><a href="../index.php">Volver al menú</a></li>
    <p>© 2024 AGarcía. Todos los derechos reservados.</p>
</footer>
</body>

</html>