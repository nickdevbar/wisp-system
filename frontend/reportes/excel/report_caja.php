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
    header("Content-Disposition: attachment; filename=Reporte de Cajas ".date('Y-m-d').".xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", true);

    if ($_GET["fecha"] != "") {
        $obj_factura->fecha = $_GET["fecha"];
        $obj_factura->asignar_valor();
    }

    $report = '<table>
                <tr>
                    <th colspan="4"><h2>Reporte de Cajas</h2></th>
                </tr>
                <tr>
                                                        <th>Monto Total</th>
                                                        <th>Observación</th>
                                                        <th>Usuario</th>
                                                        <th>Fecha</th>
                                                        
                                                    </tr>';

    $obj_factura->puntero = $obj_factura->todosCajas();
    while (($caja = $obj_factura->extraer_dato()) > 0) {
    $acum = $acum + $caja['mon_caj_dia'];
    
        //$monto=$mont_exp["0"];
        $report .= '<tr aling="center">
                        <td>' . $obj_factura->pesos($caja['mon_caj_dia']) . '</td>
                        <td>' . $caja['obs_caj_dia'] . '</td>
                        <td>' . $caja['nom_usu'] . '</td>
                        <td>' . $obj_factura->formatearFechaPrimero($caja['fec_caj_dia']) . '</td>
                    </tr>';
    }


    $report .= '<tr><th colspan="4" class="final">Total Cajas: ' . $obj_factura->pesos($acum). '</th>
            </tr>
          </table>';

    echo $report;
} else {
    header("location: ../../../index.php");
    exit();
}

?>



