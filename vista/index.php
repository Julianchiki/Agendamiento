<?php
include_once '../modelo/conexionuno.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "SELECT * FROM doctor";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$doctor = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
include "../modelo/config.php";

$sql = $con->query("SELECT * FROM usuario");
?>
<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  header("Location: ../login.php");
  exit();
}elseif($_SESSION['logged_in'] && $_SESSION['user_role'] =='2' ){
  echo '<header>';
  echo '<div class="container_nav">';
  echo '<p class="logo">Agendamiento!</p>';
  echo '<nav>';
  echo '<a href="consulta.php" style="text-decoration:none;">Consulta</a>';
  echo '<a href="../modelo/logout.php" style="text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i></a>';

  echo '</nav>';
  echo '</div>';
  echo '</header>';
  
} else {
  echo '<header>';
  echo '<div class="container_nav">';
  echo '<p class="logo">Agendamiento!</p>';
  echo '<nav>';
  echo '<a href="index.php" style="text-decoration:none;">Agendar</a>';
  echo '<a href="../index.php" style="text-decoration:none;">Citas</a>';
  echo '<a href="consulta.php" style="text-decoration:none;">Consulta</a>';
  echo '<a href="../rol.php" style="text-decoration:none;">Usuarios</a>';
  echo '<a href="../modelo/logout.php" style="text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i></a>';

  echo '</nav>';
  echo '</div>';
  echo '</header>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agendamiento</title>
    <!--Iconos-->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="manifest" href="../img/site.webmanifest">

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/6364639265.js" crossorigin="anonymous"></script>


    <!--css-->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
 
 <div class="container">
  <div class="form">
  <form action="" method="post">
    <?php  foreach ($sql as $id){ ?>
      <input class="id_user" type="number" name="id" id="id" value="<?php echo $id['id'] ?>">
      <?php } ?>
    <label>#Documento usuario:</label>
    <input type="number" name="documento" id="documento">
    <label>Nombres usuario:</label>
    <input type="text" name="nom_user" id="nom_user">
    <label>Apellidos usuario:</label>
    <input type="text" name="apellido_user" id="apellido_user">
    <label>Teléfono:</label>
    <input type="number" name="phone" id="phone">
    <label>Correo:</label>
    <input type="email" name="email" id="email">
    <label>Nombres doctor:</label>
    <select class="form-control" name="doctor">
            <option id="doctor">---Seleccione---</option>
            <?php
              foreach ($doctor as $doc){
                ?>
                <option><?php echo $doc['id']?> <?php echo $doc['nombre']?> <?php echo $doc['apellido'] ?></option>
                <?php
              }
              ?>
          </select>       
    <label>Fecha:</label>
    <input type="date" name="fecha" id="fecha">
    <label>Hora:</label>
    <input type="time" name="hora" id="hora">

    <input class="boton" type="submit" name="agendar" value="Agendar">
    <?php
          $conexion = mysqli_connect('localhost', 'root', '', 'agendamiento');
          if(isset($_POST['agendar'])){
            $documento=$_POST['documento'];
            $nombre_user=$_POST['nom_user'];
            $apellido_user=$_POST['apellido_user'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $doctor=$_POST['doctor'];
            $fecha=$_POST['fecha'];
            $hora=$_POST['hora'];
              
            
            
            $query="INSERT INTO pacientes(documento, nombre, apellido) 
            VALUES ('$documento', '$nombre_user','$apellido_user')";

            if(mysqli_query($conexion, $query)){
              
              $id_paciente = mysqli_insert_id($conexion);

              $query2 = "SELECT COUNT(*) as count FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
              $res= mysqli_query($conexion, $query2);
              $row=mysqli_fetch_assoc($res);

              if($row['count'] == 0){
                $query2 = "INSERT INTO citas(fecha, hora, id_paciente, id_doctor) 
                VALUES ('$fecha', '$hora', '$id_paciente','$doctor')";
                  }
                  else{
                    
                    echo "<script> alert('Fecha y hora ya agendadas, agende cita en otro horario.')
                        location.href = '../vista/index.php';</script>";
              
              }
              if(mysqli_query($conexion,$query2)){
                echo "<script> alert('Registro exitoso')
                location.href = '../vista/index.php';</script>";
              }
              else{
                echo "Error: " . $query2 . "<br>" . mysqli_error($conexion);
              }
            } else {
              echo "Error: " . $query . "<br>" . mysqli_error($conexion);
            }
            
            
            mysqli_close($conexion);
              
            }
          ?>
  </form>
  </div>
 </div>


</body>
</html>