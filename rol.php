<?php
include_once 'modelo/conexionuno.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "SELECT * FROM rol";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$rol = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
include "modelo/config.php";

$sql = $con->query("SELECT u.nombre as nombre_cliente, u.apellido as apellido_cliente, 
                           u.identificacion as documento, u.id as id_usuario, r.id as id_rol, r.nombre as rol
                           FROM usuario u INNER JOIN rol r ON r.id=u.id_rol");
?>

<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
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
if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] && array_key_exists('user_role', $_SESSION) && $_SESSION['user_role'] =='1') {
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

if(!isset($_SESSION)){
  header("Location: ../login.php");
} 
?>

  <h1 class="title">Citas Agendadas</h1>
    <div class="container">
        <table id="agenda" class="table-striped table-bordered" style="width: 100%">
            <thead style="padding-right:50px">
                <tr>
                    <td>Nombres</td>
                    <td>Apellidos</td>
                    <td>Documento</td>
                    <td>Rol</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="padding-right:50px">
                <?php foreach($sql as $agenda){?>
              <tr>
                  <td><?php echo $agenda['nombre_cliente']?></td>        
                  <td><?php echo $agenda['apellido_cliente']?></td>        
                  <td><?php echo $agenda['documento']?></td>
                  <td><?php echo $agenda['rol']?></td>
                     <!-- Button trigger modal -->
                    <td>
                      <button type="button" class="btn btn-primary editbtn" data-ncliente="<?= $agenda['nombre_cliente']?>"
                         data-acliente="<?= $agenda['apellido_cliente']?>" data-docu="<?= $agenda['documento']?>" data-rol="<?= $agenda['rol']?>"
                         data-iduser="<?= $agenda['id_usuario'] ?>"
                         data-bs-toggle="modal" data-bs-target="#exampleModal">
                         <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                    </td>
                    <form action="modelo/borrar.php" method="post">                
                      <td>
                      <input type="hidden" id="id_user" name="id_user" value="<?= $agenda['id_usuario']; ?>">
                        <button type="button" onclick="borrarRegistro()" id="borrar"  class="btn btn-danger">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </td>
                    </form>
                    <script>
                      function borrarRegistro(){
                        Swal.fire({
                          title: "Estas seguro?",
                          text: "No se podra revertir la acción",
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: "Si, eliminar",
                          cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
              document.forms[0].submit();
        }
        })
    };
</script>
                </tr>
                <?php } ?>
              </tbody>
        </table>
    </div>
   

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="modelo/editrol.php" method="post">
          <div class="form-group">
            <label>Nombre cliente</label>
            <input type="text" name="ncliente" id="ncliente" class="form-control">
          </div>
          <div class="form-group">
            <label>Apellido cliente</label>
            <input type="text" name="acliente" id="acliente" class="form-control" ">
          </div>
          <div class="form-group">
            <label>Documento cliente</label>
            <input type="number" name="docu" id="docu" class="form-control" ">
          </div>
          <div class="form-group">
            <label>Rol</label>
            <select type="text" name="rol" id="rol" class="form-control" >
              <?php
              foreach ($rol as $r){
                ?>
                <option><?php echo $r['id']?> <?php echo $r['nombre']?></option>
                <?php
              }
              ?>
            </select>
          </div>
            <input type="hidden" name="iduser" id="iduser" class="form-control" ">
            <div class="modal-footer">
              <button name="edit" type="submit" class="btn btn-primary">Guardar Cambios</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>  
        </form>
          </div>
          
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.editbtn').click(function() {
      var iduser = $(this).data('iduser');
      var ncliente = $(this).data('ncliente');
      var acliente = $(this).data('acliente');
      var documento = $(this).data('docu');
      var rol = $(this).data('rol');

      $('#iduser').val(iduser);
      $('#ncliente').val(ncliente);
      $('#acliente').val(acliente);
      $('#docu').val(documento);
      $('#rol').val(rol);

    });
});
</script>


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