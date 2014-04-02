<?php

$link = mysql_connect('192.168.1.100', 'usuario', 'archivo123') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
	mysql_select_db('recepcion') or die('No se pudo seleccionar la base de datos');

	// Realizar una consulta MySQL
	$query = "SELECT r.numRec, r.numSol,r.total, r.fecha, d.concepto, CONCAT(u.nombre,' ',u.apePat,' ',apeMat) as nombres FROM recibo as r, detallerecibo as d , solicitudes as s, usuarios as u WHERE s.codUsu = u.codUsu and r.numSol = s.codSol and r.numRec = d.numRecibo and r.fecha LIKE '2014-03-27%' GROUP BY r.numRec;";
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

	$i =1;
	while ($line = mysql_fetch_array($result)) {
	    echo $i;

	    $i++;
	}
	// Liberar resultados
	mysql_free_result($result);

	// Cerrar la conexión
	mysql_close($link);
	
?>