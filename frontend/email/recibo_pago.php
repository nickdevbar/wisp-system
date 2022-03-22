<!-- <link rel="stylesheet" href="./recibo.css"> -->
<?php

if(!session_id())
session_start();
if (isset($_SESSION ["cod_usu"])){
require_once('../../backend/clase/company.class.php');

$obj_company = new company;
$obj_company->cod_company = $_SESSION ["company"];
$obj_company->puntero=$obj_company->listar();
$empresa=$obj_company->extraer_dato();

$obj_company->puntero=$obj_company->listar_mail();
$email=$obj_company->extraer_dato();
//print_r($email); 
$obj_company->cod_contratos = $_REQUEST["cod_contratos"];
$obj_company->cod_fac = $_REQUEST["cod_fac"];
$obj_company->asignar_valor();
$obj_company->puntero=$obj_company->recibo_pago();
$factura=$obj_company->extraer_dato();

require 'lib/Exception.php';
require 'lib/PHPMailer.php';
require 'lib/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer;

//Server settings
$mail->SMTPDebug = 0;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = $email['host_con_ema'];                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = $email['ema_con_ema'];                     //SMTP username
$mail->Password   = $email['pas_con_ema'];                               //SMTP password
$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
$mail->Port       = $email['pue_con_ema'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom($email['ema_con_ema'], $email['nom_con_ema']);
$mail->addAddress($factura['ema_cli'], $factura['nom_cli']);     //Add a recipient


echo $mensaje='
<div style="margin:0 !important;padding:0 !important;font-family:Arial,Helvetica,sans-serif;">
<h1><strong>Hola, '.$factura["nom_cli"].'</strong></h1>
<div class="cli" style="text-align:center;">
<p><strong>Recibo # <span style="color: #e74a3b;">'.$factura["num_factura"].'</span></strong></p>
<p><strong>Recibo Generado <span style="color: #e74a3b;">'.$obj_company->formatearFechaPrimero($factura["fec_cre_fac"]).'</span></strong></p>
<p><strong>Recibo Pagado <span style="color: #e74a3b;">'.$obj_company->formatearFechaPrimero($factura["fec_pag_fac"]).'</span></strong></p>
<p><strong>Pago Correspondiente al mes : <span style="color: #e74a3b;">'.$factura["mes_fac"].'</span></strong></p>

<p><strong>Forma de Pago <span style="color: #e74a3b;">'.$factura["nom_for_pag"].'</span></strong></p>

<p><strong>Su Fecha de Pago son los dias <span style="color: #e74a3b;">'.$factura["dia_fec_corte"].'</span> De Cada Mes</strong></p>
</div>


<table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
<tbody>
<tr class="thead" style="background-color:#4e73df;height:30px;">
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #ffffff;"><strong>ITEM</strong></span></td>
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #ffffff;"><strong>DESCRIPCIÓN</strong></span></td>
<td style="width: 33.3333%; text-align: center; height: 18px;"><span style="color: #ffffff;"><strong>PRECIO</strong></span></td>
</tr>
<tr class="tbody">
<td style="width: 33.3333%; height: 40px; text-align: center;">1</td>
<td style="width: 33.3333%; height: 40px; text-align: center;">'.$factura["obs_pag_fac"].'</td>
<td style="width: 33.3333%; height: 40px; text-align: center;">$'.number_format($factura["mon_pag_fac"], 0, '', '.').'</td>
</tr>
<tr style="height: 35px;">
<td><b>Monto Cancelado:</b></td>
<td colspan="2" style="text-align:right;">$'.number_format($factura["mon_pag_fac"], 0, '', '.').'</td>

</tr>
</tbody>
</table>


<div class="terms" style="text-align:center;">
<p><strong><span style="color: #e74a3b;">NOTA:</span></strong> Recibo no valido como Factura Fiscal.</p>
<p><strong>Gracias Por Preferirnos.<br>
<h2 style="color: #e74a3b;">Cuando no necesite del servicio por viaje u/o otro motivo, por favor notificar al proveedor para suspender el servicio y no generar cobros de mensualidad.</h2></strong></p>
</div>

<div style="padding:10px;">
<p style="text-align: center;"><strong>Proveeedor.</strong></p>
<p style="text-align: center;"><strong>'.$empresa["razon_social"].'</strong></p>
<p style="text-align: center;">Telefono:<strong><a href="http://wa.me/'.$empresa["tel_company"].'?text=Cliente:'.$factura["nombre_cliente"].' target="_black"> '.$empresa["tel_company"].'</a></strong></p>

<p style="text-align: center;"><strong>Redes Sociales.</strong></p>

<p style="text-align: center;">Instagram <strong><a href="https://www.instagram.com/'.$empresa["instagram_company"].'/">'.$empresa["instagram_company"].'</a></strong></p>

<p style="text-align: center;">Web:<strong> <a href="http://'.$empresa["fanpage_company"].'" target="_black">'.$empresa["fanpage_company"].'</a></strong></p>

<p style="text-align: center;">Email: <strong>'.$empresa["ema_company"].'</strong></p>
</div>
</div>';
//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Recibo de Pago #'.$factura['num_factura'];
$mail->Body    = $mensaje;
$mail->AltBody = 'Recibo Entregado...';

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
