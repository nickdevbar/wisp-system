<?php

session_start();

if (isset($_SESSION["cod_usu"])){

require_once("../../backend/clase/mantenimiento.class.php");

  $obj_man = new mantenimiento;

    $obj_man->cod_man = $_GET["cod_man"];
    $obj_man->asignar_valor();
    $obj_man->puntero = $obj_man->consultarManR();
    $man = $obj_man->extraer_dato();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Orden de Mantenimiento #<?php echo $man["cod_man"]; ?></title>

<link href="mantenimiento.css" rel="stylesheet">

  </head>
  <body onload="//window.print();">
      <table width="100%" border="0">
          <tr>
        <td width="3%"><img src="../assets/images/logos/<?php echo $man["logo_company"]; ?>" width="80"></td>
        <th class="text-ce" width="40%"><h3><?php echo $man["razon_social"]; ?><h3></th>

          <th class="text-de" width="30%">
          Codigo # <a class="text-rojo" ><?php echo $man["cod_man"]; ?></a><br/>
          Fecha: <?php echo $obj_man->formatearSoloFecha($man["fec_man"]); ?><br/>
          Fecha Realizado: <?php echo $obj_man->formatearSoloFecha($man["fec_act_man"]); ?><br/>
          Costo del Mantenimiento: 
          </th>

      </tr>
        <tr>
        <th class="text-ce" colspan="3"><h3><u>Mantenimiento Realizado</u></h3></th>
     
        </tr>
      
        <tr>
          <th class="text-iz">Cliente:</th>
          <td colspan="2"><?php echo $man["nom_cli"]; ?> - #<?php echo $man["num_contrato"]; ?></td>

          
        </tr>
        <tr>
          <th class="text-iz">Direccion:</th>
          <td colspan="2"><?php echo $man["dir_cli"]; ?></td>
        </tr>
        <tr>
          <th class="text-iz">Punto de Refe.</th>
          <td colspan="2"><?php echo $man["pun_ref_cli"]; ?></td>
        </tr>
        <tr>
          <th class="text-iz">Telefonos:</th>
          <td colspan="2"><?php echo $man["tel_cli"].' --- '.$man["tel2_cli"];?></td>
        </tr>
          <tr>
          <th class="text-iz" colspan="">IP Navegacion:</th><td><?php echo $man["ip_contrato"]; ?>| <?php echo $man["nom_plan"]; ?>| <?php echo $man["mac_det_con"];?> 
          </td>
        </tr>
        <tr>
          <th class="text-iz">Falla:</th>
          <td colspan="2"><?php echo $man["nom_fallas"]; ?></td>
        </tr>
        <tr>
          <th class="text-iz">Solucion:</th>
          <td colspan="2"><?php echo $man["sol_act_man"]; ?></td>
        </tr>
        <tr>
          <th class="text-iz">Observaciones:</th>
          <td colspan="2"><?php echo $man["obs_act_man"]; ?></td>
        </tr> 
      </table>


      <table width="100%" class="principal">
        <tr class="lines">
          <th width="139" height="45" class="text-ce"><p>___________________________</p>
          <p>Firma Cliente </p></th>
          
          <th width="130"  class="text-ce"><p>___________________________</p>
          <p>Firma Tecnico </p></th>
        </tr>
      </table>
<hr>
 </body>
  </html>



<?php 
}else{
    header("location: ../index.php");
    exit();
}


?>
