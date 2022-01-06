<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

	class exportar extends utilidad {

		//////////////////////////

		public function fechaCorte()
		{

			$this->que_dba = "SELECT * FROM fecha_corte";

			return $this->ejecutar();
		}
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>
