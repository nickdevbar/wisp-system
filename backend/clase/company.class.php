<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");


	class company extends utilidad {

public $idcompany;
public $razon_social;
public $tipo;
public $rif;
public $direccion;
public $punto_ref;
public $telef;
public $telef_fijo;
public $email;
public $web;
public $logo;
public $instagram;
public $fanspage;
public $twitter;


	public function insertar(){

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
			'".$this->telefono."',
			'".$this->telefono2."',
			'".$this->email."',
			'".$this->fecha_ingreso."',
			'7',
			'".$_SESSION['idusuarios']."'); ";

		return $this->ejecutar();

	}

	public function modificar(){

			$this->que_dba="UPDATE  company SET	
			razon_social = '".$this->razon_social."',
			tipo_company = '".$this->tipo_company."',
			rif_company = '".$this->rif_company."',
			dir_company = '".$this->dir_company."',
			tel_company = '".$this->tel_company."',
			ema_company = '".$this->ema_company."',
			fanpage_company = '".$this->fanpage_company."',
			instagram_company = '".$this->instagram_company."',
			logo_company = '".$this->logo_company."' 
			WHERE cod_company='".$this->cod_company."'; ";


		return $this->ejecutar();

	}

	/*Nuevas*/

	public function listar(){

			$this->que_dba="SELECT *
			FROM company 
      		WHERE cod_company='".$this->cod_company."'; ";

		return $this->ejecutar();

	}

	public function listar_mail()
		{
			$this->que_dba="SELECT * FROM conexion_email 
			WHERE company_cod_company = '".$_SESSION['company']."';";

			return $this->ejecutar();
		}

		public function recibo_pago()
		{
			$this->que_dba="SELECT *
			FROM pago_factura p, forma_pago fp, usuarios u, factura f, 
			estatus_contable e, contratos c, clientes cl, fecha_corte fc
			WHERE p.forma_pago_cod_for_pag = fp.cod_for_pag
			AND u.cod_usu = p.usuarios_cod_usu
			AND f.cod_fac = p.factura_cod_fac
			AND e.cod_est_con = f.estatus_contable_cod_est_con
			AND c.clientes_cod_cli = cl.cod_cli
			AND c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
			AND f.cod_fac='".$this->cod_fac."'
			AND c.cod_contratos='".$this->cod_contratos."';";

			return $this->ejecutar();
		}

	public function fechaCorte(){

			$this->que_dba= "SELECT * FROM fecha_corte";

		return $this->ejecutar();

	}

	public function routerInfo(){

		$this->que_dba= "SELECT * FROM routers WHERE cod_router = '".$this->cod_router."' ;";

	return $this->ejecutar();

}

	public function usuariosSusPorFecha(){

			$this->que_dba= "SELECT * FROM contratos c, detalles_contratos dc, clientes cl, fecha_corte fc, ips ip, routers r, factura f
			WHERE c.clientes_cod_cli = cl.cod_cli
			AND c.fecha_corte_cod_fec_corte = fc.cod_fec_corte
			AND dc.contratos_cod_contratos = c.cod_contratos
			AND r.cod_router = c.routers_cod_router
			AND ip.cod_ip = dc.ips_cod_ip
			AND f.contratos_cod_contratos = c.cod_contratos
			AND f.estatus_contable_cod_est_con = '1'
			AND fc.cod_fec_corte = '" . $this->cod_fec_corte . "'
			GROUP BY c.cod_contratos;";

		return $this->ejecutar();

	}

	public function sector(){

			$this->que_dba="SELECT *
			FROM sector";

		return $this->ejecutar();

	}

	public function email(){

		$this->que_dba="SELECT * FROM conexion_email 
		WHERE company_cod_company = '".$_SESSION['company']."';";

	return $this->ejecutar();
	
}

public function addCorreo(){

	$this->que_dba="INSERT INTO conexion_email
	(nom_con_ema,
	ema_con_ema,
	pas_con_ema,
	host_con_ema,
	pue_con_ema,
	fec_con_ema,
	company_cod_company)
	VALUES (
	'".$this->nom_con_ema."',
	'".$this->ema_con_ema."',
	'".$this->pas_con_ema."',
	'".$this->host_con_ema."',
	'".$this->pue_con_ema."',
	Now(),
	'".$_SESSION['company']."'); ";

return $this->ejecutar();

}

public function editCorreo(){

			$this->que_dba="UPDATE conexion_email SET	
			nom_con_ema = '".$this->nom_con_ema."',
			ema_con_ema = '".$this->ema_con_ema."',
			pas_con_ema = '".$this->pas_con_ema."',
			host_con_ema = '".$this->host_con_ema."',
			pue_con_ema = '".$this->pue_con_ema."'
			WHERE company_cod_company='".$_SESSION['company']."'
			AND cod_con_ema = '".$this->cod_con_ema."';";
		return $this->ejecutar();

	}





	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>