<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!------- Icono Pestaña ------>
   <link rel="shortcut icon" href="">

   <!------- bootstrap ------>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
   integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

   <!----- Poper bootstrap ----->

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
   integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <!----- CSS --->

    <link rel="stylesheet" type="text/css" href="../CSS/style.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="manifest" href="../img/site.webmanifest">

    <!--css-->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <!-- CSS only Booststrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="../datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
	
<!--fontawesome-->
<script src="https://kit.fontawesome.com/6364639265.js" crossorigin="anonymous"></script>


<!--font awesome con CDN-->  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" 
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  

<style>
	table.dataTable thead{
		background: linear-gradient(to right, #7B279E, #7B279E);
		color:white;
	}
    
</style>

</head>

<body>
<?php
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

    <center>
        <br>
<div id="container">
    <h2>Consulta de Paciente</h2>

<form action="" method="post">
    <table>
        <tr>
        <td><label>Señor Usuario Digite Su Numero De Documento Para Consulta</label><input type="text" name="ConsultaDocumento" 
        class="form-control" style="width: 100%"></td>
        </tr><br>
        <tr>
        <td colspan="2"><br><center><input type="submit" name="btn_consultar" value="Consultar" class="botonconsulta"></center>
        </td>
        </tr>
        <tr>
        <td colspan="2"></td>
    </table>
</form>
    
    <br>
    </center>

    <?php
    
    $url="../modelo/pdf.php";
    include_once "../modelo/conexioncrud.php";
    if(isset($_POST['btn_consultar']))
    {
        $identificacion = $_POST['ConsultaDocumento'];
        $existe =0;

        if($identificacion=="")
        {
            echo "<script> alert('Campo Obligatorio')
      location.href = '../vista/fconsulta.php';</script>";
        }
        else{
            $resultado = mysqli_query($conectar, "SELECT p.id as id_usuario, p.documento as identificacion, p.nombre as nombre, p.apellido as apellido, c.fecha as fecha, c.hora as hora, d.nombre as nombre_doctor, d.apellido as apellido_doctor, cu.numero as numero_consultorio FROM pacientes p  
            INNER JOIN citas c ON p.id=c.id_paciente
            INNER JOIN doctor d ON d.id=c.id_doctor
            INNER JOIN consultorio cu ON cu.id=d.id_consultorio
            WHERE documento = '$identificacion'");
            ?>
            
<form action='../modelo/pdf.php' method='post'>
<?php
            while($consulta = mysqli_fetch_array($resultado))
            {
                
                echo "
                <center><table id='andres' width='70%' border='1'>
                <thead>
                    <tr>
                        <td><center><b>N° Documento</b></center></td>
                        <td><center><b>Nombre</b></center></td>
                        <td><center><b>Apellido</b></center></td>
                        <td><center><b>Fecha Cita</b></center></td>
                        <td><center><b>Hora</b></center></td>
                        <td><center><b>Doctor</b></center></td>
                        <td><center><b>Apellido</b></center></td>
                        <td><center><b>Consultorio</b></center></td>
                        <td><center><b></b></center></td>
                        
                </thead>
                <tbody>
                
                    <tr>
                        <td><center>".$consulta['identificacion']."</center></td>
                        <td><center>".$consulta['nombre']."</center></td>
                        <td><center>".$consulta['apellido']."</center></td>
                        <td><center>".$consulta['fecha']."</center></td>
                        <td><center>".$consulta['hora']."</center></td>
                        <td><center>".$consulta['nombre_doctor']."</center></td>
                        <td><center>".$consulta['apellido_doctor']."</center></td>
                        <td><center>".$consulta['numero_consultorio']."</center></td>
                        <td>
                            
                                <input type='hidden' name='id_user' id='id_user' value='".$consulta['id_usuario']."'>
                                <button type='submit' name='pdf' id='pdf' class='btn'>
                                    <i class='fa-solid fa-file-pdf'></i>
                                </button>
                            
                        </td>
                    </tr>
                
                </tbody>
            </table></center>";

                $existe++;

            if($existe==0){
                echo "<script> alert('Numero de Documento digitado no existe en BD')
                location.href= '../vista/fconsulta.php';</script>";
            }
            

                
            }
            ?>
            </form>
            <?php
        }
    }


?>

</div>
<!-- jQuery, Popper.js, Bootstrap JS -->
 <!-- jQuery, Popper.js, Bootstrap JS -->
 <script src="../jquery/jquery-3.3.1.min.js"></script>
    <script src="../popper/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="../datatables/datatables.min.js"></script>    
     
    <!-- para usar botones en datatables JS -->  
    <script src="../datatables/Buttons-2.3.3/js/dataTables.buttons.min.js"></script>  
    <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
     
    <!-- código JS propìo-->    
    <script type="text/javascript" src="../js/main.js"></script>  
    <script>
	$(document).ready(function(){
	 $('#andres').DataTable();
	})
</script>
</body>
</html>
