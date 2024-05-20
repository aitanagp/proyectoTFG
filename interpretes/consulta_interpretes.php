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


        <?php echo "<h2>Peliculas</h2>"; ?>
        <br><br>
</body>

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
    echo "<table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Año de nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Imagen</th>
                </tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                    <td>" . $row["nombre_inter"] . "</td>
                    <td>" . $row["anyo_nacimiento"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                  </tr>";
    }
    echo "</table>";
    $dbcon = null;
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