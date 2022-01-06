<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

	class grupo_menu extends utilidad {

	public $idgrupo_menu;
	public $icono;
	public $nombre;

	

	public function listar(){

			$this->que_dba= "SELECT *
			FROM grupo_menu ORDER BY nom_gru_men";

		return $this->ejecutar();

	}

	public function listar_menu(){

			$this->que_dba="SELECT *
			FROM menu_link WHERE grupo_menu_cod_gru_men = '".$this->grupo_menu_cod_gru_men."';";

		return $this->ejecutar();

	}

	public function existenRouters(){

		$this->que_dba="SELECT COUNT(*) AS existe FROM routers r, segmentos_ip s
		WHERE r.company_cod_company = '".$_SESSION['company']."'
		AND r.cod_router = s.routers_cod_router";

	return $this->ejecutar();

}

public function soloServer(){

	$this->que_dba="SELECT * FROM grupo_menu 
	WHERE cod_gru_men = '4'";

return $this->ejecutar();

}

				
	} // Fin de clase
	
}else {
	header("location: ../../index.php");
	exit();
}
?>