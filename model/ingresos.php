<?php
require "Conexion.php";

class Ingresos
{
    private $conn;
    function __construct(){
        $this->conn = new Conexion();
        return $this->conn;
    }

    public function Reporte($fecha)
    {
        $sql = "SELECT r.numRec, r.numSol, r.total, r.fecha, d.concepto, CONCAT(u.nombre,' ',u.apePat,' ',apeMat) as nombres, r.anulado FROM recibo as r, detallerecibo as d , solicitudes as s, usuarios as u WHERE s.codUsu = u.codUsu and r.numSol = s.codSol and r.numRec = d.numRecibo and r.fecha LIKE '$fecha%' GROUP BY r.numRec";
        
        $result = $this->conn->ConsultaCon($sql);

        return $result;
    }

    public function Total($fecha)
    {
        $sql = "SELECT sum(r.total) AS suma FROM recibo as r WHERE r.fecha LIKE '".$fecha."%';";
 
        $result = $this->conn->ConsultaArray($sql);
        return $result;
    }
    
}