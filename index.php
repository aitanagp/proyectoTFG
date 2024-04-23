<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li>
                <input type="checkbox" id="peliculas">
                <label for="peliculas">Películas</label>
                <ul>
                    <li><a href="alta/alta_peliculas.php">Alta de Películas</a></li>
                    <li><a href="eliminar/elimina_peliculas.php">Eliminación de Películas</a></li>
                    <li><a href="peliculas/consulta_pelicula.php">Películas</a></li>
                        <li><a href="peliculas/consulta_fecha.php">Por Fecha</a></li>
                        <li><a href="peliculas/consulta_director.php">Por director</a></li>
                        <li><a href="peliculas/consulta_titulo.php">Por titulo</a></li>
                        <li><a href="peliculas/consulta_actor.php">Por Actor</a></li>
                        <li><a href="peliculas/consulta_premios.php">Por premios recibidos</a></li>
                </ul>
            </li>
            <li>
                <input type="checkbox" id="interpretes">
                <label for="interpretes">Intérpretes</label>
                <ul>
                    <li><a href="alta/alta_actor.php">Alta de actores</a></li>
                    <li><a href="eliminar/eliminar_actor.php">Eliminación de actores</a></li>
                    <li><a href="interpretes/consulta_interpretes.php">Interpretes</a></li>
                    <li><a href="peliculas/consulta_actor.php">Por nombre</a></li>
                    <li><a href="interpretes/consulta_nacionalidad_actor.php">Por nacionalidad</a></li>
                    <li><a href="interpretes/consulta_nacimineto_actor.php">Por nacimiento</a></li>
                    <li><a href="interpretes/consulta_peliculas_actor.php">Por peliculas</a></li>
                    <li><a href="interpretes/consulta_premios_actor.php">Por premios recibidos</a></li>
                </ul>
            </li>
            <li>
            <input type="checkbox" id="directores">
            <label for="directores">Directores</label>
            <ul>
                <li><a href="alta/alta_directores.php">Alta de directores</a></li>
                <li><a href="eliminar/eliminar_directores.php">Eliminación de directores</a></li>
                <li><a href="consulta/consulta_directores.php">Consulta de directores</a></li>
                <li><a href="consulta/consulta_nombre_director.php">Por nombre</a></li>
                <li><a href="consulta/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
                <li><a href="consulta/consulta_fecha_nacimiento_director.php">Por fecha de nacimiento</a></li>
                <li><a href="consulta/consulta_peliculas_dirigidas.php">Por películas dirigidas</a></li>
                <li><a href="consulta/consulta_premios_director.php">Por premios recibidos</a></li>
                <li><a href="consulta_datos_directores.php">Datos de directores</a></li>
            </ul>
        </li>
        <li>
            <input type="checkbox" id="premios">
            <label for="premios">Premios</label>
            <ul>
                <li><a href="alta/alta_premios.php">Alta de premios</a></li>
                <li><a href="eliminar/eliminar_premios.php">Eliminación de premios</a></li>
                <li><a href="asignacion_premios.php">Asignación de premios a cada película</a></li>
            </ul>
        </li>
        </ul>
    </nav>
        


</body>
</html>
