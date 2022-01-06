<?php

if(!session_id())
session_start();
if (isset($_SESSION ["idusuarios"],$_SESSION ["idcompany"])){
require('../../backend/clase/company.class.php');
require('../../backend/clase/server_mail.class.php');
require('../../backend/clase/abono.class.php');
//require('../../backend/clase/mail.class.php');

require 'lib/PHPMailer.php';
require 'lib/SMTP.php';
require 'lib/Exception.php';
require 'lib/OAuth.php';

$obj_company= new company;
$obj_company->idcompany=$_SESSION ["idcompany"];
$obj_company->puntero=$obj_company->listar();
$arre_empresa=$obj_company->extraer_dato();

$obj_server_mail=new server_mail;
$obj_server_mail->puntero=$obj_server_mail->listar();
$arre_server_mail=$obj_server_mail->extraer_dato();

$obj_abono=new abono;
$obj_abono->contrato=$_REQUEST["contrato"];
$obj_abono->cod_abo=$_REQUEST["cod_abo"];
$obj_abono->asignar_valor();
$obj_abono->puntero=$obj_abono->recibo_abono();
$arre_abono=$obj_abono->extraer_dato();



$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->SMTPDebug = 0;
$mail->Host = $arre_server_mail["host_ser_ema"];
$mail->Port = $arre_server_mail["pue_ser_ema"];
//$mail->Port = "25";
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $arre_server_mail["ema_ser_ema"];
$mail->Password = $arre_server_mail["cla_ser_ema"];
$mail->setFrom($arre_server_mail["ema_ser_ema"], $arre_server_mail["nom_ser_ema"]);






$mail->isSMTP();
/*
Enable SMTP debugging
0 = off (for production use)
1 = client messages
2 = client and server messages
*/
echo $mensaje='
<div style="text-align: center;">
<h1><strong>Hola, '.$arre_abono["nombres"].'</strong></h1>
<p><strong>Registro de Abono # <span style="color: #ff0000;">'.$arre_abono["cod_abo"].'</span></strong></p>
<p><strong>Registrado el dia  <span style="color: #ff0000;">'.$arre_abono["fec_abo"].'</span></strong></p>
</div>
<p>&nbsp;</p>

<p style="text-align: center;">-------------------------------------------------------------------------------------------------------------------------------</p>
<table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
<tbody>
<tr style="height: 18px; background-color: #0fcfff;">
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #000000;">
<strong>ITEM</strong></span></td>
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #000000;"><strong>DESCRIPCIÓN</strong></span></td>
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #000000;"><strong>Monto</strong></span></td>
</tr>
<tr style="height: 18px;">
<td style="width: 33.3333%; height: 18px; text-align: center;">1</td>
<td style="width: 33.3333%; height: 18px; text-align: center;">'.$arre_abono["des_abo"].'</td>
<td style="width: 33.3333%; height: 18px; text-align: center;">'.number_format($arre_abono["mon_abo"], 2, ',', '.').'</td>
</tr>
<tr style="height: 18px;">

</tr>
</tbody>
</table>
<div style=" height: 18px; text-align: center;">Monto Total '.number_format($arre_abono["mon_abo"], 2, ',', '.').'</div>

<p style="text-align: center;">-------------------------------------------------------------------------------------------------------------------------------</p>
<p><strong><span style="color: #ff0000;">NOTA:</span></strong> <strong>Recibo no valido como Factura Fiscal.</strong></p>
<p><strong>Gracias Por Preferirnos.</strong></p>

<p style="text-align: center;"><strong>Telefono de Contacto.</strong></p>
<p style="text-align: center;"><a href="http://wa.me/'.$arre_empresa["telef"].'?text=Cliente:'.$arre_pago_factura["nombre_cliente"].' target="_black"> '.$arre_empresa["telef"].'</a></p>

<p style="text-align: center;"><a href="http://wa.me/'.$arre_empresa["telef_fijo"].'?text=Cliente:'.$arre_pago_factura["nombre_cliente"].' target="_black"> '.$arre_empresa["telef_fijo"].'</a></p>

<p style="text-align: center;"><strong>Redes Sociales</strong></p>

<p style="text-align: center;"><strong>Instagram <a href="https://www.instagram.com/'.$arre_empresa["instagram"].'/">'.$arre_empresa["instagram"].'</a></strong></p>

<p style="text-align: center;"><strong>Web <a href="http://'.$arre_empresa["web"].'" target="_black">'.$arre_empresa["web"].'</a></strong></p>

<p style="text-align: center;"><strong>Email: '.$arre_empresa["email"].'</strong></p>
<p style="text-align: center;"><strong>Horario de Atenci&oacute;n</strong></p>
<p style="text-align: center;"><strong>Lun-Vie 08:00 AM - 12:00PM / 02:00 PM - 05:00PM&nbsp;</strong></p>';


$mail->addAddress($arre_abono["email"], $arre_abono["nombres"]);
$mail->Subject = 'Recibo de Abono('.$arre_abono["cod_abo"].')';
$mail->Body = $mensaje;
$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
$mail->IsHTML(true);

          if (!$mail->send())
          {
          	echo "Error al enviar el E-Mail: ".$mail->ErrorInfo;
          }
          else
          {
          	echo "E-Mail enviado";
          }
}else{
    header("location: ../../index.php");
    exit();

}
?>