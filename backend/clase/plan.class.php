<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");


	class plan extends utilidad {

   	public $idplanes;
   	public $nombre_plan;
   	public $precio;
   	public $vel_subida;
   	public $tx;
   	public $vel_descarga;
   	public $rx;
   	public $company_idcompany;
   	public $usuarios_idusuarios;
   	public $fecha_creacion;
   	public $est_pla;


	public function insertar(){
			$fecha=date("Y-m-d");
			$this->que_dba="INSERT INTO planes 
			(nombre_plan,
			precio,
			vel_subida,
			tx,
			vel_descarga,
			rx,
			company_idcompany,
			usuarios_idusuarios,
			fecha_creacion)
			VALUES ('".$this->nombre_plan."',
			'".$this->precio."',
			'".$this->vel_subida."', 
			'".$this->tx."',
			'".$this->vel_descarga."',
			'".$this->rx."',
			'".$_SESSION['idcompany']."',
			'".$_SESSION['idusuarios']."',
			'".$fecha."'); ";

		return $this->ejecutar();

	}

		public function modificar(){
			$fecha=date("Y-m-d");
			$this->que_dba="UPDATE  planes SET
			nombre_plan='".$this->nombre_plan."',
			precio='".$this->precio."',
			vel_subida='".$this->vel_subida."',
			tx='".$this->tx."',
			vel_descarga='".$this->vel_descarga."',
			rx='".$this->rx."'
			WHERE idplanes='".$this->idplanes."'; ";

		return $this->ejecutar();

	}

//Nuevos
	public function listar(){
		
		$this->que_dba= "SELECT *  FROM planes 
						WHERE company_cod_company= '" . $_SESSION['company'] . "'
						AND estatus_cod_est = 1";
		return $this->ejecutar();

	}

	public function lisPlan(){
		
		$this->que_dba= "SELECT *  FROM planes 
						WHERE cod_plan = '".$this->cod_plan."'
						AND company_cod_company= '" . $_SESSION['company'] . "'
						AND estatus_cod_est = 1";
		return $this->ejecutar();

	}

	public function lisRouter(){
		
		$this->que_dba= "SELECT *  FROM routers
						WHERE cod_router = '".$this->cod_router."'
						AND company_cod_company= '" . $_SESSION['company'] . "'
						AND estatus_cod_est = 1";
		return $this->ejecutar();

	}



	public function segmentos(){
		
		$this->que_dba= "SELECT *  FROM segmentos_ip s, routers r
						WHERE s.company_cod_company= '" . $_SESSION['company'] . "'
						AND s.routers_cod_router = r.cod_router";
		return $this->ejecutar();

	}

	public function routers(){
		
		$this->que_dba= "SELECT *  FROM routers
						WHERE company_cod_company= '" . $_SESSION['company'] . "'
						AND estatus_cod_est = 1";
		return $this->ejecutar();

	}

	public function ipDisponible(){
		
		$this->que_dba= "SELECT *  FROM ips 
			WHERE company_cod_company = '" . $_SESSION['company'] . "'
			AND estatus_cod_est = 5";
		return $this->ejecutar();

	}
//---------------------------------------
	public function show(){
		
		$this->que_dba="SELECT *  FROM planes WHERE 
		company_idcompany='".$_SESSION['idcompany']."'
		ORDER BY idplanes;";
		return $this->ejecutar();

	}

		public function estado()
		{
			$this->que_dba = "UPDATE planes SET
			est_pla = '" . $this->est_pla . "'
			WHERE idplanes = '" . $this->idplanes . "'; ";

			return $this->ejecutar();
		}

	public function filtrar(){
			$this->que_dba="SELECT *  FROM planes 
			WHERE idplanes='".$this->idplanes."'
			AND company_idcompany='".$_SESSION['idcompany']."';";
		return $this->ejecutar();
	}

	public function eliminarPlan(){
			$this->que_dba="DELETE FROM planes WHERE idplanes = '".$this->idplanes."';";
		return $this->ejecutar();
	}



	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>