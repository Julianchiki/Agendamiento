<?php
session_start();



// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamiento";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = $conn->query("SELECT c.id as id_cita, c.fecha as fecha, c.hora as hora, c.estado as estado,c.observacion as observacion,
                    d.nombre as nombre_doctor, d.apellido as apellido_doctor,
                    d.especialidad as especialidad, p.nombre as nombre_cliente,
                    p.apellido as apellido_cliente, p.documento as documento, co.numero as consultorio, p.id as id_usuario
                    FROM citas c INNER JOIN pacientes p ON c.id_paciente=p.id 
                                 INNER JOIN doctor d ON c.id_doctor=d.id
                                 INNER JOIN consultorio co ON d.id_consultorio=co.id");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Listar</title>
    <!-- CSS only Booststrap -->
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/6364639265.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

     <!--datables CSS básico-->
     <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

        <style>
	table.dataTable thead{
		background: blueviolet;
		color:white;
	}
	</style>
</head>
<body>
<?php  
if ($_SESSION['logged_in'] && $_SESSION['user_role'] =='1'){
  echo '<header>';
  echo '<div class="container_nav">';
  echo '<p class="logo">Agendamiento!</p>';
  echo '<nav>';
  echo '<a href="./vista/index.php" style="text-decoration:none;">Agendar</a>';
  echo '<a href="index.php" style="text-decoration:none;">Citas</a>';
  echo '<a href="./vista/consulta.php" style="text-decoration:none;">Consulta</a>';
  echo '<a href="rol.php" style="text-decoration:none;">Usuarios</a>';
  echo '<a href="./modelo/logout.php" style="text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i></a>';

  echo '</nav>';
  echo '</div>';
  echo '</header>';
}

else if($_SESSION['logged_in'] && $_SESSION['user_role'] =='3'){
  echo '<header>';
  echo '<div class="container_nav">';
  echo '<p class="logo">Agendamiento!</p>';
  echo '<nav>';
  echo '<a href="./vista/index.php" style="text-decoration:none;">Agendar</a>';
  echo '<a href="index.php" style="text-decoration:none;">Citas</a>';
  echo '<a href="./vista/consulta.php" style="text-decoration:none;">Consulta</a>';
  echo '<a href="./modelo/logout.php" style="text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i></a>';

  echo '</nav>';
  echo '</div>';
  echo '</header>';

  echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
  echo '  <div class="modal-dialog">';
  echo '    <div class="modal-content">';
  echo '      <div class="modal-header">';
  echo '        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar cita</h1>';
  echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
  echo '      </div>';
  echo '      <div class="modal-body">';
  echo '        <form action="modelo/editar.php" method="post">';
  echo '          <div class="form-group">';
  echo '            <label>Fecha</label>';
  echo '            <input type="date" name="fecha" id="fecha" class="form-control">';
  echo '          </div>';
  echo '          <div class="form-group">';
  echo '            <label>Hora</label>';
  echo '            <input type="time" name="hora" id="hora" class="form-control">';
  echo '          </div>';
  echo '          <div class="form-group">';
  echo '            <label>Nombre cliente</label>';
  echo '            <input type="text" name="ncliente" id="ncliente" class="form-control">';
  echo '          </div>';
  echo '          <div class="form-group">';
  echo '            <label>Apellido cliente</label>';
  echo '            <input type="text" name="acliente" id="acliente" class="form-control">';
  echo '          </div>';
  echo '          <div class="form-group">';
  echo '            <label>Documento cliente</label>';
  echo '            <input type="number" name="docu" id="docu" class="form-control">';
  echo '          </div>';
  echo '          <div class="form-group">';
  echo '            <label>Estado de la cita</label>';
  echo '            <select name="estado" id="estado">';
  echo '              <option value="Activo">Activo</option>';
  echo '              <option value="Inactivo">Inactivo</option>';
  echo '            </select>';
  echo '          </div>';
  echo '          <input type="hidden" name="iduser" id="iduser" class="form-control">';
  echo '          <input type="hidden" name="id" id="id" class="form-control">';
  echo '          <div class="modal-footer">';
  echo '            <button name="edit" type="submit" class="btn btn-primary">Guardar Cambios</button>';
  echo '            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
  echo '          </div>';
  echo '        </form>';
  echo '      </div>';
  echo '    </div>';
  echo '  </div>';
  echo '</div>';
  include './vista/lista.php';

  }
else if($_SESSION['logged_in'] && $_SESSION['user_role'] =='4'){
  echo '<header>';
  echo '<div class="container_nav">';
  echo '<p class="logo">Agendamiento!</p>';
  echo '<nav>';
  echo '<a href="index.php" style="text-decoration:none;">Citas</a>';
  echo '<a href="./vista/consulta.php" style="text-decoration:none;">Consulta</a>';
  echo '<a href="./modelo/logout.php" style="text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i></a>';

  echo '</nav>';
  echo '</div>';
  echo '</header>';
  }
if(!isset($_SESSION)){
  header("Location: ../login.php");
}
?>
 
<!-- Modal -->
<?php  
if ($_SESSION['logged_in'] && ($_SESSION['user_role'] == '4' || $_SESSION['user_role'] == '1')) {
  echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
echo '  <div class="modal-dialog">';
echo '    <div class="modal-content">';
echo '      <div class="modal-header">';
echo '        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar cita</h1>';
echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
echo '      </div>';
echo '      <div class="modal-body">';
echo '        <form action="modelo/editar.php" method="post">';
echo '          <div class="form-group">';
echo '            <label>Fecha</label>';
echo '            <input type="date" name="fecha" id="fecha" class="form-control">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Hora</label>';
echo '            <input type="time" name="hora" id="hora" class="form-control">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Nombre cliente</label>';
echo '            <input type="text" name="ncliente" id="ncliente" class="form-control">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Apellido cliente</label>';
echo '            <input type="text" name="acliente" id="acliente" class="form-control">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Documento cliente</label>';
echo '            <input type="number" name="docu" id="docu" class="form-control">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Observacion medica:</label>';
echo '            <input type="text" name="observacion" id="observacion" class="expandible-input">';
echo '          </div>';
echo '          <div class="form-group">';
echo '            <label>Estado de la cita</label>';
echo '            <select name="estado" id="estado">';
echo '              <option value="Activo">Activo</option>';
echo '              <option value="Inactivo">Inactivo</option>';
echo '            </select>';
echo '          </div>';
echo '          <input type="hidden" name="iduser" id="iduser" class="form-control">';
echo '          <input type="hidden" name="id" id="id" class="form-control">';
echo '          <div class="modal-footer">';
echo '            <button name="edit" type="submit" class="btn btn-primary">Guardar Cambios</button>';
echo '            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
echo '          </div>';
echo '        </form>';
echo '      </div>';
echo '    </div>';
echo '  </div>';
echo '</div>';
include './vista/lista2.php';


}else{

}
?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <!-- jQuery, Popper.js, Bootstrap JS -->
 <!-- jQuery, Popper.js, Bootstrap JS -->
     <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
   <!-- datatables JS -->
   <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
	 <!-- para usar botones en datatables JS -->  
	 <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
	 <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>    
	 <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
	 <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
	 <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
	  
	 <!-- código JS propìo-->    
	 <script type="text/javascript" src="lib_js/main.js"></script>  
     <script src="sweetalert2/sweetalert2.all.min.js"></script>    
    
</body>
</html>
