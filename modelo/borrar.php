<?php
$conexion = mysqli_connect("localhost", "root", "", "agendamiento");

$id = $_POST["id_user"];

$sql = "DELETE FROM usuario WHERE id=$id";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
  echo "<script>
    Swal.fire(
      '¡Registro borrado!',
      '',
      'success'
    )
    location.href='../index.php';
  </script>";
} else {
  echo "<script>
    Swal.fire(
      'Ha ocurrido un error',
      'El registro no ha sido borrado.',
      'error'
    )
  </script>";
}
if($resultado){
    mysqli_query($conexion, "ALTER TABLE citas AUTO_INCREMENT=1");
    mysqli_query($conexion, "ALTER TABLE usuario AUTO_INCREMENT=1");
    header("Location: ../index.php");
    exit();
}
else{
    echo "<script>
    Swal.fire(
      'Ha ocurrido un error',
      'El registro no ha sido borrado.',
      'error'
    )
  </script>";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
