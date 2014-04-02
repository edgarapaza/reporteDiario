<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hoja de Ingresos</title>
	<script src="js/modernizr.custom.06716.js"></script>

	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient {
	       filter: none;
	    }
	  </style>
	<![endif]-->
	<header>
		<h1>Archivo Regional puno</h1>
		<h3>Area de Informatica y Tecnologia</h3>
	</header>
	<hr/>
	<section>
		<h2>Impresion de Hoja de Recursos Directamente Recaudados</h2>
		<p>
			<strong>Indicaciones:</strong><br/>
			<ol>
				<li>Use el Calendario que se encuentra abajo, y Seleccione la fecha que desea imprimir los reportes y haga click en la Fecha.</li>
				<li>Asegurese que sea la fecha correcta antes de imprimir el reporte.</li>
				<li>Si el programa presenta algunos problemas, comuniquese con algun personal del Area de Informatica y Tecnologia</li>
			</ol>
		</p>
		<article>
			<h2>Formulario para la impresion de la HOJA DE INGRESOS</h2>
			<br><br>

				<form action="report.php">
					<span id="fecha">Seleccione la fecha:</span>
					<input type="date" name="fecha" id="fecha" />
					<button type="submit" name="imprimir" id="imprimir" >Imprimir Hoja de Ingresos</button>
				</form>	
		</article>
	</section>
	<footer class="site-footer">
		
	</footer>
</body>
</html>