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
$sql = "SELECT c.id as id_cita, c.fecha as fecha,c.observacion as observacion, c.hora as hora, 
        d.nombre as nombre_doctor, d.apellido as apellido_doctor,
        d.especialidad as especialidad, p.nombre as nombre_cliente,
        p.apellido as apellido_cliente, p.documento as documento, co.numero as consultorio, p.id as id_usuario, c.estado as estado
        FROM citas c INNER JOIN pacientes p ON c.id_paciente=p.id 
                    INNER JOIN doctor d ON c.id_doctor=d.id
                    INNER JOIN consultorio co ON d.id_consultorio=co.id WHERE p.id = $id_usuario";
$resultado = mysqli_query($con, $sql);
$usuario = mysqli_fetch_assoc($resultado);

$pdf = new FPDF();
$pdf->AddPage();


$pdf->Image('../img/AJ.png', 100, 5, 40, 40);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(30,20, ' Clinica AJ', 0, 1);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 20, 'Informe del Paciente', 0, 1, 'C');
// Línea separadora
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY());
$pdf->Ln(10);
// Espacio
// Información del Paciente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informacion del Paciente', 0, 1);

$pdf->SetFont('Arial', '', 11);

$pdf->Cell(40, 10, 'Documento:', 0, 0);
$pdf->Cell(0, 10, $usuario['documento'], 0, 1);

$pdf->Cell(40, 10, 'Nombre:', 0, 0);
$pdf->Cell(0, 10, $usuario['nombre_cliente'], 0, 1);

$pdf->Cell(40, 10, 'Apellido:', 0, 0);
$pdf->Cell(0, 10, $usuario['apellido_cliente'], 0, 1);

$pdf->Cell(40, 10, 'Fecha de Cita:', 0, 0);
$pdf->Cell(0, 10, $usuario['fecha'], 0, 1);

$pdf->Cell(40, 10, 'Hora de Cita:', 0, 0);
$pdf->Cell(0, 10, $usuario['hora'], 0, 1);

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informacion del Medico', 0, 1);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 10, 'Doctor:', 0, 0);
$pdf->Cell(0, 10, $usuario['nombre_doctor'], 0, 1);

$pdf->Cell(40, 10, 'Especialidad:', 0, 0);
$pdf->Cell(0, 10, $usuario['especialidad'], 0, 1);

// Espacio
$pdf->Ln(10);
// Historial Médico
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 20, 'Historial Medico', 0, 1, 'C');

$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY());
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 10, $usuario['observacion']);


$pdf->Output('datos_cita.pdf', 'D');
// Cerrar la conexión a la base de datos



mysqli_close($con);
?>
