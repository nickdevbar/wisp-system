<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("../../clase/company.class.php");
	
$obj_company= new company;
$obj_company->asignar_valor();

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {

	case 'modificar':  $obj_company->resultado=$obj_company->modificar(); 
						break;

	case 'addCorreo':  $obj_company->resultado=$obj_company->addCorreo(); 
						break;

	case 'editCorreo':  $obj_company->resultado=$obj_company->editCorreo(); 
						break;
						
		
}
	


}	
else 
{
	header("location: ../../../index.php");
	exit();
}
