<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

// Función para obtener las opciones de un select desde la base de datos
function obtenerOpciones($tabla, $columna)
{
    global $dbcon;
    $opciones = '';

    $sql = "SELECT $columna FROM $tabla";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $opciones .= "<option value='" . $row[$columna] . "'>" . $row[$columna] . "</option>";
        }
    } else {
        $opciones = "<option value=''>No hay registros</option>";
    }

    return $opciones;
}

// Función para obtener el ID de un elemento de la base de datos
function obtenerID($tabla, $campo, $valor)
{
    global $dbcon;
    $sql = "SELECT id$tabla FROM $tabla WHERE $campo = :valor";
    $stmt = $dbcon->prepare($sql);
    $stmt->bindParam(':valor', $valor);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["id$tabla"];
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['titulo']) && isset($_POST['edicion_pelicula'])) {
        $titulo = $_POST['titulo'];
        $edicion = $_POST['edicion_pelicula'];
        $idpelicula = obtenerID('pelicula', 'titulo', $titulo);

        // Insertar los datos en la tabla de premios
        $sql_insert = "INSERT INTO o_pelicula (edicion, idpelicula)
                        VALUES (:edicion, :idpelicula)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':edicion', $edicion);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);
        $stmt_insert->execute();
    }

    if (isset($_POST['nombre_director']) && isset($_POST['edicion_director'])) {
        $titulo = $_POST['titulo'];
        $nombre_director = $_POST['nombre_director'];
        $edicion = $_POST['edicion_director'];
        $idpelicula = obtenerID('pelicula', 'titulo', $titulo);
        $iddirector = obtenerID('director', 'nombre', $nombre_director);

        // Insertar los datos en la tabla de premios
        $sql_insert = "INSERT INTO o_director (edicion, iddirector, idpelicula)
                        VALUES (:edicion, :iddirector, :idpelicula)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':edicion', $edicion);
        $stmt_insert->bindParam(':iddirector', $iddirector);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);
        $stmt_insert->execute();
    }

    if (isset($_POST['nombre_interprete']) && isset($_POST['edicion_interprete'])) {
        $nombre_interprete = $_POST['nombre_interprete'];
        $edicion_interprete = $_POST['edicion_interprete'];
        $titulo = $_POST['titulo'];
        $idpelicula = obtenerID('pelicula', 'titulo', $titulo);
        $idinterprete = obtenerID('interprete', 'nombre_inter', $nombre_interprete);

        $sql_insert = "INSERT INTO o_interprete (edicion, idinterprete, idpelicula)
                        VALUES (:edicion, :idinterprete, :idpelicula)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':edicion', $edicion_interprete);
        $stmt_insert->bindParam(':idinterprete', $idinterprete);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);
        $stmt_insert->execute();
    }

    if (isset($_POST['nombre_guion']) && isset($_POST['edicion_guion'])) {
        $nombre_guion = $_POST['nombre_guion'];
        $edicion_guion = $_POST['edicion_guion'];
        $titulo = $_POST['titulo'];
        $idpelicula = obtenerID('pelicula', 'titulo', $titulo);
        $idguion = obtenerID('guion', 'nombre_guion', $nombre_guion);

        $sql_insert = "INSERT INTO o_guion (edicion, idguion, idpelicula)
                        VALUES (:edicion, :idguion, :idpelicula)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':edicion', $edicion_guion);
        $stmt_insert->bindParam(':idguion', $idguion);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);
        $stmt_insert->execute();
    }


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
    <title>Alta de premios</title>
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
    </header>
    <form action="" method="post">
        <h2>Mejor Película</h2>
        <select id="titulo" name="titulo">
            <?php echo obtenerOpciones('pelicula', 'titulo'); ?>
        </select>
        <label for="edicion_pelicula">Edición:</label>
        <input type="number" id="edicion_pelicula" name="edicion_pelicula"><br>

        <h2>Mejor Director</h2>
        <select id="nombre_director" name="nombre_director">
            <?php echo obtenerOpciones('director', 'nombre'); ?>
        </select>
        <select id="titulo" name="titulo">
            <?php echo obtenerOpciones('pelicula', 'titulo'); ?>
        </select>
        <label for="edicion_director">Edición:</label>
        <input type="text" id="edicion_director" name="edicion_director"><br>

        <h2>Mejor Guión</h2>
        <select id="nombre_guion" name="nombre_guion">
            <?php echo obtenerOpciones('guion', 'nombre_guion'); ?>
        </select>
        <select id="titulo" name="titulo">
            <?php echo obtenerOpciones('pelicula', 'titulo'); ?>
        </select>
        <label for="edicion_guion">Edición:</label>
        <input type="text" id="edicion_guion" name="edicion_guion"><br>

        <h2>Mejor Intérprete</h2>
        <select id="nombre_interprete" name="nombre_interprete">
            <?php echo obtenerOpciones('interprete', 'nombre_inter'); ?>
        </select>
        <select id="titulo" name="titulo">
            <?php echo obtenerOpciones('pelicula', 'titulo'); ?>
        </select>
        <label for="edicion_interprete">Edición:</label>
        <input type="text" id="edicion_interprete" name="edicion_interprete"><br>

        <input type="submit" value="Agregar Premios">
    </form>

    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>