<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Guion</title>
</head>
<body>
    <h1>Alta de Guion</h1>
    <form action="add_guion.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required><br>
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" required><br>
        <button type="submit">Añadir Guion</button>
    </form>
</body>
</html>