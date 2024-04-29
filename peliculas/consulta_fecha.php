<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas por año</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas por año</h1>
        </div>
    </header>
    <form action="" method="post">
        <label for="anyo">Buscar por año de producción:</label>
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
        $sql = "SELECT * FROM pelicula WHERE anyo_prod like :anyo";
        $stmt = $dbcon->prepare($sql);
        $stmt->bindParam(':anyo', $anyo);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>
            <tr>
                <th>ID Película</th>
                <th>Título</th>
                <th>Año de producción</th>
                <th>Nacionalidad</th>
                <th>ID Director</th>
                <th>ID Guion</th>
            </tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>" . $row["idpelicula"] . "</td>
                    <td>" . $row["titulo"] . "</td>
                    <td>" . $row["anyo_prod"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td>" . $row["iddirector"] . "</td>
                    <td>" . $row["idguion"] . "</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron películas para el año '$anyo'.";
        }

    }
}
?>
<br><br>
<footer>
    <li><a href="../index.php">Volver al menú</a></li>
    <p>© 2024 AGarcía. Todos los derechos reservados.</p>
</footer>