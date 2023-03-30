<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/login.css">
    <title>Registrase</title>
</head>
<body>
    <div class="container"  style="height: 700px">
    <form action="" method="post">
        <div class="form">
            <h2>Registro</h2>
            <div class="input">
                <input type="text" name="documento" required="required">
                <span>N° Documento</span>
                <i></i>
            </div>
            <div class="input">
                <input type="text" name="nom_user" required="required">
                <span>Nombres</span>
                <i></i>
            </div>
            <div class="input">
                <input type="text" name="apellido_user" required="required">
                <span>Apellidos</span>
                <i></i>
            </div>
            <div class="input">
                <input type="number" name="phone" required="required">
                <span>Teléfono</span>
                <i></i>
            </div>
            <div class="input">
                <input type="email" name="email" required="required">
                <span>Email</span>
                <i></i>
            </div>
            <div class="input">
                <input type="password" name="contrasena" required="required">
                <span>Contraseña</span>
                <i></i>
            </div>
            <div class="input">
                <input type="text" name="username" required="required">
                <span>Username</span>
                <i></i>
            </div>
            <div class="link">                
            </div>
                <input class="boton" type="submit" name="registrar" value="Registrarme" style="width: 150px">
        </div>
    </div>
    
    <?php
          $conexion = mysqli_connect('localhost', 'root', '', 'agendamiento');
          if(isset($_POST['registrar'])){
            $documento=$_POST['documento'];
            $nombre_user=$_POST['nom_user'];
            $username=$_POST['username'];
            $apellido_user=$_POST['apellido_user'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $contrasena=$_POST['contrasena'];
                   
            $query=mysqli_query($conexion, "INSERT INTO usuario(identificacion, username, contrasena, nombre, apellido, telefono, correo, id_rol) 
            VALUES ('$documento', '$username', '".password_hash($contrasena, PASSWORD_DEFAULT)."', '$nombre_user','$apellido_user','$phone', '$email', 2)");

            if($query){
                echo "<script> alert('Registro exitoso')
                location.href = 'login.php';</script>";
              } else {
              echo "Error: " . $query . "<br>" . mysqli_error($conexion);
            }
            
            
            mysqli_close($conexion);
              
            }
          ?>
          </form>
</body>
</html>