<?php

 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");
require_once("funciones_api.class.php");


	class ips extends utilidad {

	public $idips;
	public $ip_contrato;
	public $segmentos_ip_idsegmentos_ip;
	public $estatus_idestatus;
	public $usuarios_idusuarios;

	public $limit;

	//Extras 

	public $idsegmentos_ip;
	public $segmento;
	public $comentario;
	//public $usuarios_idusuarios;
	public $server_idserver;
	public $company_idcompany;


	public $old;
	public $neu;
	
	public $old_ip;
	public $new_ip;
	
	public $contrato;
	public $des_aud;
		
	public function routerConnect(){

		$this->que_dba="SELECT * FROM routers
		WHERE company_cod_company = '".$_SESSION['company']."'
		AND cod_router = '".$this->cod_router."';";
	return $this->ejecutar();
	
	}

		public function listar(){

		$this->que_dba="SELECT *  
		FROM ips 
		WHERE estatus_idestatus='".$this->estatus_idestatus."';";

		return $this->ejecutar();

	}

	public function segmentosxRouter(){

		$this->que_dba="SELECT * FROM segmentos_ip WHERE company_cod_company = '".$_SESSION['company']."'
		AND routers_cod_router = '".$this->cod_router."';";

		return $this->ejecutar();

	}

	public function listarDisponible(){

		$this->que_dba="SELECT *  
		FROM ips 
		WHERE estatus_idestatus= '5' ";

		return $this->ejecutar();

	}

	public function listarSegemento(){

		$this->que_dba="SELECT * FROM segmentos_ip si, server s  
   					    WHERE s.idserver = si.server_idserver";

		return $this->ejecutar();

	}

	public function mostrarSector(){

		$this->que_dba= "SELECT * FROM segmentos_ip si, server s, sector sc  
   					    WHERE s.idserver = si.server_idserver
   					    AND si.sector_cod_sec = sc.cod_sec
						AND sc.cod_sec = '".$this->cod_sec."';";

		return $this->ejecutar();

	}

	public function listarSegementoCodigo(){

		$this->que_dba="SELECT * FROM segmentos_ip si, server s  
   					    WHERE s.idserver = si.server_idserver
   					    AND si.server_idserver = '".$this->server_idserver."';";

		return $this->ejecutar();

	}

	public function eliminarSegmento(){

		$this->que_dba="DELETE FROM segmentos_ip
		 WHERE cod_seg_ip = '".$this->cod_seg_ip."'
		 AND company_cod_company = '".$_SESSION['company']."';";

		 echo "se borro satisfactoriamente";
		return $this->ejecutar();

	}


	public function listarServidores(){

		$this->que_dba="SELECT *  FROM server";

		return $this->ejecutar();

	}

	public function infoSegmento(){

		$this->que_dba= "SELECT *  FROM segmentos_ip, routers
		WHERE cod_seg_ip = '".$this->cod_seg_ip."'
		AND routers_cod_router = cod_router ";

		return $this->ejecutar();

	}

	public function insertarSegmento(){

		$this->que_dba="INSERT INTO segmentos_ip (seg_ip, com_seg_ip, int_seg_ip, company_cod_company, routers_cod_router) VALUES
		 ('".$this->seg_ip."', 
		 '".$this->com_seg_ip."', 
		 '".$this->int_seg_ip."', 
		 '".$_SESSION['company']."', 
		 '".$this->routers_cod_router."')";

			$obj_api = new funciones_api;
			$obj_api->ip = $this->seg_ip;
			$obj_api->net = $this->net;
			$obj_api->com = $this->com_seg_ip;
			$obj_api->int = $this->int_seg_ip;

			$obj_api->ip_router_api = $this->ip_api;
			$obj_api->login_api = $this->lo_api;
			$obj_api->password_api = $this->pa_api;
			$obj_api->port_api = $this->po_api;
			$obj_api->blacklist = $this->bl_api;
			$obj_api->whitelist = $this->wl_api;

			$obj_api->asignar_valor_api();
			$obj_api->connect();
			$obj_api->add_segmento();

		return $this->ejecutar();

	}

	public function addRules(){

			$obj_api = new funciones_api;
			
			$obj_api->ip_router_api = $this->ip_api;
			$obj_api->login_api = $this->lo_api;
			$obj_api->password_api = $this->pa_api;
			$obj_api->port_api = $this->po_api;
			$obj_api->blacklist = $this->bl_api;
			$obj_api->whitelist = $this->wl_api;

			$obj_api->asignar_valor_api();
			$obj_api->connect();
			$obj_api->crearReglasObl();

			return $this->ejecutar();

	}

	public function cambiarSeg(){
			$this->que_dba = "UPDATE segmentos_ip 
						SET 
						seg_ip = '" . $this->seg_ip . "',
						com_seg_ip = '" . $this->com_seg_ip . "',
						int_seg_ip = '" . $this->int_seg_ip . "'
						WHERE cod_seg_ip = '" . $this->cod_seg_ip . "';";

			$obj_api = new funciones_api;
			$obj_api->ip = $this->old_seg;
			$obj_api->new_ip = $this->seg_ip;
			$obj_api->com = $this->com_seg_ip ;
			$obj_api->int = $this->int_seg_ip ;

			$obj_api->ip_router_api = $this->ip_api;
			$obj_api->login_api = $this->lo_api;
			$obj_api->password_api = $this->pa_api;
			$obj_api->port_api = $this->po_api;
			$obj_api->blacklist = $this->bl_api;
			$obj_api->whitelist = $this->wl_api;

			$obj_api->asignar_valor_api();
			$obj_api->connect();
			$obj_api->edit_segmento();
			
			$this->ejecutar();
	}

	

	public function insertarIP(){

		$this->que_dba="INSERT INTO ips (ip_contrato, company_cod_company, segmentos_ip_cod_seg_ip, estatus_cod_est) VALUES
		 ('".$this->ip_contrato."', 
		 '".$_SESSION['company']."', 
		 '".$this->segmentos_ip_cod_seg_ip."', 
		 '5')";

		 echo '1';

		return $this->ejecutar();

	}
	
	public function filtrar()
		{
			
			$filtro1=($this->estatus_idestatus!="" && $this->limit!='')?"* FROM ips WHERE estatus_idestatus='".$this->estatus_idestatus."' limit 10; "
			:"* FROM menu_link WHERE grupo_menu_idgrupo_menu='".$this->grupo_menu_idgrupo_menu."' ORDER BY nombre_link ASC ";
			$this->que_dba="SELECT $filtro1;";
		return $this->ejecutar();
		} /// FIN FILTRAR

		public function verIpDisponible()
		{
			$this->que_dba = "SELECT * FROM ips ip, segmentos_ip sp, sector s
 				WHERE ip.segmentos_ip_idsegmentos_ip = sp.idsegmentos_ip
 				AND s.cod_sec = sp.sector_cod_sec";

			return $this->ejecutar();
		}

		public function listarIpCod()
		{
			$this->que_dba = "SELECT * FROM ips ip, segmentos_ip sp, sector s, contratos c, detalles_contratos dc, clientes cl, datos_habitacion hb
 						WHERE ip.segmentos_ip_idsegmentos_ip = sp.idsegmentos_ip
 						AND s.cod_sec = sp.sector_cod_sec
 						AND c.idcontratos = dc.contratos_idcontratos
 						AND dc.ips_idips = ip.idips
 						AND cl.idclientes = c.clientes_idclientes
 						AND hb.clientes_idclientes = cl.idclientes
 						AND c.idcontratos = '".$this->idcontratos."';";

			return $this->ejecutar();
		}

		public function listarIpDc()
		{
			$this->que_dba = "SELECT * FROM ips ip, segmentos_ip sp, sector s, contratos c, clientes cl, datos_habitacion hb
 						WHERE ip.segmentos_ip_idsegmentos_ip = sp.idsegmentos_ip
 						AND s.cod_sec = sp.sector_cod_sec
 						AND cl.idclientes = c.clientes_idclientes
 						AND hb.clientes_idclientes = cl.idclientes
 						AND s.cod_sec = hb.sector_cod_sec
						AND ip.estatus_idestatus = '5'
 						AND cl.idclientes = '".$this->idclientes."';";

			return $this->ejecutar();
		}

		public function listarIpSec()
		{
			$this->que_dba = "SELECT * FROM ips ip, segmentos_ip sp, sector s
 						WHERE ip.segmentos_ip_idsegmentos_ip = sp.idsegmentos_ip
 						AND s.cod_sec = sp.sector_cod_sec
 						AND ip.estatus_idestatus= '5'
						AND s.cod_sec = '".$this->cod_sec."';";

			return $this->ejecutar();
		}

		public function listarSector()
		{
			$this->que_dba = "SELECT * FROM sector";

			return $this->ejecutar();
		}

		public function cambiarIP()
		{
			//Inserta la auditoria
			$this->que_dba = "INSERT  INTO auditoria(des_aud,fec_aud,contratos_idcontratos,usuarios_idusuarios) 
				VALUES (
				'".$this->des_aud."',
        		Now(),
        		'".$this->contrato."',
        		'".$_SESSION['idusuarios']."'
        		); ";

			$this->ejecutar();

			//La regresa a que sea nueva
			
			$this->que_dba = "UPDATE ips 
						SET estatus_idestatus = '5'
						WHERE idips = '" . $this->old . "';";
			$this->ejecutar();
			//Cambia la nueva a usada
			$this->que_dba = "UPDATE ips
						SET estatus_idestatus = '6'
						WHERE idips = '" . $this->neu . "';";
			$this->ejecutar();
				

			//Y lo migra a la nueva ip
			
			$this->que_dba = "UPDATE detalles_contratos
						SET ips_idips = '" . $this->neu . "'
						WHERE contratos_idcontratos = '" . $this->contrato . "';";
			return $this->ejecutar();
			
		}

		public function routerAConectar(){
			$this->que_dba = "SELECT * FROM routers WHERE cod_router = '".$this->cod_router."';";

			return $this->ejecutar();
		}


		//----------------------------Exportación-----------------------------//
		public function serverEnv()
		{
			$this->que_dba = "SELECT * FROM server WHERE idserver = '" . $this->id_server . "';";

			return $this->ejecutar();
		}

		public function serverRec()
		{
			$this->que_dba = "SELECT * FROM server WHERE idserver = '" . $this->id_server2 . "';";

			return $this->ejecutar();
		}

		public function segmentosExp()
		{
			$this->que_dba = "SELECT * FROM segmentos_ip WHERE server_idserver = '" . $this->id_server . "';";

			return $this->ejecutar();
		}

		public function queueExp()
		{
			$this->que_dba = "SELECT * FROM contratos c, clientes cl, detalles_contratos dc, planes p, ips ip 
				WHERE c.clientes_idclientes = cl.idclientes
				AND c.estatus_idestatus = 1
				AND dc.contratos_idcontratos = c.idcontratos
				AND dc.planes_idplanes = p.idplanes
				AND ip.idips = dc.ips_idips
				AND c.server_idserver = '" . $this->id_server . "';";

			return $this->ejecutar();
		}

		public function suspendidosExp()
		{
			$this->que_dba = "SELECT * FROM clientes cl, contratos c, detalles_contratos dc, ips ip, factura f, fecha_corte fc, server s
		WHERE cl.idclientes=c.clientes_idclientes
		AND c.server_idserver = s.idserver
		AND c.estatus_idestatus=1
		AND c.idcontratos=f.contratos_idcontratos
		AND c.fecha_corte_idfecha_corte=fc.idfecha_corte
		AND c.idcontratos=dc.contratos_idcontratos
		AND dc.ips_idips=ip.idips
		AND f.estatus_contable_idestatus_contable=9
		AND f.mes_fac=MONTH(CURRENT_DATE())
		AND s.idserver = '" . $this->id_server . "'
		GROUP BY c.idcontratos";

			return $this->ejecutar();
		}
		//----------------------------Exportación-----------------------------//
	
	} // Fin de clase
	
}else {
	header("location: ../../index.php");
	exit();
}
?>
