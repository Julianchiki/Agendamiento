<?php
session_start();
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamiento";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Procesar el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  // Verificar si el usuario y contraseña son correctos
  $sql = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'";
  $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) == 1) {
    // Iniciar sesión
    $_SESSION["username"] = $username;
    
    // Redirigir al usuario a la página de inicio
    header("Location: ../index.php");
    exit();
  } else {
    // Mostrar un mensaje de error
    echo "Usuario o contraseña incorrectos.";
  }
}
?>