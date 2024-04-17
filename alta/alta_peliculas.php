<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Películas</title>
</head>
<body>
    <h1>Alta de Películas</h1>
    <form action="add_pelicula.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>
        <label for="anyo_produccion">Año de producción:</label>
        <input type="number" name="anyo_produccion" id="anyo_produccion" required><br>
        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" name="nacionalidad" id="nacionalidad" required><br>
        <label for="idremake">ID de remake:</label>
        <input type="number" name="idremake" id="idremake"><br>
        <label for="iddirector">ID de director:</label>
        <select name="iddirector" id="iddirector">
        </select><br>
        <label for="idguion">ID de guion:</label>
        <select name="idguion" id="idguion">
        </select><br>
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" required><br>
        <button type="submit">Añadir Película</button>
    </form>
</body>
</html>