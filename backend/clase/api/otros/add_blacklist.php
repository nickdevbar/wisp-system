<?php 
///// agrega a lista de bloqueados

include("conexion_api.php");
 // direccion que cargaremos en el address-list

  
if($desinstalacion=='1')
{

$comment= "IP LIBRE POR DESINSTALACION".$ip; // comentario
$maxlimit="1k/1k";
/////////////////  crea la ip nueva con nombre del cliente y plan contratado
$API->write("/queue/simple/add",false);
$API->write('=target-addresses='.$ip,false);
$API->write('=name='.$comment,false);
$API->write('=max-limit='.$maxlimit,false);
$API->write('=comment='.$comment,true);
   $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);

  $API->write("/ip/firewall/address-list/getall",false);
       $API->write('?address='.$ip,false);
       $API->write('?list='.$blacklist,true);       
       $READ = $API->read(false);
       $ARRAY = $API->parse_response($READ); // busco si ya existe
        if(count($ARRAY)>0){ 
          echo "Error: Ya existe " . $blacklist ." con la direccion: ".$ip;
        }else{ // si no existe lo creo
            $API->write("/ip/firewall/address-list/add",false);
            $API->write('=address='.$ip,false);   // IP
            $API->write('=list='.$blacklist,false);       // lista
            $API->write('=comment='.$comment,true);  // comentario
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);
       }
        $API->disconnect();

}else{


$comment= "$nombres"; // comentario

       $API->write("/ip/firewall/address-list/getall",false);
       $API->write('?address='.$ip,false);
       $API->write('?list='.$blacklist,true);       
       $READ = $API->read(false);
       $ARRAY = $API->parse_response($READ); // busco si ya existe
        if(count($ARRAY)>0){ 
          echo "Error: Ya existe " . $blacklist ." con la direccion: ".$ip;
        }else{ // si no existe lo creo
            $API->write("/ip/firewall/address-list/add",false);
            $API->write('=address='.$ip,false);   // IP
            $API->write('=list='.$blacklist,false);       // lista
            $API->write('=comment='.$comment,true);  // comentario
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);
       }
        $API->disconnect();

}

?>