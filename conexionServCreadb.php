<?php
define("MYSQL_HOST", "mysql:host=localhost"); //nombre host mysql
define("MYSQL_USER", "root"); //usuario mysql
define("MYSQL_PASSWORD", ""); //pass de mysql

function conectaSerDB() {
    try {
        $tmp = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
        $tmp->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tmp->exec("set names utf8mb4";)
        return $tmp;
    } catch (PDOException $e) {
        echo "<p> Error: No puede conectarse a la base de daos. <p>";
        echo "<p> Error: " . $e->getMessage() . "<p>";
        exit();
    }
}

$dbcon = conectaSerDB();

if (isset($dbcon)) {
    $dbname = "peliculas"; //nombre de la base de datos

    $consultaCreaDB = "CREATE DATABASE $dbname
                        CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci";

    try {
        $dbcon->query($consultaCreaDB);
        print "<p>Base de datos '$dbname' creada correctamente. <p>";
    } catch (PDOException $e) {
        print "<p> Error al crear la base de datos '$dbname'. <p>\n";
        echo "Código de error: ", $dbcon->errorCode(), "<br>";
        echo "Mensaje de error: ", $e->getMessage();
    }
}
?>