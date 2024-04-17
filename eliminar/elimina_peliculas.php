<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminación de Películas</title>
</head>
<body>
    <h1>Eliminación de Películas</h1>
    <form action="delete_pelicula.php" method="post">
        <label for="idpelicula">Selecciona una película:</label>
        <select name="idpelicula" id="idpelicula" required>
        <ul>
            <li><a href="datos_pelicula.php">Datos principales</a></li>
            <li><a href="datos_actores.php">Actores</a></li>
            <li><a href="datos_directores.php">Directores</a></li>
        </ul>
        </select><br>
        <button type="submit">Eliminar Película</button>
    </form>
</body>
</html>