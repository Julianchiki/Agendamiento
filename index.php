<?php
session_start();
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamiento";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
  // Si el usuario no ha iniciado sesión, redirigirlo a la página de login
  header("Location: login.php");
  exit();
}

// Obtener el rol del usuario
$username = $_SESSION["username"];
$sql = "SELECT `roles`.`nombre` FROM `usuarios_roles`
        INNER JOIN `users` ON `usuarios_roles`.`id_usuario` = `users`.`id`
        INNER JOIN `roles` ON `usuarios_roles`.`id_rol` = `roles`.`id`
        WHERE `users`.`username`='$username'";
$result = mysqli_query($conn, $sql);
$rol = mysqli_fetch_assoc($result)["nombre"];

// Obtener los permisos del rol del usuario
$sql = "SELECT `permisos`.`nombre` FROM `roles_permisos`
        INNER JOIN `roles` ON `roles_permisos`.`id_rol` = `roles`.`id`
        INNER JOIN `permisos` ON `roles_permisos`.`id_permiso` = `permisos`.`id`
        WHERE `roles`.`nombre`='$rol'";
$result = mysqli_query($conn, $sql);
$permisos = array();
while ($row = mysqli_fetch_assoc($result)) {
  $permisos[] = $row["nombre"];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Página de inicio</title>
</head>
<body>
  <h2>Bienvenido <?php echo $_SESSION["username"]; ?></h2>
  <?php if (in_array("admin", $permisos)) { 
    header("Location: i.php");?>
  <?php } ?>
  <?php if (in_array("secre", $permisos)) { 
    header("Location: i.php");?>
  <?php } ?>
  <a href="login.php">Cerrar sesión</a>
</body>
</html>
