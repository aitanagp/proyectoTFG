<?php
define("MYSQL_HOST", "mysql:host=localhost"); // Nombre de host MYSQL
define("MYSQL_USER", "root"); // Nombre de usuario de MySQL
define("MYSQL_PASSWORD", "root"); // Contraseña de usuario de MySQL

function conectaDB($db){
    try {
        $tmp=new PDO(MYSQL_HOST.";dbname=".$db, MYSQL_USER, MYSQL_PASSWORD);
        $tmp-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $tmp-> exec("set names utf8mb4");
        //echo "conexión realizada con exito";
        return($tmp);
    }catch(PDOException $e) {
        print "  <p>Error: No puede conectarse con la base de datos. <p>\n";
        print "  <p>Error: " . $e->getMessage() ."<p>\n";
        exit();
    }
    
}
