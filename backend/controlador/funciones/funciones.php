<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("../../clase/funciones.class.php");
	
$obj_funciones= new funciones;
$obj_funciones->asignar_valor();

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {
	case 'deleteRouter':  $obj_funciones->resultado=$obj_funciones->deleteRouter(); 
						break;
	case 'deletePlan':  $obj_funciones->resultado=$obj_funciones->deletePlan(); 
						break;
	case 'deleteUsuario':  $obj_funciones->resultado=$obj_funciones->deleteUsuario(); 
						break;

	case 'editRouter':  $obj_funciones->resultado=$obj_funciones->editRouter(); 
						break;
	case 'editPlan':  $obj_funciones->resultado=$obj_funciones->editPlan(); 
						break;
	case 'editUsuario':  $obj_funciones->resultado=$obj_funciones->editUsuario(); 
						break;

	case 'addRouter':  $obj_funciones->resultado=$obj_funciones->addRouter(); 
						break;
	case 'addPlan':  $obj_funciones->resultado=$obj_funciones->addPlan(); 
						break;
	case 'addUsuario':  $obj_funciones->resultado=$obj_funciones->addUsuario(); 
						break;

			
}
	


}	
else 
{
	header("location: ../../../index.php");
	exit();
}
