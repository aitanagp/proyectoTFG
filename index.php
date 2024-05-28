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
        <div class="header-container">
            <img src="imagenes/logo.jpg" alt="Logo" class="logo">
            <div class="title">
                <h1>Base de Datos de Películas</h1>
            </div>
            <div class="login-container">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre de Usuario</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="peliculas/consulta_pelicula.php">Películas</a></li>
                <li><a href="interpretes/consulta_interpretes.php">Intérpretes</a></li>
                <li><a href="director/consulta_directores.php">Directores</a></li>
                <li><a href="premios/premios.php">Premios</a></li>
            </ul>
        </nav>
    </header>
    <br><br>
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
                        ORDER BY anyo_prod DESC LIMIT 6";
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
                        ORDER BY nombre_inter DESC LIMIT 6";
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