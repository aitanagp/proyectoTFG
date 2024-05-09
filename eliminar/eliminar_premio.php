<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

if (isset($dbcon)) {
    if (isset($_GET['id']) && isset($_GET['tipo'])) {
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
                exit; // Salir del script si el tipo de premio no es válido
        }

        // Consulta para eliminar el premio según el tipo
        $sql_eliminar = "DELETE FROM $tabla WHERE $columna_id = :id";
        $stmt_eliminar = $dbcon->prepare($sql_eliminar);
        $stmt_eliminar->bindParam(':id', $id);

        if ($stmt_eliminar->execute()) {
            echo "El premio se eliminó correctamente.";
        } else {
            echo "Hubo un error al eliminar el premio.";
        }
    } else {
        echo "Falta el ID o el tipo de premio.";
    }

    $dbcon = null;
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
