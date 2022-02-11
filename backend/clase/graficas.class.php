<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");


	class graficas extends utilidad {

public $idcompany;

	public function contrato_activo(){

			$this->que_dba="SELECT COUNT(idcontratos) AS n
			FROM `contratos` WHERE estatus_idestatus='1'; ";

		return $this->ejecutar();

	}

		public function contrato_inactivo(){

			$this->que_dba="SELECT COUNT(idcontratos) AS n
			FROM `contratos` WHERE estatus_idestatus='2'; ";

		return $this->ejecutar();

	}

		public function contrato_deuda(){

			$this->que_dba="SELECT COUNT(idcontratos) AS n,SUM(deuda) AS deuda_total, lista_cobro.*
			FROM `contratos`, lista_cobro
			 WHERE 
			 contratos.idcontratos=lista_cobro.contratos_idcontratos
			 AND lista_cobro.deuda>0
			 AND contratos.estatus_idestatus='1'; ";

		return $this->ejecutar();

	}

		public function registrado_micuenta()
		{

			$this->que_dba = "SELECT COUNT(*) AS t FROM usuario_cliente uc, contratos c, clientes cl
								WHERE uc.contratos_idcontratos = c.idcontratos
								AND cl.idclientes = c.clientes_idclientes
								AND c.estatus_idestatus = '1' ; ";

			return $this->ejecutar();
		}

		public function registrado_micuenta_leer()
		{

			$this->que_dba = "SELECT * FROM usuario_cliente uc, contratos c, clientes cl
								WHERE uc.contratos_idcontratos = c.idcontratos
								AND cl.idclientes = c.clientes_idclientes
								AND c.estatus_idestatus = '1' ; ";

			return $this->ejecutar();
		}

	public function total_recaudado_mensual(){

			$this->que_dba="SELECT MonthName(fecha_creacion) AS mes,
					YEAR(fecha_creacion) AS actual, 
                    count(*) AS total_pagos, 
                    SUM(monto) AS total_recaudado 
                    FROM pagos 
                    WHERE estatus_contable_idestatus_contable='1'
                    AND YEAR(fecha_creacion)=year(curdate()) GROUP by mes  ORDER BY month(fecha_creacion) DESC; ";

		return $this->ejecutar();

	}


	public function planes(){

			$this->que_dba="SELECT 
			contratos.*, 
			detalles_contratos.*,
			planes.*,
			count(*) AS cantidad
			FROM 
			contratos,
			detalles_contratos,
			planes
			WHERE 
			contratos.idcontratos=detalles_contratos.contratos_idcontratos
			AND detalles_contratos.planes_idplanes=planes.idplanes
			AND contratos.estatus_idestatus='1' 
			GROUP by nombre_plan ORDER BY cantidad DESC; ";

		return $this->ejecutar();

	}

	public function fecha_corte(){
		$this->que_dba= "SELECT * , COUNT(dia_fec_corte) AS dia_pago
					FROM contratos c, fecha_corte fc, clientes cl
					WHERE c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
					AND cl.cod_cli = c.clientes_cod_cli
					AND cl.estatus_clientes_cod_est_cli='1'
					AND cl.company_cod_company = '".$_SESSION['company']."'

					GROUP BY fc.dia_fec_corte;";

		return $this->ejecutar();
	}


	public function tipo_instalacion(){
		$this->que_dba= "SELECT *, COUNT(ti.nom_tipo_ins) AS total 
		FROM contratos c, tipo_instalacion ti, clientes cl
		WHERE c.tipo_instalacion_cod_tipo_ins = ti.cod_tipo_ins
		AND c.clientes_cod_cli = cl.cod_cli
		AND cl.estatus_clientes_cod_est_cli='1'
		AND cl.company_cod_company = '".$_SESSION['company']."'

		GROUP BY ti.nom_tipo_ins;";

		return $this->ejecutar();
	}

	

			public function instalacion_tecnico(){

			$this->que_dba= "SELECT MonthName(fec_contrato) AS mes,
			YEAR(fec_contrato) AS actual, 
                    count(*) AS total_instalacion, u.*
                    FROM contratos c, usuarios u, clientes cl 
                    WHERE cl.estatus_clientes_cod_est_cli='1'
                    AND c.usuarios_cod_usu = u.cod_usu
                    AND cl.cod_cli = c.clientes_cod_cli
					AND cl.company_cod_company = '".$_SESSION['company']."'

                    AND YEAR(fec_contrato)=year(curdate()) GROUP by mes, nom_usu ORDER BY month(fec_contrato)  DESC; ";

			return $this->ejecutar();

		}

		public function listaMB()
		{

			$this->que_dba = "SELECT COUNT(dc.planes_cod_plan) AS total_usuarios, pl.nom_plan nom_plan, pl.pre_plan AS precio, pl.pre_plan * COUNT(dc.planes_cod_plan) AS total_por_plan
							 FROM contratos co, detalles_contratos dc, planes pl, clientes cl 
							 WHERE cl.estatus_clientes_cod_est_cli = 1 
							 AND co.clientes_cod_cli = cl.cod_cli
							 AND co.cod_contratos = dc.contratos_cod_contratos 
							 AND dc.planes_cod_plan = pl.cod_plan
							 AND cl.company_cod_company = '".$_SESSION['company']."'
							 GROUP BY pl.nom_plan 
							 ORDER BY total_usuarios DESC; ";

			return $this->ejecutar();
		}

		public function listaSector()
		{

			$this->que_dba = "SELECT DISTINCT nom_sector, COUNT(DISTINCT cl.cod_cli) AS total
							 FROM contratos c, clientes cl, sector s   
							 WHERE cl.estatus_clientes_cod_est_cli = '1'
                             AND c.clientes_cod_cli = cl.cod_cli
                             AND cl.sector_cod_sector = s.cod_sector
							 AND cl.company_cod_company = '".$_SESSION['company']."'
                             GROUP BY cl.cod_cli; ";

			return $this->ejecutar();
		}
		
		public function listaSegmento()
		{

			$this->que_dba = "SELECT DISTINCT si.seg_ip, COUNT(DISTINCT cl.cod_cli) AS total
							 FROM contratos c, clientes cl, detalles_contratos dc, segmentos_ip si, ips ip  
							 WHERE cl.estatus_clientes_cod_est_cli = '1'
                             AND c.clientes_cod_cli = cl.cod_cli
                             AND dc.contratos_cod_contratos = c.cod_contratos
                             AND dc.ips_cod_ip = ip.cod_ip
                             AND ip.segmentos_ip_cod_seg_ip = si.cod_seg_ip
							 AND cl.company_cod_company = '".$_SESSION['company']."'

                             GROUP BY si.cod_seg_ip; ";

			return $this->ejecutar();
		}
		

			public function total_recaudado_mensual_factura(){

			$this->que_dba= "SELECT COUNT(fa.cod_fac) AS total_factura, fa.mes_fac AS mes, SUM(pf.mon_pag_fac) AS monto_total 
				FROM factura fa, pago_factura pf
				WHERE fa.cod_fac=pf.factura_cod_fac
				AND fa.estatus_contable_cod_est_con = 2
				AND fa.company_cod_company = '".$_SESSION['company']."'

				GROUP BY fa.mes_fac; ";

			return $this->ejecutar();

		}

		

	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>