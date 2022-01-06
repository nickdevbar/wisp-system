<?php

require("librerias/api_mt.php");

	$API = new routeros_api();
$API->debug = false;
$ip_server="192.168.20.1";
 $user_server="root";
  $pass_server="10194714";
   $puert_server="8728";
$API->connect($ip_server,$user_server ,$pass_server ,$puert_server );
	//$this->connect($this->ip_server, $this->user_server, $this->pass_server, $this->puert_server);
if($API){
	$API->comm("/queue/simple/add",array(
		'target'=>"192.168.200.2",
		'name' => "Contrato N Yeimerprueba",
		'max-limit'=>"200kb/200kb")); 
		echo "Conectado";
}

?>