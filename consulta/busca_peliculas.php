<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas</title>
</head>
<body>
    <h1>Consulta de Películas</h1>
    <form action="busca_peliculas.php" method="get">
        <label for="buscar">Buscar por título:</label>
        <input type="text" name="buscar" id="buscar" required><br>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>