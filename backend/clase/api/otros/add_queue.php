<?php
session_start();

if (isset($_SESSION['usuario'],$_SESSION['idusuarios'])){
require("../server.class.php");
include("conexion_api.php");


if($version=='5'){

						$API-> comm('/queue/simple/add', array (
						"name" => "Contrato N ".$idcontratos." ".$nombre_cliente,
						"target-addresses" => $ip,
						"max-limit" => $maxlimit));
						if($API){
						$API->comm('/ip/arp/add', array(
						"address" => $ip, 
						"interface" => $interfaz,
						"mac-address" => $mac,
						"comment" => "Contrato N ".$idcontratos." ".$nombre_cliente));
					}else { echo "ERROR NO CREO ARP";}
	}else{
					     
		$API->comm("/queue/simple/add",array(
		'target'=>$ip,
		"name" => "Contrato N ".$idcontratos." ".$nombre_cliente,
		'max-limit'=>$maxlimit));   

		if($API){
		$API->comm('/ip/arp/add', array(
		"address" => $ip, 
		"interface" => $interfaz,
		"mac-address" => $mac,
		"comment" => "Contrato N ".$idcontratos." ".$nombre_cliente));                   
		}else{ echo "ERRO NO CREO ARP"; }
		}  
	if($API){
		echo "Creado";
	}else{
		echo "Error al Crear IP";
	} 
    

}
?>