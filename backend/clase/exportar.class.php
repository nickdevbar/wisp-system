<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

	class exportar extends utilidad {
		public function serverEnv()
		{
			$this->que_dba = "SELECT * FROM routers WHERE cod_router = '" . $this->cod_router1 . "' AND company_cod_company ='" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		public function serverRec()
		{
			$this->que_dba = "SELECT * FROM routers WHERE cod_router = '" . $this->cod_router2 . "' AND company_cod_company ='" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		//////////////////////////

		public function IP()
		{

			$this->que_dba = "SELECT * FROM contratos c, clientes cl, detalles_contratos dc, planes p, ips ip
	WHERE c.clientes_cod_cli = cl.cod_cli
	AND cl.estatus_clientes_cod_est_cli = 1
	AND dc.contratos_cod_contratos = c.cod_contratos
	AND dc.planes_cod_plan = p.cod_plan
	AND ip.cod_ip = dc.ips_cod_ip
	AND c.routers_cod_router = '".$this->cod_router1."'
	AND cl.company_cod_company = '".$_SESSION['company']."' ;";

			return $this->ejecutar();
		}

		public function SEG()
		{

			$this->que_dba = "SELECT * FROM segmentos_ip
 WHERE routers_cod_router = '" . $this->cod_router1 . "'
 AND company_cod_company ='" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		public function BLIST()
		{

			$this->que_dba = "SELECT * FROM contratos c, detalles_contratos dc, clientes cl, fecha_corte fc, ips ip, routers r, factura f
			WHERE c.clientes_cod_cli = cl.cod_cli
			AND c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
			AND dc.contratos_cod_contratos = c.cod_contratos
			AND r.cod_router = c.routers_cod_router
			AND ip.cod_ip = dc.ips_cod_ip
			AND f.contratos_cod_contratos = c.cod_contratos
			AND f.estatus_contable_cod_est_con != 1 
			AND r.cod_router = '" . $this->cod_router1 . "'
			AND r.company_cod_company = '" . $_SESSION['company'] . "'
			GROUP BY c.cod_contratos;";

			return $this->ejecutar();
		}

		public function routers()
		{

			$this->que_dba = "SELECT * FROM routers WHERE company_cod_company = '".$_SESSION['company']."';";

			return $this->ejecutar();
		}
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>
