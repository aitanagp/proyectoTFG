<?php
define("MYSQL_HOST", "mysql:host=localhost"); //nombre host mysql
define("MYSQL_USER", "root"); //usuario mysql
define("MYSQL_PASSWORD", ""); //pass de mysql

function conectaSerDB() {
    try {
        $tmp = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
        $tmp->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tmp->exec("set names utf8mb4");
        return $tmp;
    } catch (PDOException $e) {
        echo "<p> Error: No puede conectarse a la base de daos. <p>";
        echo "<p> Error: " . $e->getMessage() . "<p>";
        exit();
    }
}
?>