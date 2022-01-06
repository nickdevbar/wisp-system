<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");


	class funciones extends utilidad {


		public function deleteRouter (){
			$this->que_dba="DELETE FROM routers
			WHERE cod_router = '".$this->cod_router."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		public function deletePlan (){
			$this->que_dba="DELETE FROM planes
			WHERE cod_plan = '".$this->cod_plan."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		public function deleteUsuario (){
			$this->que_dba="DELETE FROM usuarios
			WHERE cod_usu = '".$this->cod_usu."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		/***************************************************** */

		public function editRouter (){
			$this->que_dba="UPDATE routers SET
			
			nom_router = '".$this->nom_router."',
			user_router = '".$this->user_router."',
			pass_router = '".$this->pass_router."',
			ip_router = '".$this->ip_router."',
			puerto_router = '".$this->puerto_router."',
			puerto_graf = '".$this->puerto_graf."',
			blacklist_router = '".$this->blacklist_router."',
			whitelist_router = '".$this->whitelist_router."'

			WHERE cod_router = '".$this->cod_router."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		public function editPlan (){
			$this->que_dba="UPDATE planes SET
			
			nom_plan = '".$this->nom_plan."',
			pre_plan = '".$this->pre_plan."',
			vel_sub_plan = '".$this->vel_sub_plan."',
			tx = 'M',
			vel_des_plan = '".$this->vel_des_plan."',
			rx = 'M'

			WHERE cod_plan = '".$this->cod_plan."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		public function editUsuario (){
			$this->que_dba="UPDATE usuarios SET

			nom_usu = '".$this->nom_usu."',
			ape_usu = '".$this->ape_usu."',
			usu_user = '".$this->usu_user."',
			fec_usu = '".$this->fec_usu."',
			tel_usu = '".$this->tel_usu."',
			roles_cod_rol = '".$this->roles_cod_rol."'

			WHERE cod_usu = '".$this->cod_usu."'
			AND company_cod_company = '".$_SESSION['company']."';";
			echo "1";
			return $this->ejecutar();
		}

		/******************************************************* */

		public function addRouter (){
			$this->que_dba="INSERT INTO routers 
			(
			nom_router,
			user_router,
			pass_router,
			ip_router,
			puerto_router,
			puerto_graf,
			blacklist_router,
			whitelist_router,
			fec_cre_router,
			company_cod_company,
			estatus_cod_est
			)VALUES(
			'".$this->nom_router."',
			'".$this->user_router."',
			'".$this->pass_router."',
			'".$this->ip_router."',
			'".$this->puerto_router."',
			'".$this->puerto_graf."',
			'".$this->blacklist_router."',
			'".$this->whitelist_router."',
			Now(),
			'".$_SESSION['company']."',
			'1'
			)";
			echo "1";
			return $this->ejecutar();
		}

		public function addPlan (){
			$this->que_dba="INSERT INTO planes
			(
			nom_plan,
			pre_plan,
			vel_sub_plan,
			tx,
			vel_des_plan,
			rx,
			fec_cre_plan,
			estatus_cod_est,
			company_cod_company
			)VALUES(
			'".$this->nom_plan."',
			'".$this->pre_plan."',
			'".$this->vel_sub_plan."',
			'M',
			'".$this->vel_des_plan."',
			'M',
			Now(),
			'1',
			'".$_SESSION['company']."'
			)";
			echo "1";
			return $this->ejecutar();
		}

		public function addUsuario (){

			$pass = md5($this->usu_pass);

			$this->que_dba="INSERT INTO usuarios
			(
			nom_usu,
			ape_usu,
			usu_user,
			usu_pass,
			fec_usu,
			tel_usu,
			estatus_cod_est,
			company_cod_company,
			roles_cod_rol
			)VALUES(
			'".$this->nom_usu."',
			'".$this->ape_usu."',
			'".$this->usu_user."',
			'".$pass."',
			Now(),
			'".$this->tel_usu."',
			'1',
			'".$_SESSION['company']."',
			'".$this->roles_cod_rol."'
			)";

			echo $this->que_dba;
			return $this->ejecutar();
		}

		public function roles (){
			$this->que_dba="SELECT * FROM roles";
			return $this->ejecutar();
		}



	
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
