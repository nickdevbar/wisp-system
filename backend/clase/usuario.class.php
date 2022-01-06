<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

	class usuario extends utilidad {


		public $idusuarios;
		public $nombres;
		public $apellidos;
		public $user;
		public $pass;
		public $telefono;
		public $fecha_creacion;
		public $nivel_idnivel;
		public $estatus_idestatus;
		public $company_idcompany;

		public $new_pass;

		public $nombre_link;
		public $ruta;
		public $grupo_menu_idgrupo_menu;
		public $visible;
		public $icono;
		public $nombre;

		/*-------------------------------------*/

		public function todes(){
			
			$this->que_dba="SELECT * FROM usuarios u, roles r 
			WHERE u.company_cod_company = 1
			AND u.roles_cod_rol = r.cod_rol";

		return $this->ejecutar();

	}

	public function usu_usu(){
		$this->que_dba="SELECT * FROM usuarios u, roles r  
		WHERE r.cod_rol = u.roles_cod_rol 
		AND cod_usu = '".$this->cod_usu."';";

		return $this->ejecutar();
	}

		/*-------------------------------------*/

	public function insertar(){

			$new_pass = MD5($this->pass);

			$this->que_dba="INSERT INTO usuarios
			 (nombres,
			 apellidos, 
			 user,
			 pass,
			 telefono,
			 fecha_creacion,
			 nivel_idnivel,
			 estatus_idestatus,
			 company_idcompany)
			VALUES ('".$this->nombres."',
			'".$this->apellidos."',
			'".$this->user."',
			'".$new_pass."',
			'".$this->telefono."',
			Now(),
			'".$this->nivel_idnivel."',
			'1',
			'".$_SESSION["idcompany"]."'); ";

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

	public function actualizar(){

			$this->que_dba="UPDATE usuarios SET
			nombres = '".$this->nombres."',
			apellidos = '".$this->apellidos."',
			user = '".$this->user."',
			telefono = '".$this->telefono."',
			nivel_idnivel ='".$this->nivel_idnivel."'
			WHERE idusuarios = '".$this->idusuarios."'; ";

		return $this->ejecutar();

	}

	public function estado(){

			$this->que_dba="UPDATE usuarios SET
			estatus_idestatus = '".$this->estatus_idestatus."'
			WHERE idusuarios = '".$this->idusuarios."'; ";

		return $this->ejecutar();

	}

	public function eliminar(){

			$this->que_dba="DELETE FROM usuarios 
			WHERE idusuarios = '".$this->idusuarios."'; ";

		return $this->ejecutar();

	}

	public function listar(){

			$this->que_dba=" SELECT usuarios.*, nivel.*, estatus.* 
			FROM usuarios, nivel, estatus
			 WHERE usuarios.nivel_idnivel=nivel.idnivel
			 AND estatus.idestatus=usuarios.estatus_idestatus
			 AND company_idcompany = '".$_SESSION["idcompany"]."'; ";

		return $this->ejecutar();

	}

		public function listarIdUsu()
		{

			$this->que_dba = " SELECT * FROM usuarios u, nivel n
			 	WHERE u.idusuarios = '".$this->idusuarios."'
				AND u.nivel_idnivel = n.idnivel; ";

			return $this->ejecutar();
		}

		public function listarNivel()
		{

			$this->que_dba = "SELECT * FROM nivel";

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

	public function act_clave(){
			
		 $pass=MD5($this->new_pass);

			
    $this->que_dba="UPDATE usuarios SET pass = '".$pass."' WHERE idusuarios='".$_SESSION['idusuarios']."';"; 
		return $this->ejecutar();
	}

		public function listarMenu()
		{

			$this->que_dba = "SELECT * FROM menu_link m, grupo_menu g 
							  WHERE m.grupo_menu_idgrupo_menu = g.idgrupo_menu
							  ORDER BY g.idgrupo_menu ";

			return $this->ejecutar();
		}

		public function listarGrupo()
		{

			$this->que_dba = "SELECT * FROM grupo_menu g; ";

			return $this->ejecutar();
		}

		public function insertarGrupo(){

			$this->que_dba="INSERT INTO grupo_menu
			 (icono,
			 nombre 
			 )
			VALUES (
			'".$this->icono."',
			'".$this->nombre."'
			); ";

		return $this->ejecutar();
	}

		public function insertarMenu(){

			$this->que_dba="INSERT INTO menu_link
			 (nombre_link,
			 ruta,
			 grupo_menu_idgrupo_menu,
			 visible 
			 )
			VALUES (
			'".$this->nombre_link."',
			'".$this->ruta."',
			'".$this->grupo_menu_idgrupo_menu."',
			'1'
			); ";

		return $this->ejecutar();
	}

	public function eliminarMenu(){

			$this->que_dba="DELETE FROM menu_link
			WHERE idmenu_link = '".$this->idmenu_link."'; ";

		return $this->ejecutar();

	}

	public function editarMenu(){

			$this->que_dba="UPDATE menu_link SET
			nombre_link = '".$this->nombre_link."',
			ruta = '".$this->ruta."',
			grupo_menu_idgrupo_menu = '".$this->grupo_menu_idgrupo_menu."'
			WHERE idmenu_link = '".$this->idmenu_link."'; ";

		return $this->ejecutar();

	}

	public function editarGrupo(){

			$this->que_dba="UPDATE grupo_menu SET
			nombre = '".$this->nombre."',
			icono = '".$this->icono."'
			WHERE idgrupo_menu = '".$this->idgrupo_menu."'; ";

		return $this->ejecutar();

	}

	public function buscarMenu(){

			$this->que_dba= "SELECT * FROM menu_link WHERE idmenu_link = '".$this->idmenu_link."'; ";

		return $this->ejecutar();

	}

	public function buscarGrupo(){

			$this->que_dba= "SELECT * FROM grupo_menu WHERE idgrupo_menu = '".$this->idgrupo_menu."'; ";

		return $this->ejecutar();

	}

	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>