<!DOCTYPE html>
<html lang="es">

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
                    <li><a href="director/consulta_directores.php">Consulta de directores</a></li>
                    <li><a href="peliculas/consulta_director.php">Por nombre</a></li>
                    <li><a href="director/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
                    <li><a href="director/consulta_nacimiento_director.php">Por fecha de nacimiento</a></li>
                    <li><a href="director/consulta_premios_director.php">Por premios recibidos</a></li>
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

    <main>
        <h2>Películas Recientes</h2>
        <div class="peliculas">
            <?php
            require_once "funciones.php";
            $ruta = obtenerdirseg();
            require_once $ruta . "conectaDB.php";

            $dbname = "mydb";
            $dbcon = conectaDB($dbname);
            $consulta = "SELECT titulo, imagen
                        FROM pelicula 
                        ORDER BY anyo_prod DESC LIMIT 5";
            $stmt = $dbcon->prepare($consulta);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='pelicula'>";
                    echo "<h3>" . $fila['titulo'] . "</h3>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($fila['imagen']) . "' alt='Imagen pelicula' width='100' title='" . $fila['titulo'] . "'>";
                    echo "</div>";
                }
            }
            ?>
        </div>

        <br>

        <h2>Actores</h2>
        <div class='interpretes'>
            <?php
            $consulta_actores = "SELECT nombre_inter, imagen
                        FROM interprete 
                        ORDER BY nombre_inter DESC LIMIT 5";
            $stmt = $dbcon->prepare($consulta_actores);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='interprete'>";
                    echo "<h3>" . $fila['nombre_inter'] . "</h3>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($fila['imagen']) . "' alt='Imagen interprete' width='100' title='" . $fila['nombre_inter'] . "'>";
                    echo "</div>";
                }
            }
            ?>
        </div>


    </main>
    <footer>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>