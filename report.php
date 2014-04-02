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
	$link = mysql_connect('192.168.1.100', 'usuario', 'archivo123') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
	mysql_select_db('recepcion') or die('No se pudo seleccionar la base de datos');

	// Realizar una consulta MySQL
	$query = "SELECT r.numRec, r.numSol,r.total, r.fecha, d.concepto, CONCAT(u.nombre,' ',u.apePat,' ',apeMat) as nombres FROM recibo as r, detallerecibo as d , solicitudes as s, usuarios as u WHERE s.codUsu = u.codUsu and r.numSol = s.codSol and r.numRec = d.numRecibo and r.fecha LIKE '".$fecha."%' GROUP BY r.numRec;";
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

	$i =1;
	while ($line = mysql_fetch_array($result)) {

	    $pdf->Cell(10,6,$i,1,0,'C');  //Numeracion
		$pdf->Cell(19,6,$line[0],1,0,'C'); //Recibo
		$pdf->Cell(19,6,$line[1],1,0,'C'); //Solicitud
		$pdf->Cell(35,6,$line[4],1,0,'L'); //concepto
		$pdf->Cell(80,6,$line[5],1,0,'L'); // Nombres
		$pdf->Cell(20,6,$line[2],1,1,'C'); // total
		$i++;
	}

	// Consulta para la Suma de todos los totales
	$suma = "SELECT sum(r.total) AS suma FROM recibo as r WHERE r.fecha LIKE '".$fecha."%';";
	$resultSuma = mysql_query($suma) or die('Suma Fallida: ' . mysql_error());
	$sumaTotal = mysql_fetch_array($resultSuma);
	// Liberar resultados
	mysql_free_result($result);
	// Cerrar la conexión
	mysql_close($link);
	// Imprime la suma total
	$pdf->SetFont("Arial",'B',12);
	$pdf->Cell(163,10,"Total",0,0,'R'); // total
	$pdf->Cell(20,10,$sumaTotal[0],1,1,'C'); // total

	$pdf->Footer();
$pdf->Output();
?>