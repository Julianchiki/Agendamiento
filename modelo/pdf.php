<?php
require('../pdf/fpdf.php');




class PDF extends FPDF {
  // Define el encabezado del PDF
  function Header() {
    // Logo
    $this->Image('../img/messi.jpg',10,6,30);
    // Fuente
    $this->SetFont('Arial','B',15);
    // Mover a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Paciente',1,0,'C');
    // Salto de línea
    $this->Ln(20);
  }

  // Define el cuerpo del PDF
  function Body() {
    include_once '../modelo/conexionuno.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();


    $consulta = "SELECT c.id as id_cita, c.fecha as fecha, c.hora as hora, 
    d.nombre as nombre_doctor, d.apellido as apellido_doctor,
    d.especialidad as especialidad, u.nombre as nombre_cliente,
    u.apellido as apellido_cliente, u.identificacion as documento, co.numero as consultorio, u.id as id_usuario
    FROM citas c INNER JOIN usuario u ON c.id_usuario=u.id 
                INNER JOIN doctor d ON c.id_doctor=d.id
                INNER JOIN consultorio co ON d.id_consultorio=co.id";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $sql = $resultado->fetchAll(PDO::FETCH_ASSOC);

    // Agrega texto
    $this->SetFont('Times','',12);
    $this->Cell(25,10, 'Doctor' ,1);
    $this->Cell(25,10, 'Especialidad' ,1);
    $this->Cell(25,10, 'Fecha' ,1);
    $this->Cell(25,10, 'Hora' ,1);
    $this->Cell(25,10, 'Nombre Paciente' ,1);
    $this->Cell(25,10, 'Apellido Paciente' ,1);
    $this->Cell(25,10, 'Documento' ,1);
}

  // Define el pie de página del PDF
  function Footer() {
    // Posición a 1,5 cm del final
    $this->SetY(-15);
    // Fuente
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
  }
}

// Crear instancia de PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Body();
$pdf->Output();
?>
