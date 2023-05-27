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
                    <td>Estado</td>
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
                  <td><?php echo $agenda['estado']?></td>
                     <!-- Button trigger modal -->
                    <td>
                      <button type="button" class="btn btn-primary editbtn" data-id="<?= $agenda['id_cita']?>" 
                         data-ndoctor="<?= $agenda['nombre_doctor']?>" data-adoctor="<?= $agenda['apellido_doctor']?>" 
                         data-espe="<?= $agenda['especialidad']?>" data-consul="<?= $agenda['consultorio']?>" 
                         data-fecha="<?= $agenda['fecha']?>" data-hora="<?= $agenda['hora']?>" data-ncliente="<?= $agenda['nombre_cliente']?>"
                         data-acliente="<?= $agenda['apellido_cliente']?>" data-docu="<?= $agenda['documento']?>" 
                         data-iduser="<?= $agenda['id_usuario'] ?>"  data-observacion="<?= $agenda['observacion'] ?>"
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
                      <input type="hidden" id="id_user" name="id_user" value="<?= $agenda['id_usuario']; ?>">
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