<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/funciones_api.class.php");
    $obj_api = new funciones_api;
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
                                <h5 class="m-b-10">Suspender Servicio</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card">
                            <form action="./suspender.php" method="GET">
                                <div class="suspender__select responsive p-3"><strong>Seleccione la fecha de corte:</strong>
                                    <select name="dia" id="dia-sel" class="form-control">
                                        <option value=""> ---Día--- </option>

                                        <?php $obj_company->puntero = $obj_company->fechaCorte();
                                        while (($dia = $obj_company->extraer_dato()) > 0) {
                                        ?>
                                            <option value="<?php echo $dia['cod_fec_corte']; ?>"> <?php echo $dia['dia_fec_corte']; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div style="padding:10px;"><button type="submit" class="btn btn-block btn-danger">Suspender</button></div>
                            </form>
                            <br>

                            <?php if ($_GET['dia'] != "") { ?>

                                <div>
                                    <div class="card-header">Clientes Suspendidos </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Contrato</th>
                                                        <th>Nombre/Razon</th>
                                                        <th>IP</th>
                                                        <th>Día de Corte</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $obj_company->cod_fec_corte = $_GET['dia'];
                                                    $obj_company->asignar_valor();
                                                    $obj_company->puntero = $obj_company->usuariosSusPorFecha();
                                                    while (($corte = $obj_company->extraer_dato()) > 0) { ?>
                                                        <tr>
                                                            <td><?php echo $idcontratos = $corte['num_contrato']; ?></td>
                                                            <td><?php echo $cliente = $corte['nom_cli']; ?></td>
                                                            <td><?php echo $ip = $corte['ip_contrato']; ?></td>
                                                            <td><?php echo $corte['dia_fec_corte'] . " De Cada Mes"; ?></td>

                                                        </tr>
                                                        <?php
                                                        $obj_api->nombres = $cliente;
                                                        $obj_api->contrato = $idcontratos;
                                                        $obj_api->ip_contrato = $ip;

                                                        $obj_api->ip_router_api = $corte['ip_router'];
                                                        $obj_api->login_api = $corte['user_router'];
                                                        $obj_api->password_api = $corte['pass_router'];
                                                        $obj_api->port_api = $corte['puerto_router'];
                                                        $obj_api->blacklist_api = $corte['blacklist_router'];
                                                        $obj_api->whitelist_api = $corte['whitelist_router'];

                                                        $obj_api->asignar_valor_api();
                                                        $obj_api->connect();
                                                        $obj_api->remove_whitelist();
                                                        ?>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

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

    <!-- Apex Chart -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>


    <!-- custom-chart js -->
    <script src="../assets/js/pages/dashboard-main.js"></script>

    <!-- Codigo de Funcionamiento -->
    <script>
        $('#dia-sel').val(<?php echo $_GET['dia']; ?>);
    </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>