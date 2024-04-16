<?php
function obtenerdirseg(){
    $raizWeb = $_SERVER['DOCUMENT_ROOT'];
    $roto = explode('/', $raizWeb);
    $roto[sizeof($roto)-1]="";
    $rutaSeguridad=implode("/", $roto). "seguridad/";

    return $rutaSeguridad;
}

function creatabla($dbcon, $dbTabla, $consulta) {
    if($dbcon->query($consulta)){
        print "<p>Tabla $dbTabla creada correctamente. <p> \n";
        print "\n";
    } else {
        print "<p>Error al crear la tabla $dbTabla. <p>\n";
        echo "<br>PDO::errorInfo():<br>";
        echo $dbcon->errorInfo([1], " - ", $dbcon->errorInfo()[2]);
        print "\n";
    }
    return null;
}
?>