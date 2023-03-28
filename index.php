<?php
include "modelo/config.php";

$sql = $con->query("SELECT c.id as id_cita, c.fecha as fecha, c.hora as hora, 
                    d.nombre as nombre_doctor, d.apellido as apellido_doctor,
                    d.especialidad as especialidad, u.nombre as nombre_cliente,
                    u.apellido as apellido_cliente, u.identificacion as documento, co.numero as consultorio, u.id as id_usuario
                    FROM citas c INNER JOIN usuario u ON c.id_usuario=u.id 
                                 INNER JOIN doctor d ON c.id_doctor=d.id
                                 INNER JOIN consultorio co ON d.id_consultorio=co.id");
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
<header>
    <div class="container_nav">
      <p class="logo">Aprendices!</p>
      <nav>
        <a href="vista/index.php" style="text-decoration:none;">Agendar</a>
        <a href="index.php" style="text-decoration:none;">Citas</a>
        <a href="vista/consulta.php" style="text-decoration:none;">Consulta</a>

      </nav>
    </div>
    
  </header>
  <h1 class="title">Citas Agendadas</h1>
    <div class="container">
        <table id="agenda" class="table-striped table-bordered" style="width: 100%">
            <thead style="padding-right:50px">
                <tr>
                    <td># Cita</td>
                    <td>Doctor</td>
                    <td>Especialidad</td>
                    <td>Fecha</td>
                    <td>Hora</td>
                    <td>Nombres Cliente</td>
                    <td>Apellidos Cliente</td>
                    <td>Documento cliente</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody style="padding-right:50px">
                <?php foreach($sql as $agenda){?>
              <tr>
                  <td><?php echo $agenda['id_cita']?></td>
                  <td><?php echo $agenda['nombre_doctor']?> <?php echo $agenda['apellido_doctor']?></td>
                  <td><?php echo $agenda['especialidad']?></td>   
                  <td><?php echo $agenda['fecha']?></td>
                  <td><?php echo $agenda['hora']?></td>    
                  <td><?php echo $agenda['nombre_cliente']?></td>        
                  <td><?php echo $agenda['apellido_cliente']?></td>        
                  <td><?php echo $agenda['documento']?></td>
                     <!-- Button trigger modal -->
                    <td>
                      <button type="button" class="btn btn-primary editbtn" data-id="<?= $agenda['id_cita']?>" 
                         data-ndoctor="<?= $agenda['nombre_doctor']?>" data-adoctor="<?= $agenda['apellido_doctor']?>" 
                         data-espe="<?= $agenda['especialidad']?>" data-consul="<?= $agenda['consultorio']?>" 
                         data-fecha="<?= $agenda['fecha']?>" data-hora="<?= $agenda['hora']?>" data-ncliente="<?= $agenda['nombre_cliente']?>"
                         data-acliente="<?= $agenda['apellido_cliente']?>" data-docu="<?= $agenda['documento']?>" 
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
                    <form action="modelo/pdf.php" method="post">
                    <td>
                      <button type="submit" name="pdf" id="pdf" class="btn">
                        <i class="fa-solid fa-file-pdf"></i>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar cita</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="modelo/editar.php" method="post">
          <div class="form-group">
            <label >Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
          </div>
          <div class="form-group">
            <label>Hora</label>
            <input type="time" name="hora" id="hora" class="form-control">
          </div>
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
            <input type="hidden" name="iduser" id="iduser" class="form-control" ">
            <input type="hidden" name="id" id="id" class="form-control" ">
            <div class="modal-footer">
              <button name="edit" type="submit" class="btn btn-primary">Guardar Cambios</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
      var id = $(this).data('id');
      var iduser = $(this).data('iduser');
      var fecha = $(this).data('fecha');
      var hora = $(this).data('hora');
      var ncliente = $(this).data('ncliente');
      var acliente = $(this).data('acliente');
      var documento = $(this).data('docu');

      $('#id').val(id);
      $('#iduser').val(iduser);
      $('#fecha').val(fecha);
      $('#hora').val(hora);
      $('#ncliente').val(ncliente);
      $('#acliente').val(acliente);
      $('#docu').val(documento);

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