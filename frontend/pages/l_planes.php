<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/plan.class.php");

    $obj_company = new company;
    $obj_plan = new plan;

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
        <div class="modal" id="add_planes" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"></div>
        <div class="modal" id="edit_planes" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"></div>

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

                                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                        <h5 class="m-b-10">Planes</h5>

                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#add_planes" onclick="carga_ajax('1','add_planes','../modal/modal_add_planes.php');" class="d-sm-inline-block btn btn-success shadow-sm"><i class="fas fa-plus-square fa-sm text-white-50"></i> Agregar Plan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <!-- [ Main Content ] start -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista De Planes</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Upload</th>
                                        <th>Download</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $obj_plan->puntero = $obj_plan->listar();
                                    while (($arreglo = $obj_plan->extraer_dato()) > 0) { ?>
                                        <tr>
                                            <td><?php echo $arreglo['nom_plan']; ?></td>
                                            <td><?php echo $obj_plan->pesos($arreglo['pre_plan']); ?></td>
                                            <td><?php echo $arreglo['vel_sub_plan'] . $arreglo['tx']; ?></td>
                                            <td><?php echo $arreglo['vel_des_plan'] . $arreglo['rx']; ?></td>
                                            <td>

                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_planes" onclick="carga_ajax('<?php echo $arreglo['cod_plan']; ?>','edit_planes','../modal/modal_edit_planes.php');" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                                                <a href="#" onclick="eliminarPlan(<?php echo $arreglo['cod_plan']; ?>);" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>

                                            </td>
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

        <!-- Apex Chart -->
        <script src="../assets/js/plugins/apexcharts.min.js"></script>


        <!-- custom-chart js -->
        <script src="../assets/js/pages/dashboard-main.js"></script>

        <!-- Codigo de Funcionamiento -->
        <script>
            const eliminarPlan = (cod) => {
                console.log(cod);
                Swal.fire({
                    title: '¿Seguro que desea eliminar el plan?',
                    text: "",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, estoy seguro',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: "cod_plan="+cod+"&&accion=deletePlan",
                            url: "../../backend/controlador/funciones/funciones.php",
                            type: "POST",
                            success: function(response) {
                                console.log("Creado Exitoso");
                                Swal.fire(
                                    'Plan Eliminado',
                                    '',
                                    'success'
                                )
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire(
                            'No se realizo ningun cambio'
                        )
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