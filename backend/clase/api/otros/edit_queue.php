<?php
session_start();

if (isset($_SESSION['usuario'],$_SESSION['idusuarios'])){
include("conexion_api.php");


echo $ipqueue=$ip."/32";

if($version=='5'){

		
			///// CAMBIO DE PLAN
				$API->write("/queue/simple/getall",false);
		       $API->write('?target-addresses='.$ipqueue,true);
		       $READ = $API->read(false);
		       $ARRAY = $API->parse_response($READ); 

		        if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito

					$API->write("/queue/simple/set",false);  
					$API->write("=.id=".$ARRAY[0]['.id'],false);
		            $API->write('=max-limit='.$maxlimit,true);   //   2M/2M   [TX/RX]			
					$READ = $API->read(false);
					$ARRAY = $API->parse_response($READ);
		        }

		    if($API){
		        ///// CAMBIO MAC
		       $API->write("/ip/arp/getall",false);
		       $API->write('?address='.$ip,true);
		       $READ = $API->read(false);
		       $ARRAY = $API->parse_response($READ); 

		        if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
		      
					$API->write("/ip/arp/set",false);  
					$API->write("=.id=".$ARRAY[0]['.id'],false);
		            $API->write('=mac-address='.$mac,true);   //   2M/2M   [TX/RX]			
					$READ = $API->read(false);
					$ARRAY = $API->parse_response($READ);
				
		        }
			}
					//		}
		
    }else {
	
	///// CAMBIO DE PLAN
			$API->write("/queue/simple/getall",false);
		       $API->write('?target='.$ipqueue,true);
		       $READ = $API->read(false);
		       $ARRAY = $API->parse_response($READ); 

		        if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
		        
					$API->write("/queue/simple/set",false);  
					$API->write("=.id=".$ARRAY[0]['.id'],false);
		            $API->write('=max-limit='.$maxlimit,true);   //   2M/2M   [TX/RX]			
					$READ = $API->read(false);
					$ARRAY = $API->parse_response($READ);
		        }



		          if($API){
		        ///// CAMBIO MAC
		       $API->write("/ip/arp/getall",false);
		       $API->write('?address='.$ip,true);
		       $READ = $API->read(false);
		       $ARRAY = $API->parse_response($READ); 

		        if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
		      
					$API->write("/ip/arp/set",false);  
					$API->write("=.id=".$ARRAY[0]['.id'],false);
		            $API->write('=mac-address='.$mac,true);   //   2M/2M   [TX/RX]			
					$READ = $API->read(false);
					$ARRAY = $API->parse_response($READ);
				
		        }
			}

		}
    

}
?>