<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamiento";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  
  // Insertar los datos en la base de datos
  $sql = "INSERT INTO `users` (`username`, `password`, `email`) VALUES ('$username', '$password', '$email')";
  mysqli_query($conn, $sql);
  
  // Redirigir al usuario a la página de login
  header("Location: ../login.php");
  exit();
}
?>
