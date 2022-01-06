<?php


include("conexion_api.php");


$API->comm('/ip/arp/add', array(
"address" => $ip, 
"interface" => $interfaz,
"mac-address" => $mac,
"comment" => $client,

));


if($ARRAY)
	{ echo "Creado";}
else{ echo "Error"; }

?>