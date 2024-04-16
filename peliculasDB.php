<?php
require_once "funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname="peliculas";
$dbcon = conectaDB($dbname);

if(isset($dbcon)) {
    $dbTabla = "director";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
            iddirector INTEGER UNSIGNED NOT NULL,
            nombre VARCHAR(100),
            anyo_nacimiento YEAR,
            nacionalidad VARCHAR(50),
            PRIMARY KEY(iddirector)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "guion";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        idguion INTEGER UNSIGNED NOT NULL,
        titulo VARCHAR(100),
        autor VARCHAR(50),
        PRIMARY KEY(idguion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "pelicula";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        idpelicula INTEGER UNSGINED NOT NULL,
        titulo VARCHAR(100),
        anyo_produccion YEAR,
        nacionalidad VARCHAR(50),
        idremake INTEGER,
        iddirector INTEGER,
        idguion INTEGER,
        PRIMARY KEY(idpelicula),
        FOREIGN KEY(idremake) REFERENCES pelicula(idpelicula),
        FOREIGN KEY(iddirector) REFERENCES director(iddirector),
        FOREIGN KEY(idguion) REFERENCES guion(idguion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "interpretes";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
            idactor INTEGER UNSIGNED NOT NULL,
            nombre VARCHAR(100),
            anyo_nacimiento YEAR,
            nacionalidad VARCHAR(50),
            PRIMARY KEY(idactor)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "actua";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        idactor INTEGER UNSIGNED NOT NULL,
        idpelicula INTEGER UNSIGNED NOT NULL,
        PRIMARY KEY(idactor, idpelicula),
        FOREIGN KEY(idactor) REFERENCES interpretes(idactor),
        FOREIGN KEY(idpelicula) REFERENCES pelicula(idpelicula)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "o_guion";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        edicion YEAR,
        PRIMARY KEY(edicion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "d_guion";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        edicion YEAR,
        PRIMARY KEY(edicion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "a_guion";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        edicion YEAR,
        PRIMARY KEY(edicion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);

    $dbTabla = "p_guion";
    $consulta = "CREATE TABLE IF NOT EXISTS $dbTabla (
        edicion YEAR,
        PRIMARY KEY(edicion)
    )";
    creatabla($dbcon, $dbTabla, $consulta);
}