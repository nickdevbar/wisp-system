<?php
 if(!session_id()) 
session_start();

if (isset($_SESSION ["cod_usu"])){
 //require_once('api_mt_include2.php'); 
require_once('api_mt.php'); 
require_once('../cliente.class.php');

	$interface = $_GET["interface"]; //"<pppoe-nombreusuario>";

	$contrato = $_GET["contrato"]; //"<pppoe-nombreusuario>";

	$obj_cliente = new cliente;

	$obj_cliente->idcontratos = $contrato;
	$obj_cliente->asignar_valor();
	$obj_cliente->puntero = $obj_cliente->buscarServerxContrato();
	$servidor = $obj_cliente->extraer_dato();

	$ipcontrato = $servidor['ip_contrato'];

	$ip_api = $servidor['ip_router'];
	$lo_api = $servidor['user_router'];
	$pa_api = $servidor['pass_router'];
	$po_api = $servidor['puerto_router'];

	/* echo $ip_api .'<br/>';
	echo $lo_api .'<br/>';
	echo $pa_api .'<br/>';
	echo $po_api .'<br/>';
	echo $interface .'<br/>';
	echo $ipcontrato .'<br/>'; */
	
	$API = new routeros_api();
	$API->debug = false;
	
	$API->ip_router_api = $ip_api;
	$API->login_api = $lo_api;
	$API->password_api = $pa_api;
	$API->port_api = $po_api;
	
	if ($API->connect()) { 
		//echo 'PASO POR AQUI<br/>';


			$API->write("/queue/simple/print",false);
			$API->write("=stats",false);
			$API->write("?target="."$ipcontrato"."/32",true);  
			$READ = $API->read(false);
			$ARRAY = $API->parseResponse($READ);

			//echo count($ARRAY);
			//print_r($ARRAY[0]);
			 if(count($ARRAY)>0){  
				 $rx = explode("/",$ARRAY[0]["rate"])[0];
				 $tx = explode("/",$ARRAY[0]["rate"])[1];
				 $rows['name'] = 'Tx';
				 $rows['data'][] = $tx;
				 $rows2['name'] = 'Rx';
				 $rows2['data'][] = $rx;
			
			 }else{  
				 echo $ARRAY['!trap'][0]['message'];
			//echo '<br/>PASO POR AQUI<br/>';	 
			 } 
	}else{
		echo "<font color='#ff0000'>La conexion ha fallado. Verifique si el Api esta activo.</font>";
	}
	//$API->disconnect();

	$result = array();
	array_push($result,$rows);
	array_push($result,$rows2);
	print json_encode($result, JSON_NUMERIC_CHECK);



}
else{
    header("location: ../index.php");
    exit();

}
?>
