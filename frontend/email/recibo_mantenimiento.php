<?php

if(!session_id())
session_start();
if (isset($_SESSION ["cod_usu"])){
  require_once('../../backend/clase/company.class.php');
  require_once('../../backend/clase/mantenimiento.class.php');
  
  $obj_company= new company;
  $obj_company->cod_company=$_SESSION ["company"];
  $obj_company->puntero=$obj_company->listar();
  $empresa=$obj_company->extraer_dato();
  
  $obj_company->puntero=$obj_company->listar_mail();
  $email=$obj_company->extraer_dato();
  
  $obj_man = new mantenimiento;
  $obj_man->cod_contratos = $_GET["contrato"];
  $obj_man->asignar_valor();
  $obj_man->puntero = $obj_man->listar_mantenimiento();
  $man = $obj_man->extraer_dato(); 
  
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
  $mail->addAddress($man['ema_cli'], $man['nom_cli']);     //Add a recipient
      

echo $mensaje='
<!DOCTYPE html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="date=no">
  <meta name="format-detection" content="telephone=no">
  <title>Email De Mantenimiento&reg;</title>
  <link rel="stylesheet" type="text/css" href="' . constant("URL") . 'php/mail/styles.css">
  <link rel="stylesheet" type="text/css" href="./mantenimiento.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
  </head>
  <body>

  <table border="0" width="100%" height="100%" bgcolor="#F0F0F0">
  <tr>
  <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

  <table border="0" width="600" class="container" style="background: #F0F0F0;">
    <thead>
  <tr>
  <td>
  <div style="display:grid;grid-template-columns:0.5fr 3fr;">
  
  <img src="../img/'.$empresa["logo_company"].'" alt="" width="100%px">
  <div style="text-align:center;">
  <h1 style="font-family: "Roboto Condensed", sans-serif;">'.$empresa["razon_social"]. '</h1>
  <h2>' .$empresa["tipo_company"] . $empresa["rif_company"] . '</h2>
  </div>
  </div>
  </td> 
    </tr>
    </thead>
    <tbody>

    <tr>

        <td colspan=2><div class="body-text">
        <br>
       
  <h3>Hola, ' . $man["nom_cli"] . '</h3>
  <h4 style="vertical-align: center;" style="font-family: "Roboto Condensed", sans-serif;">Le hacemos llegar a ustedes la siguiente notificación: Un Mensaje De Mantenimiento</h4>
  <p>Adjunto a este mensaje encontrara más detalles.</p>
  
  Codigo del Mantenimiento = <b>'.$man["cod_man"]. '</b><br>
  Nombre del problema = <b>' . $man["nom_fallas"] . '</b><br>
  Descripcion del problema = <b>'. $man["obs_man"]. '</b><br>
  Estatus = <b>' . $man["nom_est"] . '</b><br>
  <br>
  
  <p align=center>Cordialmente <br><b>El equipo de '. $empresa["razon_social"] . '</b><br>
  <a href="https://wa.me/+'. $empresa["tel_company"] . '">+'. $empresa["tel_company"] . ' </a>
  </p>
  </div></td>
    


    </tr>
    </tbody>
</table>

  </td>
  </tr>
  </table>
  
  
    </body>
</html>';

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Mantenimiento Pendiente para  #'.$man['nom_cli'];
$mail->Body    = $mensaje;
$mail->AltBody = 'Mantenimiento Pendiente....';

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
