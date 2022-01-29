<?php
$fecha = $_REQUEST['fecha'];
if(empty($fecha)){

	header("location: ../index.php");
	
}else{

	#$fecha = '2021-11-24';
	require '../model/ingresos.php';
	$filename = "caja_".$fecha;
	$ingreso = new Ingresos();
	$data = $ingreso->Reporte($fecha);
	$total = $ingreso->Total($fecha);

?>
	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/tabla.css">
		<link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>

		<title>Report</title>
	</head>
	<body>
		
		<button type="button" class="btn btn-success" onclick="exportTableToExcel('tblData', '<?php echo $filename;?>')">Exportar la data a un Archivo en Excel</button>

		<table class="table" border="0" id='tableID'>
			<thead class="cabecera">
				<tr>
					<th colspan="6">REPORTE DIARIO DE INGRESOS - ARP</th>
				</tr>
				<tr>
					<td colspan="6">HOJA DE INGRESOS: RECURSOS DIRECTAMENTE RECAUDADOS</td>
				</tr>
				<tr>
					<td colspan="6">Fecha: <?php echo $fecha;?></td>
				</tr>
				<tr>
					<td colspan="6">PROGRAMA : 003 ADMINISTRACION</td>
				</tr>
				<tr>
					<td colspan="6">SUB PROGRAMA : 006 ADMINISTRACION GENERAL</td>
				</tr>
				<tr>
					<td colspan="6">ACTIVIDAD : 100498 CONSERVACION Y VIGILANCIA DE DOCUMENTOS</td>
				</tr>
				<tr>
					<td colspan="6">COMPONENTE : 30166 ARCHIVO REGIONAL PUNO</td>
				</tr>

				<tr>
					<td></td>
				</tr>
					
					
		
				<tr>
					<td width="10" class="titulos">Nro</td>
					<td class="titulos">Nro Recibo</td>
					<td class="titulos">Nro Solic</td>
					<td class="titulos">Concepto</td>
					<td class="titulos">Nombres y Apellidos</td>
					<td class="titulos">Total</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				while($fila = $data->fetch_array(MYSQLI_ASSOC)):
					$fila['anulado'];
					$fila['fecha'];
				?>
				<tr>
					<td class="datos"><?php echo $i;?></td>
					<td class="datos"><?php echo $fila['numRec'];?></td>
					<td class="datos"><?php echo $fila['numSol'];?></td>
					<td class="datos"><?php echo $fila['concepto'];?></td>
					<td class="datos"><?php echo $fila['nombres'];?></td>
					<td class="datos"><?php echo number_format($fila['total'], 2);?></td>
				</tr>
				<?php 
					$i++;
					endwhile;
				?>
				<tr>
					<td colspan="5" class="datos"><center>Total</center></td>
					<td  class="datos"><?php echo number_format($total['suma'],2);?></td>
				</tr>
			</tbody>
		</table>
	</form>


	<script type="text/javascript">
		function exportTableToExcel(tableID, filename = ''){
				
				var downloadLink;
				var dataType = 'application/vnd.ms-excel';
				var tableSelect = document.getElementById("tableID");
				var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
				
				// Specify file name
				filename = filename?filename+'.xls':'excel_data.xls';
				
				// Create download link element
				downloadLink = document.createElement("a");
				
				document.body.appendChild(downloadLink);
				
				if(navigator.msSaveOrOpenBlob){
					var blob = new Blob(['ufeff', tableHTML], {
						type: dataType
					});
					navigator.msSaveOrOpenBlob( blob, filename);
				}else{
					// Create a link to the file
					downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
				
					// Setting the file name
					downloadLink.download = filename;
					
					//triggering the function
					downloadLink.click();
				}
			}
	</script>

	</body>
	</html>
<?php

}
?>

