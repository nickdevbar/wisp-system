<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/mantenimiento.class.php");
    $obj_mantenimiento = new mantenimiento;
    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    if ($_GET["fecha"] != "") {
        $obj_mantenimiento->fecha = $_GET["fecha"];
        $obj_mantenimiento->asignar_valor();
    }
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
                                <h5 class="m-b-10">Mantenimientos Realizados</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-warning">Historico De Mantenimientos</h6>
                                </div>
                                <div class="card-body">

                                    <div>
                                        <div><input type="date" id="fecha" class="form-control"></div>

                                        <div style="text-align:right;" class="mt-1">
                                            <button onclick="todos();" class="btn btn-warning btn-sm"> Ver Todos </button>
                                            <button onclick="fecha();" class="btn btn-info btn-sm"> Buscar <i class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                    <br>

                                    <?php if ($_GET["fecha"] == "") { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Contrato</th>
                                                        <th>Cliente</th>
                                                        <th>Dirección</th>
                                                        <th>Falla</th>
                                                        <th>Solucion</th>
                                                        <th>Reportado</th>
                                                        <th>Solucionado</th>
                                                        <th>Tecnico</th>
                                                        <th>Opción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $obj_mantenimiento->puntero = $obj_mantenimiento->realizados();
                                                    while (($man = $obj_mantenimiento->extraer_dato()) > 0) { ?>
                                                        <tr>
                                                            <td><?php echo "<a href='perfil_cliente.php?contrato=" . $man['num_contrato'] . "'>" . $man['num_contrato'] . "</a>"; ?></td>
                                                            <td><?php echo $man['nom_cli']; ?></td>
                                                            <td><?php echo $man['dir_cli']; ?></td>
                                                            <td><?php echo $man['nom_fallas']; ?></td>
                                                            <td><?php echo $man['sol_act_man']; ?></td>
                                                            <td><?php echo $obj_mantenimiento->formatearFechaPrimero($man['fec_man']); ?></td>
                                                            <td><?php echo $obj_mantenimiento->formatearFechaPrimero($man['fec_act_man']); ?></td>
                                                            <td><?php echo $man['nom_usu']; ?></td>

                                                            <td>
                                                                <a href="../reportes/mantenimiento_r.php?cod_man=<?php echo $man['cod_man']; ?>" target="_blank" class="btn btn-sm btn-warning" title="Imprimir"><i class="fas fa-print"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        
                                                        <th>Contrato</th>
                                                        <th>Cliente</th>
                                                        <th>Dirección</th>
                                                        <th>Falla</th>
                                                        <th>Solucion</th>
                                                        <th>Reportado</th>
                                                        <th>Solucionado</th>
                                                        <th>Tecnico</th>
                                                        <th>Opción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $obj_mantenimiento->puntero = $obj_mantenimiento->realizadosPorFecha();
                                                    while (($man = $obj_mantenimiento->extraer_dato()) > 0) { ?>
                                                        <tr>
                                                            <td><?php echo "<a href='perfil_cliente.php?contrato=" . $man['num_contrato'] . "'>" . $man['num_contrato'] . "</a>"; ?></td>
                                                            <td><?php echo $man['nom_cli']; ?></td>
                                                            <td><?php echo $man['dir_cli']; ?></td>
                                                            <td><?php echo $man['nom_fallas']; ?></td>
                                                            <td><?php echo $man['sol_act_man']; ?></td>
                                                            <td><?php echo $obj_mantenimiento->formatearFechaPrimero($man['fec_man']); ?></td>
                                                            <td><?php echo $obj_mantenimiento->formatearFechaPrimero($man['fec_act_man']); ?></td>
                                                            <td><?php echo $man['nom_usu']; ?></td>

                                                            <td>
                                                                <a href="../reportes/mantenimiento_r.php?cod_man=<?php echo $man['cod_man']; ?>" target="_blank" class="btn btn-sm btn-warning" title="Imprimir"><i class="fas fa-print"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
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
            if(<?php echo $_GET["fecha"]?> != ""){
                $('#fecha').val('<?php echo $_GET["fecha"];?>');
            }
        </script>

        <script>

            const fecha = () => {
                let fecha = $('#fecha').val();

                if (fecha != "") {
                    location.href = 'historico_mantenimientos.php?fecha=' + fecha;
                } else {
                    Swal.fire(
                        'Selecciona una fecha!',
                        '',
                        'warning'
                    )
                }
            }

            const todos = () => {
                location.href = 'historico_mantenimientos.php';
            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>