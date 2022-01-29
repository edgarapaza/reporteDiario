<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/estilo.css">
	<title>Ingresos Caja</title>
</head>
<body>
	
	<header>
		<h1>Archivo Regional puno</h1>
		<h3>Area de Informatica y Tecnologia</h3>
	</header>
	<hr/>
	<section>
		<h2>Impresion de Hoja de Recursos Directamente Recaudados</h2>
		<strong>Indicaciones:</strong><br/>
			<ol>
				<li>Use el Calendario que se encuentra abajo, y Seleccione la fecha que desea imprimir los reportes y haga click en la Fecha.</li>
				<li>Asegurese que sea la fecha correcta antes de imprimir el reporte.</li>
				<li>Si el programa presenta algunos problemas, comuniquese con algun personal del Area de Informatica y Tecnologia</li>
			</ol>
		<article>
			<h2>Formulario para la impresion de la HOJA DE INGRESOS</h2>
			<br><br>

				<form action="view/reportexcel.php" method="post">
					<span class="titulofecha">Seleccione la fecha:</span>
					<input type="date" name="fecha" id="fecha" />
					<button type="submit" name="imprimir" class="boton1" >Imprimir Hoja de Ingresos</button>
					<button type="button" onclick="verPdf()" class="boton1">Ver PDF</button>
				</form>
		</article>
	</section>
	
	<script type="text/javascript">
		function verPdf(){
			var dateControl = document.querySelector('input[type="date"]');
			location.href = "report.php?fecha="+dateControl.value;
			//alert(dateControl.value);
		}
	</script>

</body>
</html>