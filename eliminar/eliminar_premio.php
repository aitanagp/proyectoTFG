<?php
//seguridad de session
session_start();
if(!isset($_SESSION['nombre']) || $_SESSION['nombre']!='Administrador'){
    echo "no tienes acceso";
    header("refresh:1;url=../index.php");
    die();
}
?>
<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

if (isset($dbcon)) {
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['tipo'])) {
        $id = $_GET['id'];
        $tipo = $_GET['tipo'];

        // Determinar la tabla y columna según el tipo de premio
        switch ($tipo) {
            case 'pelicula':
                $tabla = 'o_pelicula';
                $columna_id = 'idpelicula';
                break;
            case 'actor':
                $tabla = 'o_interprete';
                $columna_id = 'idinterprete';
                break;
            case 'guion':
                $tabla = 'o_guion';
                $columna_id = 'idguion';
                break;
            case 'director':
                $tabla = 'o_director';
                $columna_id = 'iddirector';
                break;
            default:
                echo "Tipo de premio no válido.";
                exit;
        }

        // Consulta para eliminar el premio según el tipo
        $sql_eliminar = "DELETE FROM $tabla WHERE $columna_id = :id";
        $stmt_eliminar = $dbcon->prepare($sql_eliminar);
        $stmt_eliminar->bindParam(':id', $id);

        if ($stmt_eliminar->execute()) {
            echo "El premio se eliminó correctamente.";
            echo "<br><br>";
            header("refresh:2;url=elimina_premios.php");
        } else {
            echo "Hubo un error al eliminar el premio.";
            header("refresh:2;url=elimina_premios.php");
        }
    } else {
        echo "Falta el ID o el tipo de premio.";
        header("refresh:2;url=elimina_premios.php");
    }

    $dbcon = null;
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
