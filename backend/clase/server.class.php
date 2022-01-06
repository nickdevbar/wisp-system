<?php
 if(!session_id())
session_start();

if (isset($_SESSION['idusuarios'])){

require_once("utilidad.class.php");
/*
idserve
nombre_server
user_server
pass_server	
ip_server
puert_server
interface_salida
blacklist
version_server_idversion_server
estatus_idestatus
usuarios_idusuarios
company_idcompany
fecha_creacion
*/
	class server extends utilidad {


public $idserver;
public $nombre_server;
public $user_server;
public $pass_server;
public $ip_server;
public $puert_server;
public $puert_graf;
public $interface_salida;
public $blacklist;
public $version_server;
public $estatus;
public $usuarios_idusuarios;
public $company_idcompany;
public $fecha_creacion;


//////////////////////////
public $idcompany;



	public function insertar(){
		$fecha=date("Y-m-d H:m:s");
			$this->que_dba="INSERT INTO server 
			(nombre_server,
			user_server,
			pass_server,
			ip_server,
			puert_server,
			puert_graf,
			interface_salida,
			blacklist,
			version_server_idversion_server,
			estatus_idestatus,
			usuarios_idusuarios,
			company_idcompany,
			fecha_creacion)
			VALUES ('".$this->nombre_server."',
			'".$this->user_server."',
			'".$this->pass_server."', 
			'".$this->ip_server."',
			'".$this->puert_server."',
			'".$this->puert_graf."',
			'".$this->interface_salida."',
			'".$this->blacklist."',
			'".$this->version_server."',
			'1',
			'".$_SESSION['idusuarios']."',
			'".$_SESSION['idcompany']."',
			'".$fecha."'); ";

		return $this->ejecutar();

	}
		public function modificar(){

			$this->que_dba="UPDATE  server SET
			nombre_server='".$this->nombre_server."',
			user_server='".$this->user_server."',
			pass_server='".$this->pass_server."',
			ip_server='".$this->ip_server."',
			puert_server='".$this->puert_server."',
			puert_graf='".$this->puert_graf."',
			interface_salida='".$this->interface_salida."',
			blacklist='".$this->blacklist."',
			version_server_idversion_server='".$this->version_server."',
			estatus_idestatus='".$this->estatus."'
			WHERE idserver='".$this->idserver."'; ";

		return $this->ejecutar();

	}

	public function listar(){

			$this->que_dba="SELECT server.*, version_server.*
			FROM  server, version_server
			WHERE  
			server.version_server_idversion_server=version_server.idversion_server 
			AND server.estatus_idestatus='".$this->estatus."'
			AND server.company_idcompany='".$_SESSION['idcompany']."'; ";

		return $this->ejecutar();

	}

	public function filtrar(){
		
			$filtro1=($this->estatus!="")?"
			server.*, version_server.*
			FROM  server, version_server
			WHERE  
			server.version_server_idversion_server=version_server.idversion_server 
			AND server.estatus_idestatus='".$this->estatus."'
			AND server.company_idcompany='".$_SESSION['idcompany']."'":"";
			
			$filtro2=($this->idcompany!="")?" 
			* FROM  server
			WHERE  
			company_idcompany='".$this->idcompany."'":"";

			$filtro3=($this->idserver!="")?" 
			server.*, version_server.*
			FROM  server, version_server
			WHERE  
			server.version_server_idversion_server=version_server.idversion_server
			AND server.idserver='".$this->idserver."';":"";
			
			
			
    $this->que_dba="SELECT $filtro1 $filtro2  $filtro3;"; 
	return $this->ejecutar();
	}
	
	public function update_sql(){
		
		$this->que_dba="SET sql_mode = '';"; 
		$this->que_dba="SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"; 
	return $this->ejecutar();
	}


	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>
