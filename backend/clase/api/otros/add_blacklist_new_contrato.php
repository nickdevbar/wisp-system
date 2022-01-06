<?php
session_start();

if (isset($_SESSION['usuario'],$_SESSION['idusuarios'])){

require("conexion_api.php");

/////////////// ADD BLACK LIST
			$comment="Contrato N ".$idcontratos." ".$nombres;

            $API->write("/ip/firewall/address-list/add",false);
            $API->write('=address='.$ip_contrato,false);   // IP
            $API->write('=list='.$blacklist,false);       // lista
            $API->write('=comment='.$comment,true);  // comentario
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);
       
        $API->disconnect();

}	
else 
{
	header("location: ../../index.php");
	exit();
}

?>
?>