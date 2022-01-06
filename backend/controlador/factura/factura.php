<?php
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("../../clase/factura.class.php");
$obj_factura= new factura;

/*Datos para conectarse al server*/
$obj_factura->cod_router = $_GET["rou"];
$obj_factura->asignar_valor();
$obj_factura->puntero = $obj_factura->routerConnect();
$conexion = $obj_factura->extraer_dato();

$obj_factura->ip_api = $conexion['ip_router'];
$obj_factura->lo_api = $conexion['user_router'];
$obj_factura->pa_api = $conexion['pass_router'];
$obj_factura->po_api = $conexion['puerto_router'];
$obj_factura->bl_api = $conexion['blacklist_router'];
$obj_factura->wl_api = $conexion['whitelist_router'];
/*--------------------------------*/

$obj_factura->asignar_valor();

/* ACCION ME DIRA QUE DEBO HACER*/
switch ($_REQUEST["accion"]) {
	case 'registrarPago':  $obj_factura->resultado=$obj_factura->registrarPago(); 
						break;

	case 'crearFactura':  $obj_factura->resultado=$obj_factura->crearFactura(); 
						break;

	case 'eliminarFactura':  $obj_factura->resultado=$obj_factura->eliminarFactura(); 
						break;

	case 'actualizarFactura':  $obj_factura->resultado=$obj_factura->actualizarFactura(); 
						break;

	case 'actualizarFacturaPaga':  $obj_factura->resultado=$obj_factura->actualizarFacturaPaga(); 
						break;

	case 'cerrarCaja':  $obj_factura->resultado=$obj_factura->cerrarCaja(); 
						break;

			
}
	


}	
else 
{
	header("location: ../../../index.php");
	exit();
}
