<?php
require 'fpdf.php';
require 'model/ingresos.php';

$fecha = $_REQUEST['fecha'];
#$fecha = '2021-11-30';

$ingreso = new Ingresos();
$data = $ingreso->Reporte($fecha);
$total = $ingreso->Total($fecha);



class PDF extends FPDF
{
    function Header()
    {
        // Logo
        
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Ln();
        
        $this->Cell(0,10,'REPORTE DIARIO DE INGRESOS - ARP',0,0,'C');        
        // Line break
        $this->Ln();
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
		$this->AliasNbPages();
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

#$pdf=new FPDF();
/** Rotar hoja en horizontal */
$pdf=new PDF('P','mm','A4');
$pdf->AddPage();
/* ENCABEZADO */
$pdf->SetFontSize(14);
$pdf->SetFont('Arial','B');
$pdf->Ln();

$pdf->Cell(0,5,'HOJA DE INGRESOS:  RECURSOS DIRECTAMENTE RECAUDADOS',0,1,'C');
$pdf->SetFont("Arial",'',9);
//Cabecera de la Aplicacion
$pdf->Cell(160,10,'FECHA   :  '.$fecha,0,1,'R');
$pdf->Cell(10,5,'PROGRAMA                     : 003 ADMINISTRACION',0,1,'L');
$pdf->Cell(10,5,'SUB PROGRAMA             : 006 ADMINISTRACION GENERAL',0,1,'L');
$pdf->Cell(10,5,'ACTIVIDAD                       : 100498 CONSERVACION Y VIGILANCIA DE DOCUMENTOS',0,1,'L');
$pdf->Cell(10,5,'COMPONENTE                : 30166 ARCHIVO REGIONAL PUNO',0,1,'L');

$pdf->Ln(5);	
//$pdf->SetDrawColor(0,128,192);  // color de Linea
$pdf->SetFillColor(230,230,0);
$pdf->Cell(10,10,'Nro',1,0,'C');
$pdf->Cell(19,10,'Nro Recibo',1,0,'C');
$pdf->Cell(19,10,'Nro Solicitud',1,0,'C');
$pdf->Cell(35,10,'Concepto',1,0,'C');
$pdf->Cell(80,10,'Nombres y Apellidos',1,0,'C');
$pdf->Cell(20,10,'Total',1,1,'C');

$i =1;
while ($line = $data->fetch_array()) {
	
	if($line[6] == 1)
	{
		$pdf->Cell(10,6,$i,1,0,'C');  //Numeracion
		$pdf->Cell(19,6,$line[0],1,0,'C'); //Recibo
		$pdf->Cell(19,6,$line[1],1,0,'C'); //Solicitud
		$pdf->Cell(35,6,'ANULADO',1,0,'L'); //concepto
		$pdf->Cell(80,6,$line[5],1,0,'L'); // Nombres
		$pdf->Cell(20,6,$line[2],1,1,'C'); // total
	}
	else
	{
		$pdf->Cell(10,6,$i,1,0,'C');  //Numeracion
		$pdf->Cell(19,6,$line[0],1,0,'C'); //Recibo
		$pdf->Cell(19,6,$line[1],1,0,'C'); //Solicitud
		$pdf->Cell(35,6,$line[4],1,0,'L'); //concepto
		$pdf->Cell(80,6,$line[5],1,0,'L'); // Nombres
		$pdf->Cell(20,6,$line[2],1,1,'C'); // total
	}
	$i++;
}


	$pdf->SetFont("Arial",'B',12);
	$pdf->Cell(163,10,'Total',0,0,'R'); // total
	$pdf->Cell(20,10,round($total['suma'],2),1,1,'C'); // total

$pdf->Footer();
$pdf->Output();

?>