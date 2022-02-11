<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");
require_once("funciones_api.class.php");


	class cliente extends utilidad {

		public $tip_cli;
		public $nom_cli;
		public $tel_cli;
		public $tel2_cli;			
		public $ema_cli;
		public $dir_cli;
		public $pun_ref_cli;

		public $contrato;
		public $fecha_corte;
		public $tipo_instalacion;
		public $ips;
		public $mac;
		public $planes;

	

	public $iddatos_habitacion;
	public $texto;

		public $clientes_idclientes;
		public $estatus_idestatus;

	public $cod_sec;

	public $cod_contratos;
	public $num_contratos;

		/*------------------------------------------*/
		public function routerConnect(){

			$this->que_dba="SELECT * FROM routers
			WHERE company_cod_company = '".$_SESSION['company']."'
			AND cod_router = '".$this->cod_router."';";
		return $this->ejecutar();
		}

		public function editarIP(){
			//Inserta la auditoria
			$this->que_dba = "INSERT INTO auditoria(des_aud,fec_aud,contratos_cod_contratos,usuarios_cod_usu) 
				VALUES (
				'".$this->des_aud."',
        		Now(),
        		'".$this->cod_contratos."',
        		'".$_SESSION['cod_usu']."'
        		); ";

			$this->ejecutar();

			//La regresa a que sea nueva
			$this->que_dba = "UPDATE ips 
						SET estatus_cod_est = '5'
						WHERE cod_ip = '" . $this->old . "';";
			$this->ejecutar();

			//Cambia la nueva a usada
			$this->que_dba = "UPDATE ips
						SET estatus_cod_est = '6'
						WHERE cod_ip = '" . $this->neu . "';";
			$this->ejecutar();
				
			//Y lo migra a la nueva ip
			$this->que_dba = "UPDATE detalles_contratos
						SET ips_cod_ip = '" . $this->neu . "'
						WHERE contratos_cod_contratos = '" . $this->cod_contratos . "';";
			$this->ejecutar();

			$obj_api = new funciones_api;
			$obj_api->old_ip = $this->old_ip;
			$obj_api->new_ip = $this->new_ip;

			$obj_api->ip_router_api = $this->ip_api;
			$obj_api->login_api = $this->lo_api;
			$obj_api->password_api = $this->pa_api;
			$obj_api->port_api = $this->po_api;
			$obj_api->blacklist = $this->bl_api;
			$obj_api->whitelist = $this->wl_api;

			$obj_api->asignar_valor_api();
			$obj_api->connect();

			$obj_api->ip_arp();
			$obj_api->ip_queue();
			$obj_api->ip_whitelist();
		}

		public function addCliente(){
				$this->que_dba="INSERT INTO clientes 
				(nom_cli,
				tel_cli,
				tel2_cli,
				ema_cli,
				fec_cli,
				tipo_cli,
				ced_cli,
				dir_cli,
				pun_ref_cli,
				estatus_clientes_cod_est_cli,
				company_cod_company)
				VALUES (
				'".$this->nom_cli."',
				'".$this->tel_cli."',
				'".$this->tel2_cli."', 
				'".$this->ema_cli."',
				Now(),
				'".$this->tipo_cli."',
				'".$this->ced_cli."',
				'".$this->dir_cli."',
				'".$this->pun_ref_cli."',
				'3',
				'".$_SESSION['company']."'); ";

				echo $this->que_dba;
	
			return $this->ejecutar();
	
		}

		public function manPendiente()
		{
			$this->que_dba = "SELECT COUNT(*) AS pendiente FROM contratos c, clientes cl, mantenimientos m
			WHERE c.clientes_cod_cli = cl.cod_cli
			AND m.contratos_cod_contratos = c.cod_contratos
			AND cl.estatus_clientes_cod_est_cli = '1'
			AND m.estatus_cod_est = '3' ";

			return $this->ejecutar();
		}

		public function perfil_cliente()
		{
			$this->que_dba = "SELECT * FROM contratos c, clientes cl, detalles_contratos dc, ips ip, planes p, fecha_corte fc, routers r, tipo_instalacion ti, usuarios u, estatus e
	WHERE c.clientes_cod_cli = cl.cod_cli
	AND c.routers_cod_router = r.cod_router
	AND c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
	AND c.tipo_instalacion_cod_tipo_ins = ti.cod_tipo_ins
	AND c.usuarios_cod_usu = u.cod_usu
	AND c.cod_contratos = dc.contratos_cod_contratos
	AND dc.ips_cod_ip = ip.cod_ip
	AND dc.planes_cod_plan = p.cod_plan
	AND cl.estatus_clientes_cod_est_cli = e.cod_est
	AND c.company_cod_company = '" . $_SESSION['company'] . "'
	AND c.cod_contratos = '".$this->cod_contratos."' ;";

			return $this->ejecutar();
		}

		public function detalleContrato()
		{
			$this->que_dba = "SELECT * FROM contratos c, clientes cl, fecha_corte fc, routers r, tipo_instalacion ti
			WHERE c.clientes_cod_cli = cl.cod_cli
			AND c.routers_cod_router = r.cod_router
			AND c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
			AND c.tipo_instalacion_cod_tipo_ins = ti.cod_tipo_ins
			AND c.company_cod_company = '" . $_SESSION['company'] . "'
			AND cl.cod_cli ='".$this->cod_cli."' ;";

			return $this->ejecutar();
		}

		public function factura_pendiente()
		{
			$this->que_dba = "SELECT * FROM factura f
	WHERE f.estatus_contable_cod_est_con = 1
	AND f.contratos_cod_contratos = '" . $this->cod_contratos . "'
	AND f.company_cod_company =  '".$_SESSION['company']."';";

			return $this->ejecutar();
		}

		public function factura_paga()
		{
			$this->que_dba = "SELECT * FROM factura f, forma_pago fp, pago_factura pf, estatus_contable ec
			WHERE fp.cod_for_pag = pf.forma_pago_cod_for_pag
			AND f.cod_fac = pf.factura_cod_fac
			AND f.estatus_contable_cod_est_con = ec.cod_est_con
			AND f.contratos_cod_contratos = '" . $this->cod_contratos . "'
			AND f.company_cod_company =  '".$_SESSION['company']."'
			ORDER BY f.num_factura;";

			return $this->ejecutar();
		}

		public function mantenimientos()
		{
			$this->que_dba = "SELECT * FROM mantenimientos m , act_mantenimientos am, contratos c, usuarios u, fallas f
			WHERE c.cod_contratos = m.contratos_cod_contratos
			AND m.cod_man = am.mantenimientos_cod_man
			AND u.cod_usu = am.usuarios_cod_usu
			AND f.cod_fallas = m.fallas_cod_fallas
			AND m.contratos_cod_contratos = '" . $this->cod_contratos . "'
			AND m.company_cod_company = '".$_SESSION['company']."';";

			return $this->ejecutar();
		}

		public function auditoria()
		{
			$this->que_dba = "SELECT * FROM auditoria a, contratos c, usuarios u 
			WHERE a.contratos_cod_contratos = c.cod_contratos
			AND u.cod_usu = a.usuarios_cod_usu
			AND c.company_cod_company = '".$_SESSION['company']."'
			AND c.cod_contratos = '" . $this->cod_contratos . "';";

			return $this->ejecutar();
		}

		public function editar(){

			$this->que_dba="UPDATE clientes SET
			tipo_cli='".$this->tipo_cli."',
			ced_cli='".$this->ced_cli."',
			nom_cli='".$this->nom_cli."',
			tel_cli='".$this->tel_cli."',
			tel2_cli='".$this->tel2_cli."',
			ema_cli='".$this->ema_cli."',
			dir_cli='".$this->dir_cli."',
			pun_ref_cli='".$this->pun_ref_cli."'
			WHERE cod_cli = '".$this->cod_cli."'; ";

			$new_name = 'Contrato N ' . $this->num_con . ' ' . $this->nom_cli;

			$obj_api = new funciones_api;
			$obj_api->nom = $new_name;
			$obj_api->ip = $this->ip_contrato;

			$obj_api->ip_router_api = $this->ip_api;
			$obj_api->login_api = $this->lo_api;
			$obj_api->password_api = $this->pa_api;
			$obj_api->port_api = $this->po_api;
			$obj_api->blacklist = $this->bl_api;

			$obj_api->asignar_valor_api();
			$obj_api->connect();

			$obj_api->nombre();
			$obj_api->nombre_arp();
			$obj_api->nombre_suspendidos();

		return $this->ejecutar();

	}

	public function editarContrato(){

		$this->que_dba="UPDATE contratos SET
		fecha_corte_cod_fec_corte='".$this->fecha_corte."',
		tipo_instalacion_cod_tipo_ins='".$this->tipo_instalacion."'
		WHERE cod_contratos = '".$this->contrato."'; ";
	    $this->ejecutar();

		$this->que_dba="UPDATE detalles_contratos SET
		mac_det_con='".$this->mac."',
		planes_cod_plan='".$this->planes."'
		WHERE contratos_cod_contratos = '".$this->contrato."'; ";
		$this->ejecutar();

		$obj_api = new funciones_api;
		$obj_api->mac = $this->mac;
		$obj_api->nombres = $this->nom;
		$obj_api->planes = $this->planes;
		$obj_api->contrato = $this->contrato;
		$obj_api->num_contrato = $this->num_contrato;
		$obj_api->ip_contrato = $this->ip_contrato;

		$obj_api->ip_router_api = $this->ip_api;
		$obj_api->login_api = $this->lo_api;
		$obj_api->password_api = $this->pa_api;
		$obj_api->port_api = $this->po_api;
		$obj_api->blacklist = $this->bl_api;

		if( $this->mac != ""){
			$obj_api->asignar_valor_api();
			$obj_api->connect();
			$obj_api->arp();
			echo "Cambio Mac";
		}

		if( $this->planes != ""){
			$obj_api->asignar_valor_api();
			$obj_api->connect();
			$obj_api->queue();
			echo "Cambio Plan";
		}

}

public function desactivarContrato(){

	$this->que_dba="UPDATE clientes SET
	estatus_clientes_cod_est_cli = '2'
	WHERE cod_cli = '".$this->cod_cli."'; ";
	$this->ejecutar();

	$this->que_dba="INSERT INTO auditoria (
		des_aud,
		fec_aud,
		contratos_cod_contratos,
		usuarios_cod_usu
		)VALUES(
		'".$this->des_aud."',
		Now(),
		'".$this->contratos_cod_contratos."',
		'".$_SESSION['cod_usu']."'
		)";
	    $this->ejecutar();

		$obj_api = new funciones_api;
		$obj_api->ip_contrato = $this->ip_contrato;

		$obj_api->ip_router_api = $this->ip_api;
		$obj_api->login_api = $this->lo_api;
		$obj_api->password_api = $this->pa_api;
		$obj_api->port_api = $this->po_api;
		$obj_api->blacklist = $this->bl_api;
		$obj_api->whitelist_api = $this->wl_api;

		$obj_api->asignar_valor_api();
		$obj_api->connect();
		$obj_api->remove_whitelist();

}

public function editarRouter(){
	$this->que_dba = "INSERT INTO auditoria(des_aud,fec_aud,contratos_cod_contratos,usuarios_cod_usu) 
				VALUES (
				'".$this->des_aud."',
        		Now(),
        		'".$this->cod_contratos."',
        		'".$_SESSION['cod_usu']."'
        		); ";
			$this->ejecutar();

	$this->que_dba="UPDATE contratos SET
	routers_cod_router = '".$this->routers_cod_router."'
	WHERE cod_contratos = '".$this->cod_contratos."'; ";
	
	return $this->ejecutar();
}

public function editarEstudio(){

	$this->que_dba="UPDATE clientes SET
	nom_cli = '".$this->nom_cli."',
	tel_cli = '".$this->tel_cli."',
	tel2_cli = '".$this->tel2_cli."',
	ema_cli = '".$this->ema_cli."',
	tipo_cli = '".$this->tipo_cli."',
	ced_cli = '".$this->ced_cli."',
	dir_cli = '".$this->dir_cli."',
	pun_ref_cli = '".$this->pun_ref_cli."'

	WHERE cod_cli = '".$this->cod_cli."'; ";
	
	return $this->ejecutar();

}

public function activarContrato(){

	$this->que_dba="UPDATE clientes SET
	estatus_clientes_cod_est_cli = '1'
	WHERE cod_cli = '".$this->cod_cli."'; ";
	
	return $this->ejecutar();

}

public function auditoriaContrato(){

	$this->que_dba="INSERT INTO auditoria (
	des_aud,
	fec_aud,
	contratos_cod_contratos,
	usuarios_cod_usu
	)VALUES(
	'".$this->des_aud."',
	Now(),
	'".$this->contratos_cod_contratos."',
	'".$_SESSION['cod_usu']."'
	)";
return $this->ejecutar();

}



public function tipo(){

	$this->que_dba="SELECT * FROM tipo_instalacion";
return $this->ejecutar();

}

public function fecha(){

	$this->que_dba="SELECT * FROM fecha_corte";
return $this->ejecutar();

}

public function plan(){

	$this->que_dba="SELECT * FROM planes
	WHERE company_cod_company = '".$_SESSION['company']."';";
return $this->ejecutar();

}

public function ipes(){

	$this->que_dba="SELECT * FROM ips
	WHERE estatus_cod_est = '5'
	AND company_cod_company = '".$_SESSION['company']."';";
return $this->ejecutar();

}

public function usuarios(){

	$this->que_dba="SELECT * FROM usuarios
	WHERE company_cod_company = '".$_SESSION['company']."';";
return $this->ejecutar();

}

public function routers(){

	$this->que_dba="SELECT * FROM routers
	WHERE company_cod_company = '".$_SESSION['company']."';";
return $this->ejecutar();

}

public function ip(){

	$this->que_dba="SELECT * FROM ips
	WHERE company_cod_company = '".$_SESSION['company']."';";
return $this->ejecutar();

}

public function persona(){

	$this->que_dba="SELECT * FROM clientes 
	WHERE cod_cli = '".$this->cod_cli."'
	AND company_cod_company ='".$_SESSION['company']."';";
	return $this->ejecutar();
}

public function estudioEdit(){

	$this->que_dba="SELECT * FROM clientes cl
	WHERE cl.cod_cli = '".$this->cod_cli."'
	AND company_cod_company ='".$_SESSION['company']."';";
	return $this->ejecutar();
}

public function ultimoNumero(){

	$this->que_dba="SELECT num_contrato AS ultimo FROM contratos WHERE company_cod_company ='".$_SESSION['company']."' ORDER BY ultimo DESC;";
	return $this->ejecutar();

}

public function addPositivo(){

		$this->que_dba="UPDATE clientes SET 
					estatus_clientes_cod_est_cli = '4'
					WHERE cod_cli = '".$this->clientes_cod_cli."';";

		$this->ejecutar();

		$this->que_dba="INSERT INTO contratos 
		(num_contrato,
		fec_contrato,
		clientes_cod_cli,
		company_cod_company,
		routers_cod_router,
		fecha_corte_cod_fec_corte,
		tipo_instalacion_cod_tipo_ins,
		usuarios_cod_usu)
		VALUES (
		'".$this->num_contrato."',
		Now(),
		'".$this->clientes_cod_cli."',
		'".$_SESSION['company']."',
		'".$this->routers_cod_router."',
		'".$this->fecha_corte_cod_fec_corte."',
		'".$this->tipo_instalacion_cod_tipo_ins."',
		'".$this->usuarios_cod_usu."'
		); ";
		return $this->ejecutar();

}

public function addNegativo(){

	$this->que_dba="UPDATE clientes SET 
				estatus_clientes_cod_est_cli = '5'
				WHERE cod_cli = '".$this->cod_cli."';";
	return $this->ejecutar();
}

public function ultimaFactura(){
	
	$this->que_dba="SELECT * 
	FROM factura f
	WHERE 
	f.company_cod_company = '".$_SESSION['company']."'
	ORDER BY f.num_factura DESC";
   return $this->ejecutar();

}

public function completarContrato(){
	/********************Crear Factura******************************/

	$anio = date('Y');
	$month = date('m');

	$this->que_dba="INSERT INTO factura
	(
	num_factura,
	fec_cre_fac,
	mes_fac,
	ano_fac,
	mon_fac,
	mon_ded_fac,
	des_fac,
	estatus_contable_cod_est_con,
	fecha_corte_cod_fec_corte,
	usuarios_cod_usu,
	company_cod_company,
	contratos_cod_contratos,
	planes_cod_plan
	)
	VALUES (
	'".$this->num_factura."',
	Now(),
	'$month',
	'$anio',
	'".$this->pre_plan."',
	'".$this->pre_plan."',
	'Primera Factura del contrato para el mes $month.',
	'1',
	'".$this->fecha_corte."',
	'".$_SESSION['cod_usu']."',
	'".$_SESSION['company']."',
	'".$this->contratos_cod_contratos."',
	'".$this->planes_cod_plan."'
	); ";

	echo $this->que_dba;
	$this->ejecutar();
	/**************************************************************/

	$this->que_dba="UPDATE clientes SET 
				estatus_clientes_cod_est_cli = '1'
				WHERE cod_cli = '".$this->clientes_cod_cli."';";

	$this->ejecutar();

	$this->que_dba="UPDATE ips SET 
				estatus_cod_est = '6'
				WHERE cod_ip = '".$this->ips_cod_ip."';";
	$this->ejecutar();

	$this->que_dba="INSERT INTO detalles_contratos
	(mac_det_con,
	contratos_cod_contratos,
	ips_cod_ip,
	planes_cod_plan)
	VALUES (
	'".$this->mac_det_con."',
	'".$this->contratos_cod_contratos."',
	'".$this->ips_cod_ip."',
	'".$this->planes_cod_plan."'
	); ";
	$this->ejecutar();

	$obj_api=new funciones_api;
	$obj_api->mac=$this->mac_det_con;
	$obj_api->nombres=$this->nombres;
	$obj_api->ip_contrato=$this->ip_contrato;
	$obj_api->planes=$this->planes_cod_plan;
	$obj_api->contrato=$this->num_contrato;

	$obj_api->ip_router_api = $this->ip_api;
	$obj_api->login_api = $this->lo_api;
	$obj_api->password_api = $this->pa_api;
	$obj_api->port_api = $this->po_api;
	$obj_api->blacklist_api = $this->bl_api;

	$obj_api->asignar_valor_api();
	$obj_api->connect();
	$obj_api->arp();
	$obj_api->queue();
	$obj_api->add_blacklist();

}
	/*----------------------------------------------- */


	
	public function insertar(){
		$fecha=date("Y-m-d H:m:s");
			$this->que_dba="INSERT INTO clientes 
			(tipo,
			cedula,
			nombres,
			telef,
			telef2,
			email,
			fecha_creacion,
			estatus_idestatus,
			usuarios_idusuarios)
			VALUES ('".$this->tipo."',
			'".$this->cedula."',
			'".$this->nombres."', 
			'".$this->telef."',
			'".$this->telef2."',
			'".$this->email."',
			'".$fecha."',
			'7',
			'".$_SESSION['idusuarios']."'); ";

		return $this->ejecutar();

	}
		

	

		//Nuevos

		public function est_pendiente()
		{
			$this->que_dba = "SELECT * FROM 
			   clientes c
			   WHERE c.estatus_clientes_cod_est_cli = 3 OR c.estatus_clientes_cod_est_cli = 4
			   AND c.company_cod_company = '" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

	public function listar(){

			$this->que_dba= "SELECT * FROM 
			   clientes c,
			   contratos co
			   WHERE 
			   c.cod_cli = co.clientes_cod_cli
			   AND  c.estatus_clientes_cod_est_cli = 1
			   AND c.company_cod_company = '".$_SESSION['company']."';";

		return $this->ejecutar();

	}

	public function listarInac(){

			$this->que_dba= "SELECT * FROM 
			   clientes c,
			   contratos co
			   WHERE 
			   c.cod_cli = co.clientes_cod_cli
			   AND  c.estatus_clientes_cod_est_cli = 2
			   AND c.company_cod_company = '".$_SESSION['company']."';";

		return $this->ejecutar();
	}

		public function activosCont()
		{

			$this->que_dba = "SELECT COUNT(*) AS act FROM 
			   clientes c,
			   contratos co
			   WHERE 
			   c.cod_cli = co.clientes_cod_cli
			   AND  c.estatus_clientes_cod_est_cli = 1
			   AND c.company_cod_company = '" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		public function inactivosCont()
		{

			$this->que_dba = "SELECT COUNT(*) AS inac FROM 
			   clientes c,
			   contratos co
			   WHERE 
			   c.cod_cli = co.clientes_cod_cli
			   AND  c.estatus_clientes_cod_est_cli = 2
			   AND c.company_cod_company = '" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		public function enEspera()
		{

			$this->que_dba = "SELECT COUNT(*) AS esp FROM 
			   clientes c,
			   contratos co
			   WHERE 
			   c.cod_cli = co.clientes_cod_cli
			   AND  c.estatus_clientes_cod_est_cli = 3
			   AND c.company_cod_company = '" . $_SESSION['company'] . "';";

			return $this->ejecutar();
		}

		public function mantCont()
		{

			$this->que_dba = "SELECT COUNT(*) as man FROM 
			   mantenimientos
			   WHERE company_cod_company = '" . $_SESSION['company'] . "'
			   AND estatus_cod_est = 3 ";

			return $this->ejecutar();
		}

	//--------------------------------------//
	

		public function listarPorCorte()
		{

			$this->que_dba = "SELECT 
			clientes.*, 
			datos_habitacion.*, 
			estudios.*, 
			contratos.*, 
			detalles_contratos.*,
			ips.*, 
			planes.*
			FROM 
			   clientes,
			   datos_habitacion,
			   estudios,
			   contratos,
			   detalles_contratos,
			   ips,
			   planes
			   WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
			   AND datos_habitacion.iddatos_habitacion=estudios.datos_habitacion_iddatos_habitacion
			   AND estudios.idestudios=contratos.estudios_idestudios
			   AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
			   AND detalles_contratos.planes_idplanes=planes.idplanes
			   AND detalles_contratos.ips_idips=ips.idips
			   AND  contratos.estatus_idestatus = '" . $this->estado . "'
			   AND fecha_corte_idfecha_corte = '".$this->fecha_corte."'; ";

			return $this->ejecutar();
		}

		

	public function query_cliente_simple(){
	
			$this->que_dba="SELECT 
			clientes.*, 
			datos_habitacion.*
			FROM 
			   clientes,
			   datos_habitacion
			   
			   WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
			  AND clientes.idclientes = '".$this->idclientes."'; ";

		return $this->ejecutar();

	}

	

		public function cambio_estudio()
		{

			$this->que_dba = "UPDATE datos_habitacion SET
			estatus_idestatus= '7'
			WHERE clientes_idclientes='".$this->clientes_idclientes."'; ";

			return $this->ejecutar();
		}

		public function borrar_estudio()
		{

			$this->que_dba = "UPDATE datos_habitacion SET
			estatus_idestatus= '12'
			WHERE clientes_idclientes='" . $this->clientes_idclientes . "'; ";

			return $this->ejecutar();
		}

		public function listarNumero()
		{
			$this->que_dba = "SELECT * FROM clientes WHERE telef ='".$this->telef."'; ";

			return $this->ejecutar();
		}

		public function listarTodos()
		{
			$this->que_dba = "SELECT * FROM clientes ";

			return $this->ejecutar();
		}

		public function listarSims()
		{
			$this->que_dba = "SELECT * FROM server_sms";

			return $this->ejecutar();
		}

		public function listarSimVen()
		{
			$this->que_dba = "SELECT * FROM server_sms WHERE codAreaServer = '58' ";

			return $this->ejecutar();
		}

		public function listarSimCol()
		{
			$this->que_dba = "SELECT * FROM server_sms WHERE codAreaServer = '57' ";

			return $this->ejecutar();
		}

		public function listarCedula()
		{
			$this->que_dba = "SELECT tipo_cli, ced_cli FROM clientes
							  WHERE tipo_cli = '".$this->tipo_cli."' 
							  AND ced_cli = '".$this->ced_cli."';";
							  
							  $resultado = $this->ejecutar();

			if ($resultado->num_rows > 0) {

				echo $resultado->num_rows;
				//echo "Se Realizo el cambio";
				return $this->ejecutar();
			}else{
				echo "Los datos no coinciden";
			}

		
		}

		public function fechaCorteQuince()
		{
			$this->que_dba = "SELECT * FROM factura fa, contratos co, clientes cl, detalles_contratos dc, planes p
				WHERE fa.contratos_idcontratos= co.idcontratos
				AND p.idplanes = dc.planes_idplanes
				AND dc.contratos_idcontratos = co.idcontratos
				AND cl.idclientes=co.clientes_idclientes
				AND co.estatus_idestatus=1
				AND co.fecha_corte_idfecha_corte=2
				AND fa.estatus_contable_idestatus_contable=9
				AND fa.ano_fac=YEAR(NOW())
				AND fa.mes_fac=MONTH (NOW()) ";

			return $this->ejecutar();
		}

		public function fechaCortePrimero()
		{
			$this->que_dba = "SELECT * FROM factura fa, contratos co, clientes cl, detalles_contratos dc, planes p
				WHERE fa.contratos_idcontratos= co.idcontratos
				AND p.idplanes = dc.planes_idplanes
				AND dc.contratos_idcontratos = co.idcontratos
				AND cl.idclientes=co.clientes_idclientes
				AND co.estatus_idestatus=1
				AND co.fecha_corte_idfecha_corte=1
				AND fa.estatus_contable_idestatus_contable=9
				AND fa.ano_fac=YEAR(NOW())
				AND fa.mes_fac=MONTH (NOW()) ";

			return $this->ejecutar();
		}

		

		public function buscarServer()
		{

			$this->que_dba = "SELECT 
			*
			FROM 
			   server
			   WHERE idserver = '".$this->idserver."'; ";

			return $this->ejecutar();
		}

		public function buscarServerxContrato()
		{

			$this->que_dba = "SELECT * FROM contratos c, routers r, detalles_contratos dc, ips ip
			WHERE r.cod_router = c.routers_cod_router
			AND c.cod_contratos = dc.contratos_cod_contratos
			AND dc.ips_cod_ip = ip.cod_ip
			AND c.cod_contratos ='".$this->idcontratos."'; ";

			return $this->ejecutar();
		}




	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>