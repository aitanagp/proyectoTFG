<?php
function obtenerdirseg(){
    $raizWeb = $_SERVER['DOCUMENT_ROOT'];
    $roto = explode('/', $raizWeb);
    $roto[sizeof($roto)-1]="";
    $rutaSeguridad=implode("/", $roto). "seguridad/";

    return $rutaSeguridad;
}

function creatabla($dbcon, $dbTabla, $consulta) {
    try {
        $stmt = $dbcon->query($consulta);
        print "<p>Tabla $dbTabla creada correctamente. <p> \n";
        print "\n";
    } catch (PDOException $e) {
        print "<p>Error al crear la tabla $dbTabla. <p>\n";
        print "Error: " . $e->getMessage() . "\n";
        print "Code: " . $e->getCode() . "\n";
        print "File: " . $e->getFile() . "\n";
        print "Line: " . $e->getLine() . "\n";
        print "\n";
    }
    return null;
}
?>