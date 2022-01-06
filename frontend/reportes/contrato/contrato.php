<?php 
session_start();
if (isset($_SESSION ["cod_usu"])){

require_once("../../../backend/clase/company.class.php");
require_once("../../../backend/clase/reporte.class.php");

$css=file_get_contents("style.css");

$obj_company= new company;
$obj_company->cod_company=$_SESSION ["company"];
$obj_company->puntero=$obj_company->listar();
$arre_empresa=$obj_company->extraer_dato();

$obj_reporte= new reporte;
$obj_reporte->cod_contratos=$_GET["contrato"];
$obj_reporte->puntero=$obj_reporte->con();
$arre_query=$obj_reporte->extraer_dato();


require_once("../vendor/autoload.php");
$mpdf=new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); 


$contrato='
<header>
<link rel="stylesheet" href="style.css">
</header>
<body >
  <table class="principal">
  <tr>
    <td>
      <table  border="0"  width="800">
      <tr>
        <td><img src="../../assets/images/logos/'.$arre_empresa["logo_company"].'" id="logo"></td>
        <th class="text-ce" width="400"><h2>'.$arre_empresa["razon_social"].'<br>'.$arre_empresa["tipo"].$arre_empresa["rif_company"].'</h2></th>

          <th class="text-iz">
          Contrato # <a class="text-rojo" > '.$_GET["contrato"].'</a><br/>
          Fecha de Instalación: ___/___/____
          </th>
      </tr>
      </table>
      <table width="auto" border="0">
        <tr>
        
        <th colspan="5" class="text-del"><h4><u>CONTRATO DE AFILICIACIÓN Y SUSCRIPCIÓN DE INTERNET</u></h4></th>
     
        </tr>
        <tr>
          <th class="text-de" colspan="5"><strong>Cedula:</strong> '.$arre_query["tipo_cli"].$arre_query["ced_cli"].'</th>
        </tr>
        <tr>
          <th class="text-de" colspan="5"><strong>Nombre:</strong> '.$arre_query["nom_cli"].'</th>
        </tr>
        <tr>
          <th class="text-de" colspan="5"><strong>Direccion:</strong> '.$arre_query["dir_cli"].'</th>
        </tr>
        <tr>
          <th class="text-de" colspan="5"><strong>Teléfonos:</strong> '.$arre_query["tel_cli"].' -- '.$arre_query["tel2_cli"].'</th>
        </tr>
        
          
         <td><hr/></td>
        <tr>

          <td class="contrato" colspan="5">Entre los suscritos <strong>'.$arre_empresa["razon_social"].'</strong> proveedor de internet legalmente registrado con el RIF: '.$arre_empresa["rif_company"].', domiciliado en '.$arre_empresa["dir_company"].', representada en este acto por su Presidente o por quien haga las veces autorizado para hacerlo, de una parte y la otra. <strong>EL <strong>SUSCRIPTOR</strong>,</strong> quien se define e identifica en primera parte del documento,se ha celebrado el siguiente contrato de afiliación y suscripción al servicio de internet denominado acceso a internet contenido en las siguientes clausulas: <strong>PRIMERA: OBJETO.</strong> El objeto del presente contrato es la prestación del servicio de acceso inalámbrico a internet en conexión que presta <strong>'.$arre_empresa["razon_social"].'</strong>, el cual recibira <strong>EL <strong>SUSCRIPTOR</strong></strong> en las condiciones en la que este documento se define. <strong>SEGUNDA OBLIGACION DE '.$arre_empresa["razon_social"].' :</strong> <strong>'.$arre_empresa["razon_social"].'</strong> se obliga a: <strong>1</strong>. Previa firma del presente contrato y <strong>'.$arre_empresa["razon_social"].'</strong> se encarga de efectuar los trabajos necesarios para la instalación del servicio de acceso inalámbrico a internet (en la sucesivo, el servicio), trabajos que contemplan torres, antenas, equipos, pruebas puestas en marcha del sistema en sitio al SUSCRITOR, a través de su propia red y/o en asocio con otro operador. <strong>2</strong> <strong>'.$arre_empresa["razon_social"].'</strong> podrá vender al SUSCRITOR uno o varios servicios adicionales a las tarifas  establecidas por <strong>'.$arre_empresa["razon_social"].'</strong> <strong>3. '.$arre_empresa["razon_social"].'</strong> se reservara el derecho de modificar en cualquier momento las características técnicas del servicio contratado y el SUSCRITOR lo acepta expresamente. En consecuencia <strong>'.$arre_empresa["razon_social"].'</strong> podrá aumentar o restringir el canal, tráfico o capacidad, transmisión o recepción, contenido e información recibida y transmitida por el <strong>SUSCRIPTOR</strong> inicialmente establecida al momento de celebración del contrato .<strong>'.$arre_empresa["razon_social"].'</strong> informa al <strong>SUSCRIPTOR</strong> dichas modificaciones a través del medio de determina. <strong>4</strong>. Es responsabilidad de <strong>'.$arre_empresa["razon_social"].'</strong> entrega la señal en el punto seleccionado por el <strong>SUSCRIPTOR</strong> pero no la de efectuar ajustes a los equipos del <strong>SUSCRIPTOR</strong>. <strong>'.$arre_empresa["razon_social"].' </strong>no será responsable por ningún daño que ocurra en los equipos del <strong>SUSCRIPTOR</strong> en desarrollo del presente contrato. <strong>5</strong>. <strong>'.$arre_empresa["razon_social"].'</strong> adjudicara al usuario una y solo una dirección que le permitirá al acceso de la red de internet. TERCERA OBLICACION DEL <strong>SUSCRIPTOR</strong> se compromete. <strong>1</strong>. Permitir el acceso al personal de <strong>'.$arre_empresa["razon_social"].'</strong> al inmueble en el cual instalara el servicio objetivo del presente contrato, al inicio del mismo para su instalación y todas las veces que durante su vigencia <strong>'.$arre_empresa["razon_social"].'</strong> lo considere necesario. <strong>2</strong>. EL <strong>SUSCRIPTOR</strong> pagara a<strong> '.$arre_empresa["razon_social"].'</strong> cada mes anticipadamente las tarifas por concepto la presente del servicio, dentro de las fechas estipuladas. <strong>3</strong>. EL SUSCRPTOR del servicio será único responsable, por el manejo y custodia de la dirección que adjudica para permitir el acceso a internet. <strong>4</strong>. EL <strong>SUSCRIPTOR</strong> acepta pagar por los servicios las tarifas de la presente del servicio solicitado a las alzas que define <strong>'.$arre_empresa["razon_social"].'</strong> y les sean comunicadas con una antelación no inferior de 30 días a la referida alza. <strong>5</strong>. EL <strong>SUSCRIPTOR</strong> manifiesta que reconoce que la obligación del pago recae sobre él y que la no recepción de la factura no lo exime de ella, ni justifica el retardo, razón por la cual se obliga a solicitar la factura en las oficinas de <strong>'.$arre_empresa["razon_social"].'</strong> cuando esta no llegue a tiempo. CUARTA VIGENCIA: La duración del presente contrato por un (1) año(s) y se entiende que empieza a correr en la fecha en que el servicio se entrega al <strong>SUSCRIPTOR</strong> debidamente instalado y funcionando, dicho contrato es renovable automáticamente en periodos iguales y puede ser terminado por el <strong>SUSCRIPTOR</strong> y/o <strong>'.$arre_empresa["razon_social"].'</strong> con acuerdos en las partes, la fecha del presente contrato se acredita la final del PERSONAL: consiste en que persona natural o jurídica tiene al servicio en su domicilió u oficina en 2 tipos de conexión, dependiendo del uso que hace del internet. CONEXIÓN EMPRESARIAL: Es la persona natural o jurídica que tiene en su lugar de trabajo varios computadores; cuya capacidad de ancho de banda supera a la conexión personal para el presente natural o jurídica que tiene en su hogar de trabajo varios computadores, cuya capacidad de ancho de banda supera a la conexión personal para el presente contrato, EL <strong>SUSCRIPTOR</strong> ha elegido la conexión. <strong>'.$arre_query["nombre_plan"].'</strong>. SEXTA. VALOR DEL SERVICIO. <strong>PARAGRAFO PRIMERO.</strong> El valor estipulado es de <strong>'.$arre_query["precio"].'</strong> y se incrementa a los porcentajes y en las fechas que indique la administración de <strong>'.$arre_empresa["razon_social"].' </strong> Al afecto, comunicara al <strong>SUSCRIPTOR</strong> el valor de dicho incremento con una antelación de 30 días al reajuste. <strong>PARAGRAFO SEGUNDO.</strong> Los equipos instalados son en calidad; para el caso de préstamo, el SUSCRIPTOR, debe pagar adicional al valor del plan contratado a suma de <strong>10.000</strong> que corresponde al aseguramiento de los equipos, antes posibles  fallas  técnicas provocadas por fuerza externas, los mismos deben ser entregados en buen estado al ser suspendido el servicio ya sea por petición de SUSCRIPTOR o por <strong>'.$arre_empresa["razon_social"].'</strong> <strong>PARAGRAFO TERCERO.</strong> Los equipos instalados perdida los equipos por <strong>'.$arre_empresa["razon_social"].'</strong> en calidad de préstamo, pueden estar sujetos a cambios y estos pueden ser utilizados para proveer el servicio a otros SUSCRIPTORES. <strong>PARAGRAFO CUARTO.</strong> La pérdida de los  equipos de instalación en calidad de préstamo por <strong>'.$arre_empresa["razon_social"].'</strong> tendrá un costo de BsS.600.000, que serán asumidos por el <strong>SUSCRIPTOR</strong>. <strong>PARAGRAFO QUINTO.</strong> <strong>'.$arre_empresa["razon_social"].'</strong> garantiza una falibilidad de conexión de 95% anual del servicio de internet. En caso de presentar fallas el <strong>SUSCRIPTOR</strong> debería comunicarse a <strong>'.$arre_empresa["razon_social"].'</strong> y estas deberán ser resueltas en un tiempo de <strong>24 horas hábiles;</strong> <strong>'.$arre_empresa["razon_social"].'</strong> no responde ni reconocerá descuentos por el mal funcionamiento del servicio especialmente en los siguientes eventos: <strong>1</strong>. Si el cliente incumple los requerimientos mínimos necesarios en su equipo informático. <strong>2</strong>. En el caso de los equipos instalados por <strong>'.$arre_empresa["razon_social"].'</strong> que no se encuentren protegidos por el <strong>suscriptor</strong>, bajo reguladores de electricidad o UPS. <strong>3</strong>. Se impida el acceso al personal de <strong>'.$arre_empresa["razon_social"].'</strong> para la ejecución de las actividades previas que contribuyan a solventar el problema. <strong>4</strong>. Cuando el servicio sea interrumpido  o suspendido por razones de equipamiento, trabajos de ingeniería o cualquier trabajo de reparación necesarias a juicio de <strong>'.$arre_empresa["razon_social"].'</strong> para su correcto funcionamiento. <strong>PARAGRAFO SEXTO.</strong> En caso de mora de 3 días vencidos en el pago por parte del cliente el servicio de internet será restringido, después de 30 días de mora se dará por terminado el contrato y se precederá a retirar los equipos instalados en calidad de préstamo. <strong>PARAGRAFO SEPTIMO.</strong> El máximo de computadores que se permitirá el acceso a la red determina según las características del plan adquirido y el tipo de conexión, '.$arre_empresa["razon_social"].' solo se compromete a dejar instalado a funcionando el servicio de internet en computador (1 metro de cable Patchecord, Poe y antena); el cliente deberá asumir el costo adicional para instalar el servicio a otro equipo, <strong>'.$arre_empresa["razon_social"].'</strong> solo se compromete a proveer el servicio de internet, cualquier reparación o mantenimiento del equipo informático es responsabilidad del SUSCRITOR. <strong>PARAGRAFO OCTAVO.</strong> El <strong>SUSCRIPTOR</strong> debe informar con (3) dias de anticipación la suspensión del servicio temporalmente por motivos de viaje o averias que comprometan el uso del servicio. <strong>PARAGRAFO NOVENO.</strong> El <strong>SUSCRIPTOR</strong> solo utilizará SERVICIO para los fines enmarcados dentro de las leyes y regulaciones vigentes. Cualquier intercambio de información, datos o material que viole las leyes nacionales o internacionales está expresamente prohibido y será responsabilidad exclusiva del <strong>SUSCRIPTOR</strong> . En caso de sanciones por cualquier violación de esta índole, el <strong>SUSCRIPTOR</strong> acepta expresamente que <strong>'.$arre_empresa["razon_social"].'</strong> no tiene responsabilidad alguna y por tanto no responderá por cualquier reclamación o demanda que resultare del uso que el <strong>SUSCRIPTOR</strong> le haya dado al SERVICIO, causando daños a terceras personas naturales o jurídicas.
          </td>
        </tr>
        
      </table>

      

      <table class="firma">
        <tr>
          <th class="text-ce"><strong>___________________________<br/>Firma Técnico</strong></th>
          <th class="text-ce"><strong>___________________________<br/>Firma Suscriptor</strong></th>
          <th class="text-ce-huella"></th>
        </tr>
        
         
      </table>
     
      </table>
</body>';

$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($contrato, \Mpdf\HTMLParserMode::HTML_BODY);
$nombre=$arre_query["nombres"];
$mpdf->Output();

}
?>
