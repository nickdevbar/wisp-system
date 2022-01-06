<?php
session_start();

if (isset($_SESSION['cod_usu'])) {

 require_once("../../clase/ips.class.php");

$obj_ips =  new ips;

/*Datos para conectarse al server*/
$obj_ips->cod_router = $_GET["rou"];
$obj_ips->asignar_valor();
$obj_ips->puntero = $obj_ips->routerConnect();
$conexion = $obj_ips->extraer_dato();

$obj_ips->ip_api = $conexion['ip_router'];
$obj_ips->lo_api = $conexion['user_router'];
$obj_ips->pa_api = $conexion['pass_router'];
$obj_ips->po_api = $conexion['puerto_router'];
$obj_ips->bl_api = $conexion['blacklist_router'];
$obj_ips->wl_api = $conexion['whitelist_router'];
/*--------------------------------*/

$obj_ips->asignar_valor();  

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {

	case 'insertarSegmento':  $obj_ips->resultado=$obj_ips->insertarSegmento(); 			
						break;
		
	case 'insertarIP':  $obj_ips->resultado=$obj_ips->insertarIP(); 			
						break;

	case 'cambiarIP':  $obj_ips->resultado=$obj_ips->cambiarIP(); 			
						break;

	case 'eliminarSegmento':  $obj_ips->resultado=$obj_ips->eliminarSegmento(); 			
						break;

	case 'cambiarSeg':  $obj_ips->resultado=$obj_ips->cambiarSeg(); 			
						break;

	case 'addRules':  $obj_ips->resultado=$obj_ips->addRules(); 			
						break;
						
	}

}else 
	{
		header("location: ../../../index.php");
		exit();
	}
