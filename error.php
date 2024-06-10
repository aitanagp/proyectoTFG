<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ERROR ACCESO</title>
</head>
<body>
    <main>
        <h1>NO TIENES PERMISOS DE ADMINISTRADOR</h1>
        <p>Prueba a iniciar sesión con otro usuario</p>
        <?php
            //Refresca esta página ne 5seg y redirige a index
            header("refresh:5;url=index.php");
        ?>
    </main>
</body>
</html>