<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("../../clase/mantenimiento.class.php");
	
$obj_mantenimiento= new mantenimiento;
$obj_mantenimiento->asignar_valor();

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {
	
	case 'crearMan':  $obj_mantenimiento->resultado=$obj_mantenimiento->crearMan();
						break;

	case 'actualizarMan':  $obj_mantenimiento->resultado=$obj_mantenimiento->actualizarMan();
						break;
			
}
	


}	
else 
{
	header("location: ../../../index.php");
	exit();
}
