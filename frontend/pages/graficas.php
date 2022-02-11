<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/graficas.class.php");

    $obj_graficas = new graficas;


    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php require('../public/title.php') ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/stylos.css">

    <!-- DataTables -->
    <link href="../assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">



</head>

<body class="">
        
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <?php require_once('./menu.php'); ?>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <?php require_once('./topbar.php'); ?>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Graficas</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <!---------------POR FECHA DE PAGO------------------------------------------------>
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Resumen.</h6>
                            </div>
                            <div class="card-body">
                                <div class="two-tables responsive">
                                    <div class="table-responsive">
                                        <strong>Por Fecha De Pago.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Dia</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->fecha_corte();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $arreglo["dia_fec_corte"]; ?></td>
                                                        <td><?php echo $arreglo["dia_pago"]; ?></td>

                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <strong>Por Tipo Instalación.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Tipo De Instalación</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->tipo_instalacion();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) { 
                                                ?>
                                                <tr>
                                                    <td><?php echo $arreglo["nom_tipo_ins"]; ?></td>
                                                    <td><?php echo $arreglo["total"]; ?></td>

                                                </tr>
                                                <?php } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------------------------------------->

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Control.</h6>
                            </div>
                            <div class="card-body">
                                <div class="tables">
                                    <div class="table-responsive">
                                        <strong>Facturas Por Mes.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Mes</th>
                                                    <th>Total Pagos</th>
                                                    <th>Total Recaudado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->total_recaudado_mensual_factura();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                    $total_pagos = $total_pagos + $arreglo["total_factura"];
                                                    $total_anual = $total_anual + $arreglo["monto_total"];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $arreglo["mes"]; ?></td>
                                                        <td><?php echo $arreglo["total_factura"]; ?></td>
                                                        <td><?php echo $obj_graficas->pesos($arreglo["monto_total"]); ?></td>
                                                    </tr>
                                                <?php }
                                                ?>

                                                <tr>
                                                    <td></td>
                                                    <td><b>Total</b> = <?php echo $total_pagos; ?></td>
                                                    <td><b>Total</b> = <?php echo $obj_graficas->pesos($total_anual); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--------------------------------------------------------------->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Clientes.</h6>
                            </div>
                            <div class="card-body">
                                <div class="two-tables responsive">
                                    <div class="table-responsive">
                                        <strong>Instalación Por Técnico.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Tecnico</th>
                                                    <th>Mes</th>
                                                    <th>Total Instalaciónes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->instalacion_tecnico();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $arreglo["nom_usu"]; ?></td>
                                                        <td><?php echo $arreglo["mes"]; ?></td>
                                                        <td><?php echo $arreglo["total_instalacion"]; ?></td>

                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <strong>Clientes Por Plan.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Clientes</th>
                                                    <th>Plan</th>
                                                    <th>Precio</th>
                                                    <th>Monto Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->listaMB();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $arreglo["total_usuarios"]; ?></td>
                                                        <td><?php echo $arreglo["nom_plan"]; ?></td>
                                                        <td><?php echo $obj_graficas->pesos($arreglo["precio"]); ?></td>
                                                        <td><?php echo $obj_graficas->pesos($arreglo["total_por_plan"]); ?></td>

                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <br>
                                <!---------------------------------------------------------->
                                <div class="two-tables responsive">
                                    <!-- <div class="table-responsive">
                                        <strong>Clientes Por Sector.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Sector</th>
                                                    <th>Total Clientes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php //$obj_graficas->puntero = $obj_graficas->listaSector();
                                                //while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $arreglo["nom_sector"]; ?></td>
                                                        <td><?php echo $arreglo["total"]; ?></td>

                                                    </tr>
                                                <?php //}
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> -->

                                    <div class="table-responsive">
                                        <strong>Clientes Por Segmento.</strong>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Segmento</th>
                                                    <th>Total Clientes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $obj_graficas->puntero = $obj_graficas->listaSegmento();
                                                while (($arreglo = $obj_graficas->extraer_dato()) > 0) {
                                                ?>
                                                    <tr>

                                                        <td><?php echo $arreglo["seg_ip"]; ?></td>
                                                        <td><?php echo $arreglo["total"]; ?></td>

                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!---------------------------------------------------------->
                            </div>
                        </div>
                        <!--------------------------------------------------------------->
            
                <!-- table card-1 end -->
                <!-- table card-2 start -->
                
                <!-- Widget primary-success card end -->

                <!-- prject ,team member start -->
                
                
                <!-- prject ,team member start -->
                <!-- seo start -->
               
               
                <!-- seo end -->

                <!-- Latest Customers start -->
                
                
                <!-- Latest Customers end -->
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="../assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="../assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="../assets/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="../assets/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="../assets/images/browser/ie.png" alt="">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Js -->
    <script src="../assets/js/vendor-all.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../modal/idmodal.js"></script>

    <!-- DataTables -->
    <script src="../assets/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
                $('#dataTable2').DataTable();
                $('#dataTable3').DataTable();
                $('#dataTable4').DataTable();
                $('#dataTable5').DataTable();
            });
        </script>

    <!-- Apex Chart -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>


    <!-- custom-chart js -->
    <script src="../assets/js/pages/dashboard-main.js"></script>

    <!-- Codigo de Funcionamiento -->

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>