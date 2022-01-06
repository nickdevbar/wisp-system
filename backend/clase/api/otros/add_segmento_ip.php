<?php
session_start();

if (isset($_SESSION['usuario'],$_SESSION['idusuarios'])){
include("conexion_api.php");
  

		$API->comm('/ip/address/add', array(
		"address" => $gateway, 
		"interface" => $interfaz,
		"comment" => $comentario));  
}else {
	header("location: ../../index.php");
	exit();
}
?>