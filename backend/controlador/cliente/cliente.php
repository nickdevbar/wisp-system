<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("../../clase/cliente.class.php");
$obj_cliente= new cliente;

/*Datos para conectarse al server*/
$obj_cliente->cod_router = $_GET["rou"];
$obj_cliente->asignar_valor();
$obj_cliente->puntero = $obj_cliente->routerConnect();
$conexion = $obj_cliente->extraer_dato();

$obj_cliente->ip_api = $conexion['ip_router'];
$obj_cliente->lo_api = $conexion['user_router'];
$obj_cliente->pa_api = $conexion['pass_router'];
$obj_cliente->po_api = $conexion['puerto_router'];
$obj_cliente->bl_api = $conexion['blacklist_router'];
$obj_cliente->wl_api = $conexion['whitelist_router'];
/*--------------------------------*/

$obj_cliente->asignar_valor();

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {
	case 'editar':  $obj_cliente->resultado=$obj_cliente->editar(); 
						break;

	case 'editaContrato':  $obj_cliente->resultado=$obj_cliente->editarContrato(); 
						break;

	case 'auditoriaContrato':  $obj_cliente->resultado=$obj_cliente->auditoriaContrato(); 
						break;

	case 'desactivarContrato':  $obj_cliente->resultado=$obj_cliente->desactivarContrato(); 
						break;

	case 'activarContrato':  $obj_cliente->resultado=$obj_cliente->activarContrato(); 
						break;

	case 'addCliente':  $obj_cliente->resultado=$obj_cliente->addCliente(); 
						break;

	case 'listarCedula':  $obj_cliente->resultado=$obj_cliente->listarCedula(); 
						break;

	case 'addPositivo':  $obj_cliente->resultado=$obj_cliente->addPositivo(); 
						break;

	case 'addNegativo':  $obj_cliente->resultado=$obj_cliente->addNegativo(); 
						break;

	case 'completarContrato':  $obj_cliente->resultado=$obj_cliente->completarContrato(); 
						break;

	case 'editarEstudio':  $obj_cliente->resultado=$obj_cliente->editarEstudio(); 
						break;

	case 'editarIP':  $obj_cliente->resultado=$obj_cliente->editarIP(); 
						break;

	case 'editarRouter':  $obj_cliente->resultado=$obj_cliente->editarRouter(); 
						break;

			
}
	


}	
else 
{
	header("location: ../../../index.php");
	exit();
}
