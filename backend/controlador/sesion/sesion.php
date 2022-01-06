<?php 
require_once("../../clase/sesion.class.php");
/*  INSTANCIO  UN OBJETO DE LA CLASE USUARIO */

$obj_ses = new sesion;
$obj_ses->asignar_valor();

//echo $_REQUEST["accion"];

switch ($_REQUEST["accion"]) {
	case 'sesion':  
		
		$obj_ses->puntero=$obj_ses->validar_sesion(); 
		$usuario_sesion=$obj_ses->extraer_dato();

		echo $usuario_sesion["cod_usu"];
		echo $usuario_sesion["nom_usu"];
		echo $usuario_sesion["ape_usu"];
		echo $usuario_sesion["usu_user"];
		echo $usuario_sesion["company_cod_company"];
	
		if($usuario_sesion["cod_usu"]>0){
		
		// Variables de session de usuario

		session_start();
		$_SESSION["nom_usu"] = $usuario_sesion["nom_usu"];
		$_SESSION["ape_usu"] = $usuario_sesion["ape_usu"];
		$_SESSION["cod_usu"] =  $usuario_sesion["cod_usu"];
		$_SESSION["usu_user"] =  $usuario_sesion["usu_user"];
		$_SESSION["company"] =  $usuario_sesion["company_cod_company"];

			header("location:  ../../../frontend/pages/index.php");
			exit();

		}else{
			header("location:  ../../../index.php?val=2");
			exit();
		}


	case 'cerrar': $obj_ses->cerrar();

	header("location:  ../../../index.php");
	exit();

	default: 

	header("location:  ../../../index.php");
	exit(); 
}



?>