<?php
require('../fpdf/fpdf.php');

$id_usuario = $_POST['id_user'];

// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'agendamiento';
$con = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

// Verificar si la conexión fue exitosa
if (!$con) {
  die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Obtener los datos del usuario
$sql = "SELECT c.id as id_cita, c.fecha as fecha, c.hora as hora, 
        d.nombre as nombre_doctor, d.apellido as apellido_doctor,
        d.especialidad as especialidad, u.nombre as nombre_cliente,
        u.apellido as apellido_cliente, u.identificacion as documento, co.numero as consultorio, u.id as id_usuario, c.estado as estado
        FROM citas c INNER JOIN usuario u ON c.id_usuario=u.id 
                    INNER JOIN doctor d ON c.id_doctor=d.id
                    INNER JOIN consultorio co ON d.id_consultorio=co.id WHERE u.id = $id_usuario";
$resultado = mysqli_query($con, $sql);
$usuario = mysqli_fetch_assoc($resultado);

$pdf = new FPDF();
$pdf->AddPage();


$pdf->Image('../img/AJ.png', 100, 5, 40, 40);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(30,20, ' Clinica AJ', 0, 1);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(10, 10, ' Datos del Paciente', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10,' Documento: ' . $usuario['documento'], 0, 1);
$pdf->Cell(0, 10, ' Nombre: ' . $usuario['nombre_cliente'], 0, 1);
$pdf->Cell(0, 10, ' Apellido: ' . $usuario['apellido_cliente'], 0, 1);
$pdf->Cell(0, 10, ' Fecha Cita: ' . $usuario['fecha'], 0, 1);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, ' Datos del Doctor', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, ' Doctor: ' . $usuario['nombre_doctor'], 0, 1);
$pdf->Cell(0, 10, ' especialidad: ' . $usuario['especialidad'], 0, 1);
$pdf->SetDrawColor(128, 128, 128);
$pdf->Line(10, 30, 100, 30);  
$pdf->Line(100,30, 100, 110);
$pdf->Line(10,110, 10, 30);
$pdf->Line(10,110, 100, 110);        
$pdf->SetXY(50, 60,);
$pdf->Cell(0, 10, ' Hora Cita: ' . $usuario['hora'], 0, 1);
$pdf->Output('datos_usuario.pdf', 'D');
// Cerrar la conexión a la base de datos



mysqli_close($con);
?>
