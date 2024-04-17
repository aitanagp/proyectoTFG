<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="titulo" onclick="toggleMenu('peliculasMenu')">Películas</h1>
    <ul id="peliculasMenu" class="menu">
        <li><a href="alta/alta_peliculas.php">Alta de Películas</a></li>
        <li><a href="eliminar/elimina_peliculas.php">Eliminación de Películas</a></li>
        <li><a href="consulta/consulta_peliculas.php">Consulta de Películas</a></li>
        <li><a href="consulta/consulta_fecha.php">Por fecha</a></li>
        <li><a href="consulta/consulta_director.php">Por director</a></li>
        <li><a href="consulta_nombre.php">Por nombre</a></li>
        <li><a href="consulta/consulta_actor.php">Por Actor</a></li>
        <li><a href="consulta_premios.php">Por premios recibidos</a></li>
    </ul>

    <h1 class="titulo" onclick="toggleMenu('actoresMenu')">Actores</h1>
    <ul id="actoresMenu" class="menu">
        <li><a href="alta/alta_actor.php">Alta de actores</a></li>
        <li><a href="eliminar/eliminar_actor.php">Eliminación de actores</a></li>
        <li><a href="consulta/busca_actor.php">Consulta de actores</a></li>
        <li><a href="consulta_nombre_actor.php">Por nombre</a></li>
        <li><a href="consulta_nacionalidad_actor.php">Por nacionalidad</a></li>
        <li><a href="consulta_nacimineto_actor.php">Por nacimiento</a></li>
        <li><a href="consulta_peliculas_actor.php">Por peliculas</a></li>
        <li><a href="consulta_premios_actor.php">Por premios recibidos</a></li>
    </ul>

    <script>
        function toggleMenu(menuId) {
            var menu = document.getElementById(menuId);
            menu.classList.toggle('visible');
        }
    </script>
</body>
</html>
