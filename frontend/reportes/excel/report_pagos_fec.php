<style>
    table,
    td {
        border: 1px solid black;
        width: 25%;
    }

    .final {

        padding: 0.3em;
        color: #fff;
        background: #000;
    }
</style>
<?php

session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../../backend/clase/factura.class.php");
    $obj_factura = new factura();

    // La cabecera se sobrescribe, pues el parámetro opcional "replace" por defecto vale true.
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=Reporte de Pagos ".date('Y-m-d').".xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", true);

    if ($_GET["fecha"] != "") {
        $obj_factura->fecha = $_GET["fecha"];
        $obj_factura->asignar_valor();
    }

    $report = '<table>
                <tr>
                    <th colspan="9"><h2>Reporte de Pago</h2></th>
                </tr>
                <tr>
                                                        <th>Contrato</th>
                                                        <th>Cliente</th>
                                                        <th>N° Factura</th>
                                                        <th>Monto</th>
                                                        <th>Plan</th>
                                                        <th>Mes/Año</th>
                                                        <th>Observación</th>
                                                        <th>Forma Pago</th>
                                                        <th>Fecha</th>
                                                    
                                                        
                                                    </tr>';

    $obj_factura->puntero = $obj_factura->todosPagos();
    while (($arreglo = $obj_factura->extraer_dato()) > 0) {
    $acum = $acum + $arreglo['mon_pag_fac'];
    
        //$monto=$mont_exp["0"];
        $report .= '<tr aling="center">
                        <td>' . $arreglo['num_contrato']  . '</td>
                        <td>' . $arreglo['nom_cli'] . '</td>
                        <td>' . $arreglo['num_factura'] . '</td>
                        <td>' . $obj_factura->pesos($arreglo['mon_pag_fac']) . '</td>
                        <td>' . $arreglo['nom_plan'] . '</td>
                        <td>' . $arreglo['mes_fac']." - ".$arreglo['ano_fac'] . '</td>
                        <td>' . $arreglo['obs_pag_fac'] . '</td>
                        <td>' . $arreglo['nom_for_pag'] . '</td>
                        <td>' . $obj_factura->formatearFechaPrimero($arreglo['fec_pag_fac']) . '</td>
                    </tr>';
    }


    $report .= '<tr><th colspan="9" class="final">Total Recaudado: ' . $obj_factura->pesos($acum). '</th>
            </tr>
          </table>';

    echo $report;
} else {
    header("location: ../../../index.php");
    exit();
}

?>