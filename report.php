<?php
require 'fpdf.php';

$fecha = $_REQUEST['fecha'];

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont("Arial",'BU',12);
$pdf->Cell(188,10,'HOJA DE INGRESOS:  RECURSOS DIRECTAMENTE RECAUDADOS',0,1,'C');
$pdf->SetFont("Arial",'',9);
//Cabecera de la Aplicacion
$pdf->Cell(160,10,'FECHA   :  '.$fecha,0,1,'R');
$pdf->Cell(10,5,'PROGRAMA                     : 003 ADMINISTRACION',0,1,'L');
$pdf->Cell(10,5,'SUB PROGRAMA             : 006 ADMINISTRACION GENERAL',0,1,'L');
$pdf->Cell(10,5,'ACTIVIDAD                       : 100498 CONSERVACION Y VIGILANCIA DE DOCUMENTOS',0,1,'L');
$pdf->Cell(10,5,'COMPONENTE                : 30166 ARCHIVO REGIONAL PUNO',0,1,'L');
//
//Cabecera de la Tabla
//
#0080C0
$pdf->Ln(5);	
//$pdf->SetDrawColor(0,128,192);  // color de Linea
$pdf->SetFillColor(230,230,0);
$pdf->Cell(10,10,'Nro',1,0,'C');
$pdf->Cell(19,10,'Nro Recibo',1,0,'C');
$pdf->Cell(19,10,'Nro Solicitud',1,0,'C');
$pdf->Cell(35,10,'Concepto',1,0,'C');
$pdf->Cell(80,10,'Nombres y Apellidos',1,0,'C');
$pdf->Cell(20,10,'Total',1,1,'C');
//
//Consulta a Mysql
//
	$conn = new mysqli("192.168.0.73","usuario", "archivo123$", "recepcion");
	$conn->set_charset("utf8");

	// Realizar una consulta MySQL
	$sql = "SELECT r.numRec, r.numSol, r.total, r.fecha, d.concepto, CONCAT(u.nombre,' ',u.apePat,' ',apeMat) as nombres, r.anulado FROM recibo as r, detallerecibo as d , solicitudes as s, usuarios as u WHERE s.codUsu = u.codUsu and r.numSol = s.codSol and r.numRec = d.numRecibo and r.fecha LIKE '".$fecha."%' GROUP BY r.numRec;";
	$result = $conn->query($sql);

	$i =1;
	while ($line = $result->fetch_array()) {
		
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

	// Consulta para la Suma de todos los totales
	$suma = "SELECT sum(r.total) AS suma FROM recibo as r WHERE r.fecha LIKE '".$fecha."%';";
	$resultSuma = $conn->query($suma);
	
	$sumaTotal = $resultSuma->fetch_array();
	// Liberar resultados
	//mysql_free_result($result);


	// Imprime la suma total
	$pdf->SetFont("Arial",'B',12);
	$pdf->Cell(163,10,'Total',0,0,'R'); // total
	$pdf->Cell(20,10,round($sumaTotal[0],2),1,1,'C'); // total

	#Cierra la conexion
	$conn->close();

	$pdf->Footer();
$pdf->Output();
?>