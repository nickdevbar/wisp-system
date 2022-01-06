<?php

require("utilidad.class.php");


class sesion extends utilidad {

public $usu_user; 
public $usu_pass;
public $clave;

		public function validar_sesion()
		{ 
			$clave=MD5($this->usu_pass);

			$this->que_dba="SELECT * FROM usuarios
			 WHERE usu_user = '".$this->usu_user."'
			 AND usu_pass = '".$clave."'; ";
			

			return $this->ejecutar();
		}/// FIN Validacion

		/* public function validar_sesion2()
		{ 
			
			$this->que_dba="SELECT * FROM clientes cl, contratos c, usuario_cliente uc
			 WHERE c.clientes_idclientes = cl.idclientes
			 AND uc.contratos_idcontratos = c.idcontratos
			 AND uc.clave = '".$this->clave."'
			 AND cl.email = '".$this->user."'; ";
			

			return $this->ejecutar();
		}/// FIN SELECT */

		public function cerrar()
		{

	session_start();
	session_destroy();
	  		/* setcookie("cod_usu_cli", "", time() - 1000, "/");
            setcookie("email", "", time() - 1000, "/");
            setcookie("clave", "", time() - 1000, "/");
            setcookie("idcontratos", "", time() - 1000, "/");
            setcookie("idclientes", "", time() - 1000, "/"); */
	
	header ("location: ../../../index.php");
	exit();

		}/// FIN SELECT
}
?>