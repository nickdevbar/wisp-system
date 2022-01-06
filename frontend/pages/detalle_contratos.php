<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/cliente.class.php");

    $obj_cliente = new cliente;

    $obj_company = new company;

    $obj_cliente->cod_cli = $_GET["cod_cli"];
    $obj_cliente->asignar_valor();
    $obj_cliente->puntero = $obj_cliente->detalleContrato();
    $cli = $obj_cliente->extraer_dato();

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    $obj_cliente->puntero = $obj_cliente->ultimaFactura();
    $u = $obj_cliente->extraer_dato();

    $nf = $u['num_factura'] + 1;
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
                                <h5 class="m-b-10">Completar el contrato</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">Detalles del contrato</h6>
                            </div>
                            <div class="card-body">
                                <div class="half">
                                    <h5 class="text-primary"><?php echo $cli['nom_cli'] . " - Contrato #" . $cli['num_contrato'] ?> <i class="fas fa-check text-success"></i></h5>

                                    <div><strong>MAC:</strong><input type="text" id="mac" class="form-control"></div>

                                    <div class="mt-2"><strong>IP:</strong>
                                        <select name="" id="ips" class="form-control">
                                            <option value="">-----</option>

                                            <?php $obj_cliente->puntero = $obj_cliente->ipes();
                                            while (($ip = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $ip['cod_ip']; ?>"><?php echo $ip['ip_contrato']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <div class="mt-2"><strong>Planes:</strong>
                                        <select name="" id="pla" class="form-control">
                                            <option value="">-----</option>

                                            <?php $obj_cliente->puntero = $obj_cliente->plan();
                                            while (($pl = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $pl['cod_plan'] . "-" . $pl['pre_plan']; ?>"><?php echo $pl['nom_plan']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <br>

                                    <div><button class="btn btn-success btn-block" id="but" onclick="completarRegistro();">Completar Contrato <i class="fas fa-check"></i></button></div>


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

    <!-- InputMask MAC -->
    <script src="../assets/inputmask/dist/jquery.inputmask.js"></script>
    <script src="../assets/inputmask/dist/bindings/inputmask.binding.js"></script>
    <script src="../assets/inputmask/dist/bindings/inputmask.binding.js"></script>
    <script src="../assets/inputmask/lib/extensions/inputmask.extensions.js"></script>
    <script>
            $('#mac').inputmask("mac");
        </script>

    <!-- Codigo de Funcionamiento -->
    <script>
            const completarRegistro = () => {

                let cli = '<?php echo $_GET["cod_cli"] ?>';
                let cod = '<?php echo $cli["cod_contratos"] ?>'
                let fec = '<?php echo $cli["cod_fec_corte"] ?>'
                let mac = $('#mac').val();
                let ips = $('#ips').val();
                let ip = $('#ips option:selected').text();
                let pla = $('#pla').val();

                let cutted = pla.split('-');
                let cod_pla = cutted[0];
                let pre = cutted[1];

                dataString = "num_contrato=<?php echo $cli['num_contrato']; ?>"+"&&nombres=<?php echo $cli['nom_cli']; ?>"+"&&clientes_cod_cli=" + cli + "&&contratos_cod_contratos=" + cod + "&&mac_det_con=" + mac + "&&ips_cod_ip=" + ips + "&&planes_cod_plan=" + cod_pla + "&&ip_contrato=" + ip + "&&pre_plan=" + pre + "&&fecha_corte=" + fec + "&&num_factura=<?php echo $nf ?>" + "&&accion=completarContrato";
                console.log(dataString);

                if (mac == "" || ips == "" || pla == "") {
                    Swal.fire(
                        'Campos Vacios!',
                        '',
                        'warning'
                    )
                } else {
                    $.ajax({
                        data: dataString,
                        url: "../../backend/controlador/cliente/cliente.php?rou=<?php echo $cli['routers_cod_router']; ?>",
                        type: "POST",
                        success: function(response) {
                            console.log(response);
                            location.href = "perfil_cliente.php?contrato=" + cod;

                        }
                    });
                }

            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>