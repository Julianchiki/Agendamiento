<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container">
        <form action="modelo/log.php" method="post">
        <div class="form">
            <h2>Inicio Sesión</h2>
            <div class="input">
                <input type="text" name="username" required="required">
                <span>Usuario</span>
                <i></i>
            </div>
            <div class="input">
                <input type="password" name="contrasena" required="required">
                <span>Contraseña</span>
                <i></i>
            </div>
            <div class="link">
                <a href="#">Olvidaste tu contraseña?</a>
                <a href="registrarse.php">Registrase</a>
            </div>
            <input type="submit" name="iniciar" value="Ingresar">
        </div>

    </form>
    </div>
</body>
</html>