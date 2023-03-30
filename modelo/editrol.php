<?php
$conexion = mysqli_connect('localhost', 'root', '', 'agendamiento');
$documento=$_POST['docu'];
$nombre_user=$_POST['ncliente'];
$apellido_user=$_POST['acliente'];
$rol=$_POST['rol'];


$id_user=$_POST['iduser'];

              
mysqli_begin_transaction($conexion); 

$query="UPDATE usuario u SET u.identificacion='$documento', u.nombre='$nombre_user', u.apellido='$apellido_user', u.id_rol='$rol' 
WHERE u.id=$id_user";

$resultado= mysqli_query($conexion, $query);

if ($resultado) {
    mysqli_commit($conexion);
    echo "<script> alert('Los datos se han actualizado correctamente.')
    location.href= '../rol.php';</script>";
    } else {
    mysqli_rollback($conexion);
    echo "<script> alert('Ha ocurrido un error al actualizar los datos.')
    location.href= '../rol.php';</script>";
    }

    mysqli_close($conexion);

?>