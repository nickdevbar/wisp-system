<?php 
session_start();

if (isset($_SESSION ["usuario"],$_SESSION ["idusuarios"],$_SESSION ["nombres"])){
$corte=$_GET["fecha_corte"];



$r = $conexion->ejecutar("SELECT clientes.*, contratos.*,detalles_contratos.*,ips.*, lista_cobro.*,fecha_corte.* 
			 FROM clientes,contratos,detalles_contratos,ips, lista_cobro,fecha_corte 
WHERE clientes.idclientes=contratos.clientes_idclientes
AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
AND contratos.fecha_corte_idfecha_corte=fecha_corte.idfecha_corte
AND contratos.idcontratos=lista_cobro.contratos_idcontratos
AND detalles_contratos.ips_idips=ips.idips
AND contratos.estatus_idestatus='1'
AND fecha_corte.idfecha_corte='".$corte."'
AND lista_cobro.deuda>0");
		   $n = mysql_num_rows($r);
		 
		 $a=0;
		
		   ?>
		      <table class="table table-responsive">
	          <tr>
	            <td align="center"><h3>Listado de Clientes Suspendidos (<? echo $n;?>)</h3></td>
              </tr>
        </table>
			<?php if($n>0){ ?>
		<table class="table table-responsive">
		<tr  class="bg bg-primary">
			<th>Contrato</th>
			<th>Nombres / Razón Social</th>
			<th>Telefono</th>
			<th>IP</th>
			<th>Fecha de Corte</th>
			<th>Opción</th>
		</tr>
	
	<?php	
	while($row=mysql_fetch_array($r)){ ?>	
	<tr>
		<th><?php echo $idcontratos=$row["idcontratos"]; ?></th>
		<th><?php echo $client=$row["nombres"]; ?> </th>
		<th><?php echo $row["telefono"]; ?> </th>
		<th><?php echo $ip=$row["ip_contrato"]; ?> </th>
		<th><?php echo $row["dia"]; ?> De Cada Mes </th>
		<th><i class="fa fa-check"></i></th>
	</tr>
		<?php

		/// VARIABLES DE FORMULARIO
		$comment= "Contrato N ".$idcontratos." ".$client; // comentario
	
		       $API->write("/ip/firewall/address-list/getall",false);
		       $API->write('?address='.$ip,false);
		       $API->write('?list='.$blacklist,true);       
		       $READ = $API->read(false);
		       $ARRAY = $API->parse_response($READ); // busco si ya existe
		        if(count($ARRAY)>0){ 
		        	
		        }else{
							// si no existe lo creo
		            $API->write("/ip/firewall/address-list/add",false);
		            $API->write('=address='.$ip,false);   // IP
		            $API->write('=list='.$blacklist,false);       // lista
		            $API->write('=comment='.$comment,true);  // comentario
		            $READ = $API->read(false);
		            $ARRAY = $API->parse_response($READ);
		     
		       } //   $API->disconnect();
		    }
		       ?>
		   
		 </table>
	<?php	/// cierre del black list

}//cierre de if
	
}
else{
    header("location: ../index.php");
    exit();

}
?>