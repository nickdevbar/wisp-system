<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

	class reporte extends utilidad {

	

	public function con(){

		$this->que_dba="SELECT *
		FROM clientes cl,contratos co, detalles_contratos dc, planes pl
		WHERE cl.cod_cli = co.clientes_cod_cli
		AND dc.contratos_cod_contratos = co.cod_contratos
		AND dc.planes_cod_plan = pl.cod_plan
		AND  co.cod_contratos  ='".$this->cod_contratos."';";

		return $this->ejecutar();

	}

	

								
							
	
	} // Fin de clase
	
}else {
	header("location: ../../index.php");
	
}
?>