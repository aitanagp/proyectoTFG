<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

// Función para obtener las opciones de un select desde la base de datos
function obtenerOpciones($tabla, $columna) {
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
function obtenerID($tabla, $campo, $valor) {
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
    if(isset($_POST['titulo']) && isset($_POST['edicion'])) {
        $titulo = $_POST['titulo'];
        $edicion = $_POST['edicion'];
        $idpelicula = obtenerID('pelicula', 'titulo', $titulo);

        // Insertar los datos en la tabla de premios
        $sql_insert = "INSERT INTO o_pelicula (edicion, idpelicula)
                        VALUES (:edicion, :idpelicula)";
        $stmt_insert = $dbcon->prepare($sql_insert);
        $stmt_insert->bindParam(':edicion', $edicion);
        $stmt_insert->bindParam(':idpelicula', $idpelicula);
        $stmt_insert->execute();
    }

    if (isset($_POST['nombre_director']) && isset($_POST['edicion'])) {
        $titulo = $_POST['titulo'];
        $nombre_director = $_POST['nombre_director'];
        $edicion = $_POST['edicion'];
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
    
    <form action="" method="post">
        <h2>Mejor Película</h2>
        <select id="titulo" name="titulo">
            <?php echo obtenerOpciones('pelicula', 'titulo'); ?>
        </select>
        <label for="edicion">Edición:</label>
        <input type="number" id="edicion" name="edicion"><br>

        <h2>Mejor Director</h2>
        <select id="nombre_director" name="nombre_director">
            <?php echo obtenerOpciones('director', 'nombre'); ?>
        </select>
        <label for="edicion">Edición:</label>
        <input type="text" id="edicion" name="edicion"><br>

        <input type="submit" value="Agregar Premios">
    </form>

    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
