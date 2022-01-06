<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/factura.class.php");
    $obj_factura = new factura;
    $obj_factura->cod_fac = $_GET["cod_fac"];
    $obj_factura->asignar_valor();
    $obj_factura->puntero = $obj_factura->facturaPaga();
    $factura = $obj_factura->extraer_dato();



    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    date_default_timezone_set("America/Bogota");
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
                                <h5 class="m-b-10">Pago Completado Factura#<?php echo $_GET['cod_fac'] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card">
                            <div class="card-body">

                                <div style="text-align:center;">
                                    <div class="fac_section_pago">
                                        <div class="company_pago">
                                            <div class="com_logo_pago"><img style="width:100%;" src="../assets/images/logos/<?php echo $emprise['logo_company']; ?>" alt=""></div>
                                            <div>
                                                <div>
                                                    <h5 class="font-weight-bold h5"><?php echo $emprise['razon_social']; ?> <?php echo $emprise['tipo_company'] . $emprise['rif_company']; ?></h5>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold h6"><?php echo $emprise['dir_company']; ?></h5>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold h6"><?php echo $emprise['fanpage_company']; ?></h5>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold h6"><?php echo $emprise['ema_company']; ?></h5>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold h6"><a href="https://wa.me/<?php echo $emprise['tel_company']; ?>"><?php echo $emprise['tel_company']; ?></a></h5>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="factura">

                                            <div class="fac_items_pagos">
                                                <p>Cliente:</p>
                                                <strong>
                                                    <a href="./perfil_cliente.php?contrato=<?php echo $factura['cod_contratos'] ?>"><?php echo $factura['nom_cli'] ?></a><br>
                                                    Dirección: <?php echo $factura['dir_cli'] ?><br>
                                                    Telefono:<?php echo $factura['tel_cli'] ?><br>
                                                    Em@il:<?php echo $factura['ema_cli'] ?>



                                                </strong>
                                            </div>
                                            <div class="fac_items_pagos">
                                                <p>Fecha:</p><strong><?php echo date('g:i a - j / m / o '); ?></strong>
                                            </div>
                                            <div class="fac_items_pagos">
                                                <p>Caja:</p><strong><?php echo $_SESSION['nom_usu'] . " " . $_SESSION['ape_usu'] ?></strong>
                                            </div>
                                            <div class="fac_items_pagos">
                                                <p>Metodo De Pago:</p><strong><?php echo $factura['nom_for_pag'] ?></strong>
                                            </div>
                                        </div>



                                        <hr>

                                        <div class="list">

                                            <div class="list-grup">
                                                <div class="list-item">
                                                    <p>Descripción:</p>
                                                    <strong><?php echo $factura['des_fac']; ?></strong>
                                                </div>

                                                <div class="list-item">
                                                    <p>Observación:</p>
                                                    <strong><?php echo $factura['obs_pag_fac']; ?></strong>
                                                </div>
                                                <div class="list-item">
                                                    <p>Monto Recibido:</p>
                                                    <strong><?php echo $obj_factura->pesos($factura['mon_pag_fac']); ?></strong>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="exit-btn-pago">
                                    <div>
                                    <a href="./perfil_cliente.php?contrato=<?php echo $_GET['contrato'] ?>" class="btn btn-success">Volver al perfil <i class="fas fa-user"></i></a>
                                    </div>
                                    <div style="text-align:right;">
                                    <!-- <a href="./perfil_cliente.php?contrato=<?php echo $_GET['contrato'] ?>" class="btn btn-warning">Imprimir <i class="fas fa-print"></i></a> -->
                                    <a href="../email/recibo_pago.php?cod_contratos=<?php echo $_GET['contrato'] ?>&cod_fac=<?php echo $_GET['cod_fac'] ?>" target="_blank" class="btn btn-primary">Enviar Pago <i class="fas fa-envelope"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
            
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

    <script>
            if (<?php echo $_GET['val'] ?> == 1) {
                Swal.fire(
                    'Pago Registrado!!',
                    'Puedes enviar el recibo, o regresar al perfil',
                    'success'
                )
            }
        </script>


</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>