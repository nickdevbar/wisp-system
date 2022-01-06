<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/factura.class.php");
    $obj_company = new company;
    $obj_factura = new factura;

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
                                <h5 class="m-b-10">Caja Diaria</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card shadow mb-4">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Metodo de Pago</th>
                                                <th>Cantidad</th>
                                                <th>Monto</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            <?php $obj_factura->puntero = $obj_factura->caja();
                                                  while (($pag = $obj_factura->extraer_dato()) > 0) { 
                                            $tot = $tot  + $pag['total'];
                                            $pago = $pago + $pag['monto'];
                                            ?>
                                            <tr>
                                                <td><?php echo $pag['nom_for_pag'];?></td>
                                                <td><?php echo $pag['total']; ?></td>
                                                <td>$<?php echo $obj_factura->pesos($pag['monto']); ?></td>
                                            </tr>
                                            <?php  } 
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td>Total Pagos Registrados: <b><?php echo $tot?></b></td>
                                                <td>Total Recaudado:  <b>$<?php echo $obj_factura->pesos($pago) ?></b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-right"><button onclick="cerrar_caja();" class="btn btn-success">Cerrar Caja <i class="fas fa-dollar-sign"></i></button></div>

                            </div>

                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Pagos de Mensualidad</h6>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#Factura</th>
                                                <th>Contrato</th>
                                                <th>Cliente</th>
                                                <th>Monto</th>
                                                <th>Observación</th>
                                                <th>Forma De Pago</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $obj_factura->puntero = $obj_factura->facturasCaja();
                                            while (($fac = $obj_factura->extraer_dato()) > 0) { ?>
                                                <tr>
                                                    <td><?php echo $fac['num_factura'];?></td>
                                                    <td><?php echo "<a href='perfil_cliente.php?contrato=" . $fac['cod_contratos'] . "'>#" . $fac['num_contrato'] . "</a>"; ?></td>
                                                    <td><?php echo $fac['nom_cli']; ?></td>
                                                    <td>$<?php echo $obj_factura->pesos($fac['mon_pag_fac']); ?></td>
                                                    <td><?php echo $fac['obs_pag_fac']; ?></td>
                                                    <td><?php echo $fac['nom_for_pag']; ?></td>
                                                    <td><?php echo $obj_factura->formatearFechaPrimero($fac['fec_pag_fac']); ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
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
            const cerrar_caja = () =>{
                Swal.fire({
                    title: '¿Seguro que desea cerrar la caja?',
                    html: '<strong> Motivo de cierre de caja:</strong><textarea id="swal-input1" class="swal2-input" placeholder="Termino el dia....." style="width:80%;resize:none;height:150px;"></textarea>',
                    focusConfirm: false,
                    confirmButtonColor: '##4e73df',
                    confirmButtonText: 'Cerrar la caja',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        let mot = document.getElementById('swal-input1').value;
                        let mensaje = "Se Cerro la caja por: " + mot;

                        dataString = "mon_caj_dia=<?php echo $pago?>" + "&&obs_caj_dia=" + mensaje + "&&accion=cerrarCaja";
                        console.log(dataString);
                        $.ajax({
                            type: "POST",
                            url: "../../backend/controlador/factura/factura.php",
                            data: dataString,
                            success: function(r) {
                                Swal.fire(
                                    'Caja Cerrada!',
                                    '',
                                    'success'
                                )
                                location.reload();

                            }
                        });

                    }
                })
            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>