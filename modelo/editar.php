<?php
$conexion = mysqli_connect('localhost', 'root', '', 'agendamiento');
$documento=$_POST['docu'];
$nombre_user=$_POST['ncliente'];
$apellido_user=$_POST['acliente'];

$id_user=$_POST['iduser'];
$fecha=$_POST['fecha'];
$date=$_POST['hora'];
$observacion = isset($_POST['observacion']) ? $_POST['observacion'] : null;
$estado=$_POST['estado'];

              
mysqli_begin_transaction($conexion); 

$query="UPDATE pacientes p, citas c SET p.documento='$documento', p.nombre='$nombre_user', 
p.apellido='$apellido_user', c.fecha='$fecha', c.hora='$date', c.estado='$estado' ";

if ($observacion !== null) {
    $query .= ", c.observacion='$observacion'";
}

$query .= " WHERE p.id=$id_user AND c.id_paciente=$id_user";

$resultado= mysqli_query($conexion, $query);

if ($resultado) {
    mysqli_commit($conexion);
    echo "<script> alert('Los datos se han actualizado correctamente.')
    location.href= '../index.php';</script>";
    } else {
    mysqli_rollback($conexion);
    echo "<script> alert('Ha ocurrido un error al actualizar los datos.')
    location.href= '../index.php';</script>";
    }

    mysqli_close($conexion);

?>